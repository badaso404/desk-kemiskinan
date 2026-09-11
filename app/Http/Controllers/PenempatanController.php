<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Penempatan;
use App\Models\Masyarakat;
use App\Models\Program;
use Illuminate\Http\Request;

class PenempatanController extends Controller
{
    public function index()
    {
        // Tarik data penempatan beserta relasinya untuk menghindari N+1 query
        $penempatan = Penempatan::with(['masyarakat', 'program.mitra'])->latest()->get();

        // Format data agar sesuai dengan variabel di penempatan.blade.php
        $kandidat = $penempatan->map(function ($item) {
            return (object) [
                'id' => $item->id,
                'nama' => $item->masyarakat->nama,
                'nik' => $item->masyarakat->nik,
                'posisi' => $item->program->nama, // Menggunakan nama program sebagai posisi
                'pemberi_kerja' => $item->program->mitra->nama ?? $item->program->penyelenggara,
                'tanggal_penempatan' => $item->tanggal_penempatan,
                'status' => $item->status,
            ];
        });

        // Hitung statistik untuk Summary Cards
        $stats = [
            'total' => $penempatan->count(),
            'belum' => $penempatan->where('status', 'Seleksi')->count(),
            'sudah' => $penempatan->whereIn('status', ['Diterima', 'Bekerja'])->count(),
        ];

        return view('penempatan', compact('kandidat', 'stats'));
    }

    /**
     * Menerima parameter otomatis dari halaman rekomendasi.
     */
    public function create(Request $request)
    {
        // Jika admin mengklik dari halaman Rekomendasi, ID akan otomatis terisi
        $masyarakat_id = $request->query('masyarakat_id');
        $program_id = $request->query('program_id');

        $daftarMasyarakat = Masyarakat::orderBy('nama')->get();
        $daftarProgram = Program::with('mitra')->orderBy('nama')->get();

        return view('admin.penempatan.create', compact(
            'daftarMasyarakat', 
            'daftarProgram', 
            'masyarakat_id', 
            'program_id'
        ));
    }

public function store(Request $request)
    {
        $validated = $request->validate([
            'masyarakat_id' => ['required', 'exists:masyarakats,id'],
            'program_id' => ['required', 'exists:programs,id'],
            'tanggal_penempatan' => ['nullable', 'date'],
            'status' => ['required', 'in:Seleksi,Diterima,Bekerja,Ditolak'],
        ]);


        $sudahAda = Penempatan::where('masyarakat_id', $validated['masyarakat_id'])
                              ->where('program_id', $validated['program_id'])
                              ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Kandidat ini sudah didaftarkan pada program tersebut.');
        }

        // Simpan langsung ke database
        Penempatan::create($validated);

        // Langsung arahkan ke halaman daftar penempatan (index)
        return redirect()->route('penempatan.index')
                         ->with('success', 'Kandidat berhasil ditempatkan!');
    }
    /**
     * Menampilkan detail penempatan
     */
    public function show($id)
    {
        $penempatan = Penempatan::with(['masyarakat', 'program.mitra'])->findOrFail($id);
        
        return view('show', compact('penempatan'));
    }

    /**
     * Menampilkan form edit
     */
    public function edit($id)
    {
        $penempatan = Penempatan::findOrFail($id);
        $daftarMasyarakat = Masyarakat::orderBy('nama')->get();
        $daftarProgram = Program::with('mitra')->orderBy('nama')->get();

        return view('penempatan-edit', compact('penempatan', 'daftarMasyarakat', 'daftarProgram'));
    }

    /**
     * Menyimpan perubahan data penempatan
     */
    public function update(Request $request, $id)
    {
        $penempatan = Penempatan::findOrFail($id);

        $validated = $request->validate([
            'masyarakat_id' => ['required', 'exists:masyarakats,id'],
            'program_id' => ['required', 'exists:programs,id'],
            'tanggal_penempatan' => ['nullable', 'date'],
            'status' => ['required', 'in:Seleksi,Diterima,Bekerja,Ditolak'],
        ]);

        // Cek agar tidak bentrok dengan data penempatan lain (Kecuali dirinya sendiri)
        $sudahAda = Penempatan::where('masyarakat_id', $validated['masyarakat_id'])
            ->where('program_id', $validated['program_id'])
            ->where('id', '!=', $id)
            ->exists();

        if ($sudahAda) {
            return redirect()->back()->with('error', 'Kandidat ini sudah didaftarkan pada program tersebut.');
        }

        $penempatan->update($validated);

        return redirect()->route('penempatan.index')->with('success', 'Data penempatan berhasil diperbarui.');
    }
}