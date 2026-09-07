<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Data contoh — ganti dengan query model saat tabel data masyarakat sudah ada.
        $ringkasan = [
            'total_masyarakat' => 1245,
            'butuh_pekerjaan' => 328,
            'kebutuhan_ukpd' => 48,
            'kebutuhan_csr' => 27,
        ];

        $statusMasyarakat = [
            ['label' => 'Membutuhkan Pekerjaan', 'jumlah' => 328, 'warna' => '#b91c1c'],
            ['label' => 'Processing', 'jumlah' => 56, 'warna' => '#c2570c'],
            ['label' => 'Accepted', 'jumlah' => 42, 'warna' => '#1d4ed8'],
            ['label' => 'Placed', 'jumlah' => 31, 'warna' => '#94a3b8'],
        ];

        $rekomendasi = [
            ['posisi' => 'Driver Operasional', 'match' => 95],
            ['posisi' => 'Operator Gudang', 'match' => 89],
            ['posisi' => 'Teknisi Lapangan', 'match' => 84],
        ];

        $masyarakatTerbaru = [
            ['nama' => 'Budi Santoso', 'wilayah' => 'Jakarta Selatan', 'keahlian' => 'Mengemudi', 'status' => 'Pending'],
            ['nama' => 'Siti Aminah', 'wilayah' => 'Jakarta Timur', 'keahlian' => 'Administrasi', 'status' => 'Diproses'],
            ['nama' => 'Agus Setiawan', 'wilayah' => 'Jakarta Barat', 'keahlian' => 'Teknik Listrik', 'status' => 'Ditempatkan'],
        ];

        return view('admin.dashboard', compact(
            'ringkasan',
            'statusMasyarakat',
            'rekomendasi',
            'masyarakatTerbaru'
        ));
    }
}
