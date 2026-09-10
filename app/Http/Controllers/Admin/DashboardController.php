<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use App\Models\Program;

class DashboardController extends Controller
{
    public function index()
    {
        // Kursi program yang masih kosong, dikelompokkan per jenis penyelenggara (menu Pemberdayaan).
        $kursiPerJenis = Program::query()
            ->join('mitras', 'mitras.id', '=', 'programs.mitra_id')
            ->whereIn('programs.status', ['Pendaftaran', 'Berjalan'])
            ->groupBy('mitras.jenis')
            ->selectRaw('mitras.jenis as jenis, SUM(GREATEST(programs.kuota - programs.peserta, 0)) as kursi')
            ->pluck('kursi', 'jenis');

        $ringkasan = [
            'total_masyarakat' => Masyarakat::count(),
            'program_aktif' => Program::whereIn('status', ['Pendaftaran', 'Berjalan'])->count(),
            'kursi_ukpd' => (int) ($kursiPerJenis['UKPD'] ?? 0),
            'kursi_csr' => (int) ($kursiPerJenis['CSR'] ?? 0),
        ];

        $jumlahPerStatus = Program::query()
            ->groupBy('status')
            ->selectRaw('status, COUNT(*) as jumlah')
            ->pluck('jumlah', 'status');

        $statusProgram = [
            ['label' => 'Pendaftaran', 'jumlah' => (int) ($jumlahPerStatus['Pendaftaran'] ?? 0), 'warna' => '#1d4ed8'],
            ['label' => 'Berjalan', 'jumlah' => (int) ($jumlahPerStatus['Berjalan'] ?? 0), 'warna' => '#2f7d57'],
            ['label' => 'Selesai', 'jumlah' => (int) ($jumlahPerStatus['Selesai'] ?? 0), 'warna' => '#94a3b8'],
        ];

        $programTerbuka = Program::with('mitra')
            ->where('status', 'Pendaftaran')
            ->orderBy('tanggal_mulai')
            ->take(3)
            ->get();

        $masyarakatTerbaru = Masyarakat::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'ringkasan',
            'statusProgram',
            'programTerbuka',
            'masyarakatTerbaru'
        ));
    }
}
