<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    
    public function index()
    {
        $roles = Role::all();

        return response()->json($roles);
    }

    public function store(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'nama_role' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $role = Role::create([
            'nama_role' => $request->nama_role,
        ]);

        return response()->json($role, 201);
    }

    public function show($id)
    {
        $role = Role::find($id);
        return response()->json($role);
    }

    public function update(Request $request, Role $role)
    {
        $validate = Validator::make($request->all(), [
            'nama_role' => 'required|string',
        ]);

        if ($validate->fails()) {
            return response()->json(['errors' => $validate->errors()], 422);
        }

        $role->update([
            'nama_role' => $request->nama_role,
        ]);

        return response()->json($role);
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return response()->json(['message' => 'Role deleted successfully'], 200);
    }
}
