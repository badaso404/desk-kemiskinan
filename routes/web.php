<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\MasyarakatController;
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

    // Rekomendasi Pekerjaan
    Route::view('/rekomendasi', 'rekomendasi.index')->name('rekomendasi.index');
    Route::get('/rekomendasi/{id}', function ($id) {
        // Data contoh — ganti dengan query model saat tabel mitra kerja sudah ada.
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
    })->name('rekomendasi.show');
});


/*
|--------------------------------------------------------------------------
| Panel Penempatan
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/penempatan', [PenempatanController::class, 'index'])->name('penempatan.index');
    Route::get('/penempatan/tambah', [PenempatanController::class, 'create'])->name('penempatan.create');
    Route::post('/penempatan/simpan', [PenempatanController::class, 'store'])->name('penempatan.store');
    Route::get('/penempatan/{id}/edit', [PenempatanController::class, 'edit'])->name('penempatan.edit');
    Route::put('/penempatan/{id}', [PenempatanController::class, 'update'])->name('penempatan.update');
    Route::get('/penempatan/{id}', [PenempatanController::class, 'show'])->name('penempatan.show');
});