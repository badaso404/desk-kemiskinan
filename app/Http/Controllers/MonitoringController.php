<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use App\Models\Penempatan;
use App\Models\Program;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class MonitoringController extends Controller
{
    /**
     * Nama bulan Bahasa Indonesia untuk label PDF & filename.
     */
    private array $namaBulan = [
        1  => 'Januari',
        2  => 'Februari',
        3  => 'Maret',
        4  => 'April',
        5  => 'Mei',
        6  => 'Juni',
        7  => 'Juli',
        8  => 'Agustus',
        9  => 'September',
        10 => 'Oktober',
        11 => 'November',
        12 => 'Desember',
    ];

    /**
     * Validasi & normalisasi parameter filter bulan/tahun dari request.
     *
     * @return array{0:int,1:int}  [bulan, tahun]
     */
    private function resolvePeriode(Request $request): array
    {
        $bulan = (int) $request->input('bulan', now()->month);
        $tahun = (int) $request->input('tahun', now()->year);

        if ($bulan < 1 || $bulan > 12) {
            $bulan = now()->month;
        }

        if ($tahun < 2000 || $tahun > now()->year + 1) {
            $tahun = now()->year;
        }

        return [$bulan, $tahun];
    }

    /**
     * Ambil semua data laporan — dengan filter bulan & tahun.
     */
    private function getLaporanData(int $bulan, int $tahun): array
    {
        /* ============ RENTANG PERIODE ============ */
        $startOfMonth = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endOfMonth   = $startOfMonth->copy()->endOfMonth();

        /* ============ 1. TOTAL MASYARAKAT ============ */
        // Masyarakat yang terdaftar pada periode tersebut
        $totalMasyarakat = Masyarakat::whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        /* ============ 2. MASYARAKAT DITEMPATKAN ============ */
        // Yang berstatus Bekerja/Diterima, dihitung dari yang di-update pada periode tersebut
        $masyarakatDitempatkan = Penempatan::whereIn('status', ['Bekerja', 'Diterima'])
            ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
            ->distinct('masyarakat_id')
            ->count('masyarakat_id');

        /* ============ 3. TINGKAT PENEMPATAN (%) ============ */
        $tingkatPenempatan = $totalMasyarakat > 0
            ? round(($masyarakatDitempatkan / $totalMasyarakat) * 100, 1)
            : 0;

        /* ============ 4. BUTUH PEKERJAAN ============ */
        $butuhPekerjaan = Masyarakat::whereIn('status_pekerjaan', [
                'Belum / Tidak Bekerja',
                'Terkena PHK',
                'Pekerja Lepas / Serabutan',
            ])
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        /* ============ TOTAL PENEMPATAN ============ */
        $totalPenempatan = Penempatan::whereBetween('updated_at', [$startOfMonth, $endOfMonth])
            ->count();

        /* ============ 5. DISTRIBUSI STATUS PEKERJAAN ============ */
        $distribusiPekerjaan = Masyarakat::select('status_pekerjaan', DB::raw('count(*) as total'))
            ->whereNotNull('status_pekerjaan')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('status_pekerjaan')
            ->get();

        $maxCount = $distribusiPekerjaan->max('total') ?? 1;

        /* ============ 6. REKAP PER KECAMATAN ============ */
        $rekapKecamatan = Masyarakat::select(
                'kecamatan',
                DB::raw('count(*) as total_warga'),
                DB::raw("SUM(CASE WHEN status_pekerjaan IN ('Belum / Tidak Bekerja', 'Terkena PHK', 'Pekerja Lepas / Serabutan') THEN 1 ELSE 0 END) as butuh_kerja")
            )
            ->whereNotNull('kecamatan')
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->groupBy('kecamatan')
            ->orderBy('total_warga', 'desc')
            ->get();

        /* ============ 7. RIWAYAT PENEMPATAN TERBARU ============ */
        $penempatanTerbaru = Penempatan::with(['masyarakat', 'program'])
            ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
            ->latest('updated_at')
            ->get();

        /* ============ 8. REKAP PROGRAM ============ */
        $rekapProgram = Program::with('mitra')->get();

        $rekapProgram->transform(function ($program) use ($startOfMonth, $endOfMonth) {
            $program->total_masuk = Penempatan::where('program_id', $program->id)
                ->whereBetween('updated_at', [$startOfMonth, $endOfMonth])
                ->count();
            return $program;
        });

        return compact(
            'bulan',
            'tahun',
            'totalMasyarakat',
            'masyarakatDitempatkan',
            'butuhPekerjaan',
            'tingkatPenempatan',
            'totalPenempatan',
            'distribusiPekerjaan',
            'maxCount',
            'rekapKecamatan',
            'penempatanTerbaru',
            'rekapProgram'
        );
    }

    /**
     * Halaman monitoring utama.
     */
    public function index(Request $request)
    {
        [$bulan, $tahun] = $this->resolvePeriode($request);

        $data = $this->getLaporanData($bulan, $tahun);

        return view('admin.monitoring.monitoring', $data);
    }

    /**
     * Download laporan PDF — tanpa section riwayat penempatan.
     */
    public function downloadPdf(Request $request)
    {
        [$bulan, $tahun] = $this->resolvePeriode($request);

        $data = $this->getLaporanData($bulan, $tahun);

        // PDF tidak menampilkan riwayat penempatan → hilangkan dari payload
        // supaya tidak memberatkan proses render DomPDF
        unset($data['penempatanTerbaru']);

        $pdf = Pdf::loadView('admin.monitoring.pdf', $data)
            ->setPaper('a4', 'portrait');

        $filename = sprintf(
            'Laporan_Monitoring_%s_%d.pdf',
            $this->namaBulan[$bulan],
            $tahun
        );

        return $pdf->download($filename);
    }
}