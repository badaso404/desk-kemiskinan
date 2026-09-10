<?php

namespace App\Http\Controllers;

use App\Models\Penempatan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PenempatanController extends Controller
{
    // READ: Menampilkan halaman utama (Tabel)
    public function index(): View
    {
        // Mengambil semua data dari database terbaru
        $kandidat = Penempatan::latest()->get();

        // Menghitung statistik otomatis dari database
        $stats = [
            'total' => $kandidat->count(),
            'belum' => $kandidat->where('status', 'Seleksi')->count(),
            'sudah' => $kandidat->whereIn('status', ['Bekerja', 'Diterima'])->count()
        ];

        return view('penempatan', compact('kandidat', 'stats'));
    }

    // CREATE: Menampilkan halaman form tambah data
    public function create(): View
    {
        return view('penempatan_tambah');
    }

    // STORE: Proses menyimpan data ke database
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|string|max:16',
            'posisi' => 'required|string|max:255',
            'pemberi_kerja' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'status' => 'required|string'
        ]);

        // 2. Simpan ke database
        Penempatan::create([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'posisi' => $request->posisi,
            'pemberi_kerja' => $request->pemberi_kerja,
            'tanggal_penempatan' => $request->tanggal,
            'status' => $request->status,
        ]);

        // 3. Kembali ke halaman utama dengan pesan sukses
        return redirect()->route('penempatan.index')->with('success', 'Data kandidat berhasil ditambahkan!');
    }

    // READ: Menampilkan halaman detail data (View)
    public function show($id): View
    {
        $penempatan = Penempatan::findOrFail($id);
        return view('penempatan-detail', compact('penempatan'));
    }

    // UPDATE (Tampilkan Form): Menampilkan halaman edit dengan data sebelumnya
    public function edit($id): View
    {
        $penempatan = Penempatan::findOrFail($id);
        return view('penempatan-edit', compact('penempatan'));
    }

    // UPDATE (Proses): Menyimpan perubahan data ke database
    public function update(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'posisi' => 'required|string|max:255',
            'pemberi_kerja' => 'required|string|max:255',
            'tanggal' => 'nullable|date',
            'status' => 'required|string'
        ]);

        $penempatan = Penempatan::findOrFail($id);
        
        $penempatan->update([
            'nama' => $request->nama,
            'nik' => $request->nik,
            'posisi' => $request->posisi,
            'pemberi_kerja' => $request->pemberi_kerja,
            'tanggal_penempatan' => $request->tanggal,
            'status' => $request->status,
        ]);

        return redirect()->route('penempatan.index')->with('success', 'Data kandidat berhasil diperbarui!');
    }
}