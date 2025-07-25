<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AksesController;
use App\Http\Controllers\KaryawanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.log_in');
})->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
Route::middleware(['auth.custom'])->group(function () {

    Route::get('/data_karyawan', function () {
        return view('data_karyawan.index');
    })->name('data_karyawan');

    Route::get('/master_akses', function () {
        return view('akses.index');
    })->name('master_akses');

    Route::get('/master_user', [UserController::class, 'user'])->name('master_user');
    Route::get('/master_role', [RoleController::class, 'role'])->name('master_role');

    Route::get('/getKaryawan', [KaryawanController::class, 'getKaryawan']);
    Route::get('/getRole', [RoleController::class, 'getRole']);
    Route::get('/getAkses', [AksesController::class, 'getAkses']);
    Route::get('/getUser', [UserController::class, 'getUser']);
    Route::get('/role/{id}', [RoleController::class, 'roleById']);
    Route::get('/user/{id}', [UserController::class, 'userById']);
    Route::get('/karyawan/{id}', [KaryawanController::class, 'karyawanById']);

    Route::post('/delete_karyawan', [KaryawanController::class, 'delete'])->name('delete_karyawan');
    Route::post('/create_karyawan', [KaryawanController::class, 'create'])->name('create_karyawan');
    Route::post('/update_karyawan', [KaryawanController::class, 'update'])->name('update_karyawan');

    Route::post('/create_user', [UserController::class, 'create'])->name('create_user');
    Route::post('/delete_user', [UserController::class, 'delete'])->name('delete_user');
    Route::post('/update_user', [UserController::class, 'update'])->name('update_user');

    Route::post('/create_role', [RoleController::class, 'create'])->name('create_role');
    Route::post('/delete_role', [RoleController::class, 'delete'])->name('delete_role');
    Route::post('/assign-role-permissions', [RoleController::class, 'assignPermissions'])->name('assign_role_permissions');

    Route::post('/create_akses', [AksesController::class, 'create'])->name('create_akses');
    Route::post('/delete_akses', [AksesController::class, 'delete'])->name('delete_akses');
});
