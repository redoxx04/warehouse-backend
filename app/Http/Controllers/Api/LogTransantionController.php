<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LogTransantion;
use Illuminate\Http\Request;

class LogTransantionController extends Controller
{
    public function index()
    {
        $log_transantions = LogTransantion::with(['log_invoice', 'produk'])->get();

        return response()->json($log_transantions);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id_invoice' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah_produk' => 'required|integer',
            'total_harga_produk' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $log_transantion = LogTransantion::create([
            'id_invoice' => $request->id_invoice,
            'id_produk' => $request->id_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'total_harga_produk' => $request->total_harga_produk,
        ]);

        return response()->json($log_transantion, 201);
    }

    public function show(LogTransantion $log_transantion)
    {
        return response()->json($log_transantion);
    }

    public function update(Request $request, LogTransantion $log_transantion)
    {
        $validate = Validator::make($request->all(), [
            'id_invoice' => 'required|integer',
            'id_produk' => 'required|integer',
            'jumlah_produk' => 'required|integer',
            'total_harga_produk' => 'required|integer',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $log_transantion->update([
            'id_invoice' => $request->id_invoice,
            'id_produk' => $request->id_produk,
            'jumlah_produk' => $request->jumlah_produk,
            'total_harga_produk' => $request->total_harga_produk,
        ]);

        return response()->json($log_transantion);
    }

    public function destroy(LogTransantion $log_transantion)
    {
        $log_transantion->delete();

        return response()->json(['message' => 'Log Transantion deleted successfully'], 200);
    }
}
