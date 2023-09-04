<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use App\Models\subKategori;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubKategoriController extends Controller
{
    public function index(Request $request)
    {
        $id_kategori = $request->input('id_kategori');

        if ($id_kategori) {
        $sub_kategoris = subKategori::with('kategori')
                                    ->where('id_kategori', $id_kategori)
                                    ->get();
    } else {
        $sub_kategoris = subKategori::with('kategori')->get();
    }

    return response()->json($sub_kategoris);
    }

    public function store(Request $request)
    {
        // dd(SubKategori::class);

        $validate = Validator::make($request->all(), [
            'id_kategori' => 'required|integer',
            'nama_sub_kategori' => 'required|string',
            'kode_sub_kategori' => 'required|string|unique:sub_kategori,kode_sub_kategori',
        ]);


        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $sub_kategori = subKategori::create([
            'id_kategori' => $request->id_kategori,
            'nama_sub_kategori' => $request->nama_sub_kategori,
            'kode_sub_kategori' => $request->kode_sub_kategori,
        ]);

        // $sub_kategori = DB::table('warehouse_system.sub_kategori')->insert([
        //     'id_kategori' => $request->id_kategori,
        //     'nama_sub_kategori' => $request->nama_sub_kategori,
        //     'kode_sub_kategori' => $request->kode_sub_kategori,
        // ]);

        $sub_kategori->load('kategori');

        return response()->json($sub_kategori, 201);
    }

    public function show($id)
    {
        $sub_kategori = subKategori::find($id);
        $sub_kategori->load('kategori');
        return response()->json($sub_kategori);
    }

    public function update(Request $request, subKategori $sub_kategori)
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

    public function destroy(subKategori $sub_kategori)
    {
        $sub_kategori->delete();

        return response()->json(['message' => 'Sub Kategori deleted successfully'], 200);
    }
}
