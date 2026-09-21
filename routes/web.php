<?php

use App\Http\Controllers\Admin\AuditTrailController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MitraController;
use App\Http\Controllers\Admin\PemberdayaanController;
use App\Http\Controllers\Admin\ProgramController;
use App\Http\Controllers\Admin\RekomendasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\PelatihanController;
use App\Http\Controllers\MasyarakatController;
use App\Http\Controllers\MonitoringController;
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

    // Data Masyarakat
    Route::get('/masyarakat', [MasyarakatController::class, 'index'])->name('masyarakat');
    Route::get('/masyarakat/create', [MasyarakatController::class, 'create'])->name('masyarakat.create');
    Route::post('/masyarakat', [MasyarakatController::class, 'store'])->name('masyarakat.store');
    Route::get('/masyarakat/{id}/edit', [MasyarakatController::class, 'edit'])->name('masyarakat.edit');
    Route::put('/masyarakat/{id}', [MasyarakatController::class, 'update'])->name('masyarakat.update');
    Route::delete('/masyarakat/{id}', [MasyarakatController::class, 'destroy'])->name('masyarakat.destroy');
    Route::get('/masyarakat/{id}', [MasyarakatController::class, 'show'])->name('masyarakat.show');
    Route::patch('/masyarakat/{id}/verify', [MasyarakatController::class, 'verify'])->name('masyarakat.verify');

    // Pemberdayaan: penyelenggara (UKPD/CSR) dan program
    Route::get('/pemberdayaan', [PemberdayaanController::class, 'index'])->name('pemberdayaan');

    Route::get('/pemberdayaan/mitra/create', [MitraController::class, 'create'])->name('mitra.create');
    Route::post('/pemberdayaan/mitra', [MitraController::class, 'store'])->name('mitra.store');
    Route::get('/pemberdayaan/mitra/{mitra}', [MitraController::class, 'show'])->name('mitra.show');
    Route::get('/pemberdayaan/mitra/{mitra}/edit', [MitraController::class, 'edit'])->name('mitra.edit');
    Route::put('/pemberdayaan/mitra/{mitra}', [MitraController::class, 'update'])->name('mitra.update');
    Route::delete('/pemberdayaan/mitra/{mitra}', [MitraController::class, 'destroy'])->name('mitra.destroy');

    Route::get('/pemberdayaan/program/create', [ProgramController::class, 'create'])->name('program.create');
    Route::post('/pemberdayaan/program', [ProgramController::class, 'store'])->name('program.store');
    Route::get('/pemberdayaan/program/{program}', [ProgramController::class, 'show'])->name('program.show');
    Route::get('/pemberdayaan/program/{program}/edit', [ProgramController::class, 'edit'])->name('program.edit');
    Route::put('/pemberdayaan/program/{program}', [ProgramController::class, 'update'])->name('program.update');
    Route::delete('/pemberdayaan/program/{program}', [ProgramController::class, 'destroy'])->name('program.destroy');

    // Rekomendasi: pencocokan warga dengan program
    Route::get('/rekomendasi', [RekomendasiController::class, 'index'])->name('rekomendasi.index');
    Route::get('/rekomendasi/{masyarakat}', [RekomendasiController::class, 'show'])->name('rekomendasi.show');

    // Audit trail: riwayat aktivitas admin
    Route::get('/audit-trail', [AuditTrailController::class, 'index'])->name('audit-trail');

    // Route Monitoring
    Route::get('/monitoring', [MonitoringController::class, 'index'])->name('monitoring');
    Route::get('/monitoring/download-pdf', [MonitoringController::class, 'downloadPdf'])->name('monitoring.download-pdf');
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

use Illuminate\Http\Request;

// Route Cepat untuk Mengubah Role User Login
Route::post('/switch-role', function (Request $request) {
    $request->validate([
        'role' => 'required|in:admin,kecamatan,pimpinan_kesra,kelurahan,walikota',
    ]);

    $user = auth()->user();
    if ($user) {
        $user->role = $request->role;
        $user->save();
    }

    return back();
})->name('switch.role')->middleware('auth');
