<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Mitra;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function create()
    {
        return view('admin.pemberdayaan.mitra-form', ['mitra' => new Mitra()]);
    }

    public function store(Request $request)
    {
        Mitra::create($this->validasi($request));

        return redirect()
            ->route('admin.pemberdayaan')
            ->with('sukses', 'Penyelenggara berhasil ditambahkan.');
    }

    public function show(Mitra $mitra)
    {
        $mitra->load('program');

        return view('admin.pemberdayaan.mitra-detail', compact('mitra'));
    }

    public function edit(Mitra $mitra)
    {
        return view('admin.pemberdayaan.mitra-form', compact('mitra'));
    }

    public function update(Request $request, Mitra $mitra)
    {
        $mitra->update($this->validasi($request));

        return redirect()
            ->route('admin.mitra.show', $mitra)
            ->with('sukses', 'Data penyelenggara berhasil diperbarui.');
    }

    public function destroy(Mitra $mitra)
    {
        $mitra->delete();

        return redirect()
            ->route('admin.pemberdayaan')
            ->with('sukses', 'Penyelenggara berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validasi(Request $request): array
    {
        return $request->validate([
            'nama' => ['required', 'string', 'max:150'],
            'jenis' => ['required', 'in:UKPD,CSR'],
            'bidang' => ['nullable', 'string', 'max:100'],
            'narahubung' => ['nullable', 'string', 'max:100'],
            'telepon' => ['nullable', 'string', 'max:30'],
            'alamat' => ['nullable', 'string', 'max:500'],
        ], [], [
            'nama' => 'nama mitra',
            'jenis' => 'jenis mitra',
        ]);
    }
}
