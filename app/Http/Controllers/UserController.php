<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    // public function getUser()
    // {
    //     $users = \App\Models\User::all();
    //     return response()->json(['data' => $users]);
    // }

    public function getUser()
    {
        $users = User::with('roleRef')->get();
        return response()->json(['data' => $users]);
    }


    public function userById($id)
    {
        $user = User::findOrFail($id); // pakai roles & permissions

        return response()->json([
            'data' => $user,
        ]);
    }

    public function user()
    {
        $users = \App\Models\User::all();
        $roles = \Spatie\Permission\Models\Role::all();
        return view('user.index', compact('users', 'roles'));
    }

    // public function create(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email',
    //         'password' => 'required|string|min:8',
    //         'role' => 'required|exists:roles,id',
    //     ]);

    //     $user = \App\Models\User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //         'role' => $request->role,
    //     ]);

    //     return response()->json(['data' => $user], 201);
    // }

    // public function create(Request $request)
    // {
    //     $this->validate($request, [
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email',
    //         'password' => 'required|string|min:8',
    //         'role' => 'required|exists:roles,id',
    //     ]);

    //     $user = \App\Models\User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => bcrypt($request->password),
    //     ]);

    //     // Assign role ke user (untuk isi model_has_roles)
    //     $role = Role::find($request->role);
    //     $user->assignRole($role->name); // <- ini penting!

    //     return response()->json(['data' => $user], 201);
    // }

    public function create(Request $request)
{
    $this->validate($request, [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'password' => 'required|string|min:8',
        'role' => 'required|exists:roles,id', // role_id tetap dipakai
    ]);

    // Buat user + simpan role_id ke kolom users.role
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => $request->role, // simpan role_id ke kolom role
    ]);

    // Assign role ke Spatie dari kolom role_id
    $role = Role::find($user->role); // ← ambil dari kolom users.role
    if ($role) {
        $user->assignRole($role->name);
    }

    return response()->json(['data' => $user], 201);
}

    public function update(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $request->user_id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|string|max:255', // <- ini bisa pakai role ID atau name, tergantung implementasimu
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        // ✅ Assign/update rolenya di Spatie
        $role = Role::find($request->role); // <- ini kalau pakai role_id
        if ($role) {
            $user->syncRoles([$role->name]); // <- ini yang update tabel model_has_roles
        }

        return response()->json(['message' => 'User berhasil diperbarui.']);
    }



    public function delete(Request $request)
    {
        $id = $request->input('id');
        $akses = User::findOrFail($id);
        $akses->delete();

        return response()->json(['message' => 'User berhasil dihapus'], 200);
    }
}
