<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function create()
    {
        return view('admin.pemberdayaan.program-form', [
            'program' => new Program(),
            'daftarMitra' => Mitra::orderBy('nama')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Program::create($this->validasi($request));

        return redirect()
            ->route('admin.pemberdayaan', ['tab' => 'program'])
            ->with('sukses', 'Program berhasil ditambahkan.');
    }

    public function show(Program $program)
    {
        $program->load('mitra');

        return view('admin.pemberdayaan.program-detail', compact('program'));
    }

    public function edit(Program $program)
    {
        return view('admin.pemberdayaan.program-form', [
            'program' => $program,
            'daftarMitra' => Mitra::orderBy('nama')->get(),
        ]);
    }

    public function update(Request $request, Program $program)
    {
        $program->update($this->validasi($request));

        return redirect()
            ->route('admin.pemberdayaan', ['tab' => 'program'])
            ->with('sukses', 'Program berhasil diperbarui.');
    }

    public function destroy(Program $program)
    {
        $program->delete();

        return redirect()
            ->route('admin.pemberdayaan', ['tab' => 'program'])
            ->with('sukses', 'Program berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'jenis' => ['required', 'in:Pelatihan,Seminar,Bimbingan Teknis,Workshop'],
            'kategori' => ['required', 'string', 'max:80'],
            'mitra_id' => ['nullable', 'exists:mitras,id'],
            'penyelenggara' => ['required', 'string', 'max:150'],
            'lokasi' => ['required', 'string', 'max:150'],
            'tanggal_mulai' => ['required', 'date'],
            'tanggal_selesai' => ['required', 'date', 'after_or_equal:tanggal_mulai'],
            'kuota' => ['required', 'integer', 'min:1', 'max:10000'],
            'peserta' => ['nullable', 'integer', 'min:0', 'lte:kuota'],
            'status' => ['required', 'in:Pendaftaran,Berjalan,Selesai'],
            'kriteria' => ['required', 'string', 'max:500'],
            'keahlian_dihasilkan' => ['nullable', 'string', 'max:500'],
            'deskripsi' => ['nullable', 'string', 'max:2000'],
        ], [
            'peserta.lte' => 'Jumlah peserta tidak boleh melebihi kuota.',
            'tanggal_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai.',
        ], [
            'mitra_id' => 'penyelenggara mitra',
            'kriteria' => 'kriteria peserta',
            'keahlian_dihasilkan' => 'keahlian yang dihasilkan',
        ]);
    }
}
