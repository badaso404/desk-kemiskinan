<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Program;

class PemberdayaanController extends Controller
{
    /**
     * Halaman utama Pemberdayaan: mengelola penyelenggara (UKPD/CSR) dan program.
     */
    public function index()
    {
        $mitra = Mitra::with('program')->orderBy('jenis')->orderBy('nama')->get();
        $program = Program::with('mitra')->orderByDesc('tanggal_mulai')->get();

        $ringkasan = [
            'ukpd' => $mitra->where('jenis', 'UKPD')->count(),
            'csr' => $mitra->where('jenis', 'CSR')->count(),
            'program_aktif' => $program->whereIn('status', ['Pendaftaran', 'Berjalan'])->count(),
            'kursi' => $program->whereIn('status', ['Pendaftaran', 'Berjalan'])->sum->sisa_kuota,
        ];

        return view('admin.pemberdayaan.index', compact('mitra', 'program', 'ringkasan'));
    }
}
