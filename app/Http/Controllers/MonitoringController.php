<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\Penempatan;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitoringController extends Controller
{
    private function getLaporanData()
    {
        // 1. Total Masyarakat
        $totalMasyarakat = Masyarakat::count();

        // 2. Masyarakat yang Sudah Ditempatkan (Status 'Bekerja' atau 'Diterima')
        $masyarakatDitempatkan = Penempatan::whereIn('status', ['Bekerja', 'Diterima'])
            ->distinct('masyarakat_id')
            ->count('masyarakat_id');

        // 3. Tingkat Penempatan (%)
        $tingkatPenempatan = $totalMasyarakat > 0 
            ? round(($masyarakatDitempatkan / $totalMasyarakat) * 100, 1) 
            : 0;

        // 4. Masyarakat Butuh Pekerjaan
        $butuhPekerjaan = Masyarakat::whereIn('status_pekerjaan', [
            'Belum / Tidak Bekerja', 
            'Terkena PHK', 
            'Pekerja Lepas / Serabutan'
        ])->count();
        
        $totalPenempatan = Penempatan::count();

        // 5. Distribusi Status Pekerjaan
        $distribusiPekerjaan = Masyarakat::select('status_pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('status_pekerjaan')
            ->groupBy('status_pekerjaan')
            ->get();

        $maxCount = $distribusiPekerjaan->max('total') ?? 1;

        // 6. Rekapitulasi per Kecamatan
        $rekapKecamatan = Masyarakat::select(
                'kecamatan',
                DB::raw('count(*) as total_warga'),
                DB::raw("SUM(CASE WHEN status_pekerjaan IN ('Belum / Tidak Bekerja', 'Terkena PHK', 'Pekerja Lepas / Serabutan') THEN 1 ELSE 0 END) as butuh_kerja")
            )
            ->whereNotNull('kecamatan')
            ->groupBy('kecamatan')
            ->orderBy('total_warga', 'desc')
            ->get();

        // 7. Riwayat Penempatan Terbaru
        $penempatanTerbaru = Penempatan::with(['masyarakat', 'program'])
            ->latest('updated_at')
            ->get();

        $rekapProgram = Program::with('mitra')->get();

        $rekapProgram->transform(function ($program) {
            $program->total_masuk = Penempatan::where('program_id', $program->id)->count();
            return $program;
        });


        return compact(
            'totalMasyarakat',
            'masyarakatDitempatkan',
            'butuhPekerjaan',
            'tingkatPenempatan',
            'totalPenempatan',
            'distribusiPekerjaan',
            'maxCount',
            'rekapKecamatan',
            'penempatanTerbaru',
            'rekapProgram' // Variable rekap program UKPD/CSR
        );
    }

    public function index()
    {
        $data = $this->getLaporanData();
        return view('admin.monitoring.monitoring', $data);
    }

    public function downloadPdf()
    {
        $data = $this->getLaporanData();
        $pdf = Pdf::loadView('admin.monitoring.pdf', $data)->setPaper('a4', 'portrait');
        
        return $pdf->download('Laporan_Monitoring_Pemberdayaan_'.date('Y-m-d').'.pdf');
    }
}