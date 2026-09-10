<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\MasyarakatController;
use Illuminate\Support\Facades\Route;

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

    Route::get('/pemberdayaan', function () {
        return view('admin.pemberdayaan');
    })->name('pemberdayaan');

    // Data Masyarakat
    Route::get('/masyarakat', [MasyarakatController::class, 'index'])->name('masyarakat');
    Route::get('/masyarakat/create', [MasyarakatController::class, 'create'])->name('masyarakat.create');
    Route::post('/masyarakat', [MasyarakatController::class, 'store'])->name('masyarakat.store');
    Route::get('/masyarakat/{id}/edit', [MasyarakatController::class, 'edit'])->name('masyarakat.edit');
    Route::put('/masyarakat/{id}', [MasyarakatController::class, 'update'])->name('masyarakat.update');
    Route::delete('/masyarakat/{id}', [MasyarakatController::class, 'destroy'])->name('masyarakat.destroy');
});
