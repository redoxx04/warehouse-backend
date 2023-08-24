<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $pageSize = $request->input('pageSize', 10); // Default to 10 items per page if not provided
        $page = $request->input('page', 1); // Default to the first page if not provided

        $products = Product::with([
            'sub_kategori.kategori' => function ($query) {
                $query->select('id_kategori', 'nama_kategori');
            },
        ])->paginate($pageSize, ['*'], 'page', $page);

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

    public function show($id)
    {

        $product = Product::find($id);

        $product->load(['sub_kategori.kategori' => function ($query) {
            $query->select('id_kategori', 'nama_kategori');
        },
            // 'transactions.log_invoice',
        ]);
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

        $product->load(['sub_kategori.kategori' => function ($query) {
            $query->select('id_kategori', 'nama_kategori');
        }]);

        return response()->json($product);
    }

    public function importCsv(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt|max:2048',
        ]);

        if ($request->hasFile('csv_file')) {
            $csvFile = $request->file('csv_file');
            $csvData = Reader::createFromPath($csvFile->getRealPath(), 'r');
            $csvData->setHeaderOffset(0); // Assuming your CSV has headers

            foreach ($csvData as $row) {
                // Fetch or create the category
                $category = Kategori::firstOrCreate([
                    'nama_kategori' => $row['nama_kategori'],
                    'kode_kategori' => $row['kode_kategori'],
                ]);
                // error_log($category);

                // Fetch or create the subcategory under that category
                $subCategory = $category->subKategoris()->firstOrCreate(['nama_sub_kategori' => $row['nama_sub_kategori'],'kode_sub_kategori' => $row['kode_sub_kategori'],]);
                error_log($subCategory);

                $SKU = "{$row['kode_produk']}-{$category->kode_kategori}-{$subCategory->kode_sub_kategori}";

                // Check if the product exists under the subcategory
                error_log($SKU);
                $product = Product::firstOrNew([
                    'kode_produk' => $row['kode_produk'],
                    'nama_produk' => $row['nama_produk'],
                    // 'harga_produk' => $row['harga_produk'],
                    // 'harga_modal' => $row['harga_modal'],
                    // 'jumlah_produk' => $row['jumlah_produk'],
                    'SKU_produk' => $SKU,
                ]);
                // error_log($product);

                // If product exists, add the quantity, otherwise set the other attributes and save
                if ($product->exists) {
                    $product->increment('jumlah_produk', $row['jumlah_produk']);
                } else {
                    $product->id_sub_kategori = $row['id_sub_kategori'];
                    $product->harga_produk = $row['harga_produk'];
                    $product->harga_modal = $row['harga_modal'];
                    $product->jumlah_produk = $row['jumlah_produk'];
                    $product->SKU_produk = $SKU;
                    $product->save();
                }
            }

            return response()->json(['message' => 'Products imported successfully'], 200);
        }

        return response()->json(['message' => 'File not uploaded'], 400);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
