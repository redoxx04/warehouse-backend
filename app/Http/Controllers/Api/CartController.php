<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\LogInvoices; // Assuming this is the name of your invoice model
use App\Models\LogTransaction;
use App\Models\Product;
use Cart as ShoppingCart;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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
            'id_produk' => 'required|integer',
            'jumlah_produk_invoice' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $product = Product::find($request->id_produk);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        ShoppingCart::add([
            'id' => $product->id_produk,
            'name' => $product->nama_produk,
            'price' => $product->harga_produk,
            'quantity' => $request->jumlah_produk_invoice,
            'attributes' => [] // Additional attributes if required
        ]);

        return response()->json(['message' => 'Product added to cart successfully']);
    }

    public function viewCart()
    {
        $cartItems = ShoppingCart::getContent();
        return response()->json($cartItems);
    }

    public function removeFromCart(Request $request, $id)
    {
        ShoppingCart::remove($id);
        return response()->json(['message' => 'Product removed from cart']);
    }

    public function checkout(Request $request)
    {
        // Assuming you have user authentication in place and can get the current user's ID
        $userId = auth()->user()->id;

        $cartItems = ShoppingCart::getContent();

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
        ShoppingCart::clear();

        return response()->json(['message' => 'Checkout successful']);
    }
}
