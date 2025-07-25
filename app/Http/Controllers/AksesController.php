<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class AksesController extends Controller
{
    public function getAkses()
    {
        $akses = Permission::all();
        return response()->json(['data' => $akses]);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:permissions,name',
            // 'guard_name' => 'required|string|max:255',
        ]);

        $akses = Permission::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json(['data' => $akses], 201);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $akses = Permission::findOrFail($id);
        $akses->delete();

        return response()->json(['message' => 'Akses deleted successfully'], 200);
    }
}
