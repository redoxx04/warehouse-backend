<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $pageSize = $request->input('pageSize', 10); // Default to 10 items per page if not provided
    $page = $request->input('page', 1); // Default to the first page if not provided
    
    $products = Product::with(['sub_kategori.kategori' => function($query) {
        $query->select('id_kategori','nama_kategori');
    }])->paginate($pageSize, ['*'], 'page', $page);

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

        $product->load('sub_kategori');

        return response()->json($product, 201);
    }

    public function show(Product $product)
    {
        
        $product->load(['sub_kategori.kategori' => function($query){
            $query->select('id_kategori','nama_kategori');
        }]);
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

        $product->load(['sub_kategori.kategori' => function($query){
            $query->select('id_kategori','nama_kategori');
        }]);

        return response()->json($product);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
