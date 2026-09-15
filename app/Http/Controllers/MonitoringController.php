<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\Penempatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        // 1. TOTAL MASYARAKAT
        $totalMasyarakat = Masyarakat::count();

        // 2. MASYARAKAT YANG SUDAH DITEMPATKAN
        // Mengambil jumlah warga unik dari tabel penempatans dengan status 'Bekerja' atau 'Diterima'
        $masyarakatDitempatkan = Penempatan::whereIn('status', ['Bekerja', 'Diterima'])
            ->distinct('masyarakat_id')
            ->count('masyarakat_id');

        // 3. RUMUS TINGKAT PENEMPATAN: (Masyarakat Sudah Ditempatkan / Total Masyarakat) * 100%
        $tingkatPenempatan = $totalMasyarakat > 0 
            ? round(($masyarakatDitempatkan / $totalMasyarakat) * 100, 1) 
            : 0;

        // Stat tambahan
        $butuhPekerjaan = Masyarakat::whereIn('status_pekerjaan', [
            'Belum / Tidak Bekerja', 
            'Terkena PHK', 
            'Pekerja Lepas / Serabutan'
        ])->count();
        
        $totalPenempatan = Penempatan::count();

        // 4. DISTRIBUSI STATUS PEKERJAAN (DINAMIS)
        $distribusiPekerjaan = Masyarakat::select('status_pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('status_pekerjaan')
            ->groupBy('status_pekerjaan')
            ->get();

        $maxCount = $distribusiPekerjaan->max('total') ?? 1;

        // 5. REKAPITULASI KECAMATAN (DINAMIS)
        $rekapKecamatan = Masyarakat::select(
                'kecamatan',
                DB::raw('count(*) as total_warga'),
                DB::raw("SUM(CASE WHEN status_pekerjaan IN ('Belum / Tidak Bekerja', 'Terkena PHK', 'Pekerja Lepas / Serabutan') THEN 1 ELSE 0 END) as butuh_kerja")
            )
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total_warga', 'desc')
            ->get();

        // 6. PENEMPATAN TERBARU

        $penempatanTerbaru = Penempatan::with(['masyarakat', 'program'])
            ->latest('updated_at')
            ->get();

        return view('admin.monitoring.monitoring', compact(
            'totalMasyarakat',
            'masyarakatDitempatkan',
            'butuhPekerjaan',
            'tingkatPenempatan',
            'totalPenempatan',
            'distribusiPekerjaan',
            'maxCount',
            'rekapKecamatan',
            'penempatanTerbaru'
        ));
    }
}