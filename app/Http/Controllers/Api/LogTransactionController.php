<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class LogTransactionController extends Controller
{
    public function index()
    {
        $log_transactions = LogTransaction::with(['log_invoice', 'produk'])->get();

        return response()->json($log_transactions);
    }

    public function addProductToInvoice(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id_invoice' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah_produk_invoice' => 'required|integer',
            'total_harga_produk' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $log_transaction = LogTransaction::create([
            'id_invoice' => $request->id_invoice,
            'id_produk' => $request->id_produk,
            'jumlah_produk_invoice' => $request->jumlah_produk_invoice,
            'total_harga_produk' => $request->total_harga_produk,
        ]);

        return response()->json($log_transaction, 201);
    }

    public function getProductsOfInvoice($invoice_id)
    {
        $products = LogTransaction::where('id_invoice', $invoice_id)
                                  ->with('produk')
                                  ->get();

        return response()->json($products);
    }

    public function show(LogTransaction $log_transaction)
    {
        $log_transaction->load(['log_invoice', 'produk']);
        return response()->json($log_transaction);
    }

    public function update(Request $request, LogTransaction $log_transaction)
    {
        $validate = Validator::make($request->all(), [
            'id_invoice' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah_produk_invoice' => 'required|integer',
            'total_harga_produk' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $log_transaction->update([
            'id_invoice' => $request->id_invoice,
            'id_produk' => $request->id_produk,
            'jumlah_produk_invoice' => $request->jumlah_produk_invoice,
            'total_harga_produk' => $request->total_harga_produk,
        ]);

        return response()->json($log_transaction);
    }

    public function destroy(LogTransaction $log_transaction)
    {
        $log_transaction->delete();

        return response()->json(['message' => 'Log Transaction deleted successfully'], 200);
    }
}
