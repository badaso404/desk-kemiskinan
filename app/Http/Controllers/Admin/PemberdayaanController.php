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
        $search = trim((string) $request->input('search', ''));
        $jenis = $request->input('jenis');
        $selectedMitraId = $request->input('mitra_id');

        $mitraQuery = Mitra::with('program')->orderBy('jenis')->orderBy('nama');

        if ($request->filled('jenis') && in_array($request->jenis, ['UKPD', 'CSR'])) {
            $mitraQuery->where('jenis', $request->jenis);
        }

        if ($search !== '') {
            $mitraQuery->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('bidang', 'like', "%{$search}%")
                    ->orWhere('jenis', 'like', "%{$search}%");
            });
        }

        $mitra = $mitraQuery->get();

        $selectedMitra = null;
        if ($selectedMitraId && $mitra->contains('id', $selectedMitraId)) {
            $selectedMitra = $mitra->firstWhere('id', $selectedMitraId);
        }

        if (!$selectedMitra && $mitra->isNotEmpty()) {
            $selectedMitra = $mitra->first();
        }

        $programQuery = Program::with('mitra')->orderByDesc('tanggal_mulai');

        if ($selectedMitra) {
            $programQuery->where('mitra_id', $selectedMitra->id);
        }

        if ($request->filled('program_search')) {
            $programSearch = trim((string) $request->input('program_search'));
            if ($programSearch !== '') {
                $programQuery->where(function ($query) use ($programSearch) {
                    $query->where('nama', 'like', "%{$programSearch}%")
                        ->orWhere('jenis', 'like', "%{$programSearch}%")
                        ->orWhere('kategori', 'like', "%{$programSearch}%");
                });
            }
        }

        $program = $programQuery->get();

        $ringkasan = [
            'ukpd' => Mitra::where('jenis', 'UKPD')->count(),
            'csr' => Mitra::where('jenis', 'CSR')->count(),
            'program_aktif' => Program::whereIn('status', ['Pendaftaran', 'Berjalan'])->count(),
            'kursi' => Program::whereIn('status', ['Pendaftaran', 'Berjalan'])
                ->get()
                ->sum(fn ($program) => max(0, (int) $program->kuota - (int) $program->peserta)),
        ];

        return view('admin.pemberdayaan.index', compact('mitra', 'program', 'ringkasan', 'selectedMitra', 'search', 'jenis'));
    }
}
