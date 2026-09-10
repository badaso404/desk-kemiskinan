<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelatihanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PenempatanController;
/*
|--------------------------------------------------------------------------
| Halaman Publik
|--------------------------------------------------------------------------
| Hanya berisi profil website. Tidak ada tautan menuju /login di navigasi.
*/

Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::view('/profil-kemiskinan', 'profil-kemiskinan')->name('profil.kemiskinan');
Route::get('/pelatihan/{slug}', [PelatihanController::class, 'show'])->name('pelatihan.detail');

/*
|--------------------------------------------------------------------------
| Autentikasi Admin
|--------------------------------------------------------------------------
| Path /login sengaja tidak ditautkan di halaman publik.
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Panel Admin
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
});


/*
|--------------------------------------------------------------------------
| Panel Penempatan
|--------------------------------------------------------------------------
*/
Route::get('/penempatan', function () {
    return view('penempatan');
});


Route::get('/penempatan/tambah', function () {
    return view('penempatan_tambah');
});

// Route CRUD menggunakan PenempatanController
Route::get('/penempatan', [PenempatanController::class, 'index'])->name('penempatan.index');
Route::get('/penempatan/tambah', [PenempatanController::class, 'create'])->name('penempatan.create');
Route::post('/penempatan/simpan', [PenempatanController::class, 'store'])->name('penempatan.store');

// ... (Route index, create, store sebelumnya)

// Route Update & Read (Edit & Detail)
Route::get('/penempatan/{id}/edit', [PenempatanController::class, 'edit'])->name('penempatan.edit');
Route::put('/penempatan/{id}', [PenempatanController::class, 'update'])->name('penempatan.update');
Route::get('/penempatan/{id}', [PenempatanController::class, 'show'])->name('penempatan.show');