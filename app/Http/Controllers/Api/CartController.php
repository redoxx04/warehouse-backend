<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\LogTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::all();

        return response()->json($carts);
    }

    public function addToCart(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id_user' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah_produk_invoice' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        // $product = Product::find($request->id_produk);

        // if (!$product) {
        //     return response()->json(['error' => 'Product not found'], 404);
        // }

        $cart = Cart::firstOrNew([
            'id_user' => $request->id_user,
            'id_produk' => $request->id_produk,
            // 'attributes' => [] // Additional attributes if required
        ]);

        if ($cart->exists) {
            $cart->increment('jumlah_produk_invoice', $request['jumlah_produk_invoice']);
        } else {
            $cart->jumlah_produk_invoice = $request['jumlah_produk_invoice'];
            $cart->save();
        }

        return response()->json($cart, 201);
    }

    public function viewCart(Cart $cart)
    {
        return response()->json($cart);
    }

    public function viewCartByUser(User $user)
    {
        // Fetch all cart items for the user along with their associated products
        $carts = $user->carts()->with('products')->get();
        return response()->json($carts);
    }

    public function checkout(Request $request)
    {
        // Assuming you have user authentication in place and can get the current user's ID
        $userId = auth()->user()->id;

        $cartItems = Cart::getContent();

        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        // Create a new LogInvoice entry here as needed

        foreach ($cartItems as $item) {
            LogTransaction::create([
                'id_invoice' => $invoiceId, // Assuming you've created an invoice entry above
                'id_produk' => $item->id,
                'jumlah_produk_invoice' => $item->quantity,
                'total_harga_produk' => $item->quantity * $item->price,
            ]);
        }

        // Clear the cart after checkout
        Cart::clear();

        return response()->json(['message' => 'Checkout successful']);
    }
}
