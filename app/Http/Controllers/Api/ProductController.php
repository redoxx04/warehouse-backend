<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('sub_kategori')->get();

        return response()->json($products);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'kode_produk' => 'required|string',
            'id_sub_kategori' => 'required|integer',
            'nama_produk' => 'required|string',
            'harga_produk' => 'required|integer',
            'harga_modal' => 'required|integer',
            'jumlah_produk' => 'required|integer',
            'SKU_produk' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $product = Product::create([
            'kode_produk' => $request->kode_produk,
            'id_sub_kategori' => $request->id_sub_kategori,
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'harga_modal' => $request->harga_modal,
            'jumlah_produk' => $request->jumlah_produk,
            'SKU_produk' => $request->SKU_produk,
        ]);

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        return response()->json($product);
    }

    public function update(Request $request, Product $product)
    {
        $validate = Validator::make($request->all(), [
            'kode_produk' => 'required|string',
            'id_sub_kategori' => 'required|integer',
            'nama_produk' => 'required|string',
            'harga_produk' => 'required|integer',
            'harga_modal' => 'required|integer',
            'jumlah_produk' => 'required|integer',
            'SKU_produk' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $product->update([
            'kode_produk' => $request->kode_produk,
            'id_sub_kategori' => $request->id_sub_kategori,
            'nama_produk' => $request->nama_produk,
            'harga_produk' => $request->harga_produk,
            'harga_modal' => $request->harga_modal,
            'jumlah_produk' => $request->jumlah_produk,
            'SKU_produk' => $request->SKU_produk,
        ]);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
