<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogInvoice;
use App\Models\LogTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LogInvoiceController extends Controller
{
    public function index()
    {
        $log_invoices = LogInvoice::all();

        return response()->json($log_invoices);
    }

    public function store(Request $request)
    {
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

        $log_invoice = LogInvoice::create($request->only([
            'nomor_invoice', 
            'nama_invoice', 
            'asal_transaksi',
            'contact_number', 
            'address_invoice', 
            'total_transaksi', 
            'id_user'
        ]));

        // if ($request->has('products')) {
        //     foreach ($request->products as $productData) {
        //         LogTransaction::create([
        //             'id_invoice' => $log_invoice->id,
        //             'id_produk' => $productData['id_produk'],
        //             'jumlah_produk_invoice' => $productData['jumlah_produk_invoice'],
        //             'total_harga_produk' => Product::find($productData['id_produk'])->harga_produk * $productData['jumlah_produk_invoice']
        //         ]);
        //     }
        // }

        return response()->json($log_invoice, 201);
    }

    public function show($id)
    {
        $log_invoice = LogInvoice::find($id);
        // $log_invoice->load(['transactions.produk']);
        return response()->json($log_invoice);
    }

    public function update(Request $request, LogInvoicesModel $log_invoice)
    {
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

        $log_invoice->update([
            'nomor_invoice' => $request->nomor_invoice,
            'nama_invoice' => $request->nama_invoice,
            'asal_transaksi' => $request->asal_transaksi,
            'contact_number' => $request->contact_number,
            'address_invoice' => $request->address_invoice,
            'total_transaksi' => $request->total_transaksi,
            'id_user' => $request->id_user,
        ]);

        return response()->json($log_invoice);
    }

    public function destroy(LogInvoicesModel $log_invoice)
    {
        $log_invoice->delete();

        return response()->json(['message' => 'Log Invoices deleted successfully'], 200);
    }
}
