<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();

        return response()->json($kategoris);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_kategori' => 'required|string',
            'kode_kategori' => 'required|string|unique:kategori,kode_kategori',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $kategori = Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'kode_kategori' => $request->kode_kategori,
        ]);

        return response()->json($kategori, 201);
    }

    public function show($id)
    {
        $kategori = Kategori::find($id);
        return response()->json($kategori);
    }

    public function update(Request $request, Kategori $kategori)
    {
        $validate = Validator::make($request->all(), [
            'nama_kategori' => 'required|string',
            'kode_kategori' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $kategori->update([
            'nama_kategori' => $request->nama_kategori,
            'kode_kategori' => $request->kode_kategori,
        ]);

        return response()->json($kategori);
    }

    public function destroy(Kategori $kategori)
    {
        $kategori->delete();

        return response()->json(['message' => 'Kategori deleted successfully'], 200);
    }
}
