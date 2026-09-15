<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Program;
use Illuminate\Http\Request;

class PemberdayaanController extends Controller
{
    /**
     * Halaman utama Pemberdayaan: mengelola penyelenggara (UKPD/CSR) dan program.
     */
    public function index(Request $request)
    {
        // Siapkan query dasar untuk Mitra
        $mitraQuery = Mitra::with('program')->orderBy('jenis')->orderBy('nama');

        // Terapkan filter jika parameter 'jenis' ada dan valid
        if ($request->filled('jenis') && in_array($request->jenis, ['UKPD', 'CSR'])) {
            $mitraQuery->where('jenis', $request->jenis);
        }

        // Eksekusi data setelah difilter (jika ada)
        $mitra = $mitraQuery->get();
        $program = Program::with('mitra')->orderByDesc('tanggal_mulai')->get();

        // Hitung ringkasan langsung dari Database agar total tidak berubah saat tabel difilter
        $ringkasan = [
            'ukpd' => Mitra::where('jenis', 'UKPD')->count(),
            'csr' => Mitra::where('jenis', 'CSR')->count(),
            'program_aktif' => $program->whereIn('status', ['Pendaftaran', 'Berjalan'])->count(),
            'kursi' => $program->whereIn('status', ['Pendaftaran', 'Berjalan'])->sum->sisa_kuota,
        ];

        return view('admin.pemberdayaan.index', compact('mitra', 'program', 'ringkasan'));
    }
}