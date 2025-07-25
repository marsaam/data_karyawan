<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    public function getRole()
    {
        $roles = Role::all();
        return response()->json(['data' => $roles]);
    }

    public function role()
    {
        $roles = Role::all();
        $akses = Permission::all();
        return view('role.index', compact('roles', 'akses'));
    }

    public function roleById($id)
    {
        $role = Role::with('permissions')->findOrFail($id); // <-- INI PENTING
        $akses = Permission::all();

        return response()->json([
            'data' => $role,
            'akses' => $akses
        ]);
    }

    public function assignPermissions(Request $request)
    {
        $role = Role::findOrFail($request->role_id);
        $permissionIds = $request->input('permission_id', []);

        // Ubah ID menjadi nama permission
        $permissionNames = Permission::whereIn('id', $permissionIds)->pluck('name')->toArray();

        $role->syncPermissions($permissionNames); // atau givePermissionTo() jika ingin menambah saja

        return response()->json(['message' => 'Akses berhasil disimpan.']);
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:roles,name',
            // 'guard_name' => 'required|string|max:255',
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return response()->json(['data' => $role], 201);
    }

    public function delete(Request $request)
    {
        $id = $request->input('id');
        $akses = Role::findOrFail($id);
        $akses->delete();

        return response()->json(['message' => 'Akses berhasil dihapus'], 200);
    }
}
