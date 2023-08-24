<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\LogInvoiceController;
use App\Http\Controllers\Api\LogTransactionController;
use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    protected $logInvoiceController;
    protected $logTransactionController;

    public function __construct()
    {
        $this->logInvoiceController = new LogInvoiceController();
        $this->logTransactionController = new LogTransactionController();
    }

    public function processCheckout(Request $request)
    {
        // First, validate the overall request, you can add any additional fields you expect here.
        $validate = Validator::make($request->all(), [
            'nomor_invoice' => 'required|string',
            'nama_invoice' => 'required|string',
            'asal_transaksi' => 'required|string',
            'contact_number' => 'required|string',
            'address_invoice' => 'required|string',
            'total_transaksi' => 'required|integer',
            'id_user' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        // Next, create the LogInvoice entry.
        $logInvoiceResponse = $this->logInvoiceController->store($request);
        error_log($logInvoiceResponse);
        $invoiceData = json_decode($logInvoiceResponse->content());

        if (!isset($invoiceData->id_invoice)) {
            return response()->json(['errors' => 'Invoice creation failed'], 500);
        }

        // Now, loop through the products in the request and add them to the LogTransaction.
        foreach ($request->cart as $product) {
            $productRequest = new Request([
                'id_invoice' => $invoiceData->id_invoice,
                'id_produk' => $product['id_produk'],
                'jumlah_produk_invoice' => $product['jumlah_produk_invoice'],
                'total_harga_produk' => $product['total_harga_produk'],
            ]);

            $this->logTransactionController->addProductToInvoice($productRequest);
        }

        $deletedRows = Cart::where('id_user', $request->id_user)->delete();

        if ($deletedRows > 0) {
            return response()->json(['message' => 'Checkout processed and cart deleted successfully'], 201);
        } else {
            return response()->json(['message' => 'Checkout processed but cart was empty or not found'], 201);
        }

        return response()->json(['message' => 'Checkout processed successfully'], 201);
    }
}
