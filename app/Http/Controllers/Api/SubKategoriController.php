<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\SubKategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubKategoriController extends Controller
{
    public function index()
    {
        $sub_kategoris = SubKategori::with('kategori')->get();

        return response()->json($sub_kategoris);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'id_kategori' => 'required|integer',
            'nama_sub_kategori' => 'required|string',
            'kode_sub_kategori' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $sub_kategori = SubKategori::create([
            'id_kategori' => $request->id_kategori,
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'kode_sub_kategori' => $request->kode_sub_kategori,
        ]);

        $sub_kategori->load('kategori');

        return response()->json($sub_kategori, 201);
    }

    public function show(SubKategori $sub_kategori)
    {
        $sub_kategori->load('kategori');
        return response()->json($sub_kategori);
    }

    public function update(Request $request, SubKategori $sub_kategori)
    {
        $validate = Validator::make($request->all(), [
            'id_kategori' => 'required|integer',
            'nama_sub_kategori' => 'required|string',
            'kode_sub_kategori' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $sub_kategori->update([
            'id_kategori' => $request->id_kategori,
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'kode_sub_kategori' => $request->kode_sub_kategori,
        ]);

        $sub_kategori->load('kategori');

        return response()->json($sub_kategori);
    }

    public function destroy(SubKategori $sub_kategori)
    {
        $sub_kategori->delete();

        return response()->json(['message' => 'Sub Kategori deleted successfully'], 200);
    }
}
