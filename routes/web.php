<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelatihanController;
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

Route::middleware('auth')->group(function () {
    Route::get('/admin', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::view('/admin/rekomendasi', 'rekomendasi.index')->name('admin.rekomendasi.index');
    Route::get('/admin/rekomendasi/{id}', function ($id) {
        $perusahaan = [
            [
                'nama' => 'Perumda Pasar Jaya',
                'sumber' => 'UKPD',
                'posisi' => 'Petugas Operasional Pasar',
                'lokasi' => 'Jakarta Selatan',
                'tersedia' => 8,
                'match' => 94,
            ],
            [
                'nama' => 'Dinas Bina Marga DKI Jakarta',
                'sumber' => 'UKPD',
                'posisi' => 'Teknisi Lapangan',
                'lokasi' => 'Jakarta Timur',
                'tersedia' => 5,
                'match' => 89,
            ],
            [
                'nama' => 'PT Sinar Sejahtera Logistik',
                'sumber' => 'CSR',
                'posisi' => 'Driver Operasional',
                'lokasi' => 'Jakarta Selatan',
                'tersedia' => 12,
                'match' => 87,
            ],
            [
                'nama' => 'Yayasan Karya Bersama',
                'sumber' => 'CSR',
                'posisi' => 'Admin Program Pemberdayaan',
                'lokasi' => 'Jakarta Pusat',
                'tersedia' => 3,
                'match' => 82,
            ],
        ];

        return view('rekomendasi.show', compact('id', 'perusahaan'));
    })->name('admin.rekomendasi.show');
    Route::resource('/admin/pelatihan', PelatihanController::class)->except(['show']);
});
