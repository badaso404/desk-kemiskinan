<?php

namespace App\Http\Controllers;

use App\Models\Masyarakat;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    public function index(Request $request)
    {
        $query = Masyarakat::query();

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(nik) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(keahlian) LIKE ?', ["%{$search}%"]);
            });
        }

        // Filter Wilayah (Kecamatan)
        if ($request->filled('wilayah')) {
            $query->where('kecamatan', $request->wilayah);
        }

        // Filter Status Pekerjaan
        if ($request->filled('status')) {
            $query->where('status_pekerjaan', $request->status);
        }

        $masyarakat = $query->latest()->paginate(10)->withQueryString();

        $ringkasan = [
            'total_masyarakat' => Masyarakat::count(),
            'butuh_pekerjaan'  => Masyarakat::whereIn('status_pekerjaan', ['Belum / Tidak Bekerja', 'Terkena PHK'])->count(),
            'sudah_bekerja'    => Masyarakat::whereNotIn('status_pekerjaan', ['Belum / Tidak Bekerja', 'Terkena PHK'])->count(),
            'dalam_pelatihan'  => Masyarakat::whereNotNull('minat_pelatihan')->where('minat_pelatihan', '!=', '')->count(),
        ];

        $wilayahList = ['Cengkareng', 'Grogol Petamburan', 'Kalideres', 'Kebon Jeruk', 'Kembangan', 'Palmerah', 'Taman Sari', 'Tambora'];

        return view('admin.masyarakat', compact('masyarakat', 'ringkasan', 'wilayahList'));
    }

    public function create()
    {
        return view('masyarakat_create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:masyarakats,nik',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'telepon' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'alamat' => 'required|string',
            'status_pekerjaan' => 'required|string',
            'lama_menganggur' => 'nullable|string',
            'alasan_tidak_bekerja' => 'nullable|string',
            'pengalaman_terakhir' => 'nullable|string',
            'lama_pengalaman' => 'nullable|string',
            'tipe_pekerjaan_dicari' => 'nullable|string',
            'status_dtks' => 'nullable|string',
            'pendapatan_bulanan' => 'nullable|string',
            'jumlah_tanggungan' => 'nullable|numeric',
            'status_rumah' => 'nullable|string',
            'bantuan' => 'nullable|array',
            'pendidikan_terakhir' => 'required|string',
            'jurusan' => 'nullable|string',
            'keahlian' => 'required|string',
            'sertifikat' => 'nullable|array',
            'minat_pelatihan' => 'nullable|string',
        ]);

        $validated['jumlah_tanggungan'] = $validated['jumlah_tanggungan'] ?? 0;

        Masyarakat::create($validated);

        return redirect()->route('admin.masyarakat')->with('success', 'Data masyarakat berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $masyarakat = Masyarakat::findOrFail($id);
        return view('masyarakat_edit', compact('masyarakat'));
    }

    public function update(Request $request, $id)
    {
        $masyarakat = Masyarakat::findOrFail($id);

        $validated = $request->validate([
            'nik' => 'required|numeric|digits:16|unique:masyarakats,nik,' . $id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'telepon' => ['required', 'regex:/^(\+62|62|0)8[1-9][0-9]{6,11}$/'],
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'alamat' => 'required|string',
            'status_pekerjaan' => 'required|string',
            'lama_menganggur' => 'nullable|string',
            'alasan_tidak_bekerja' => 'nullable|string',
            'pengalaman_terakhir' => 'nullable|string',
            'lama_pengalaman' => 'nullable|string',
            'tipe_pekerjaan_dicari' => 'nullable|string',
            'status_dtks' => 'nullable|string',
            'pendapatan_bulanan' => 'nullable|string',
            'jumlah_tanggungan' => 'nullable|numeric',
            'status_rumah' => 'nullable|string',
            'bantuan' => 'nullable|array',
            'pendidikan_terakhir' => 'required|string',
            'jurusan' => 'nullable|string',
            'keahlian' => 'required|string',
            'sertifikat' => 'nullable|array',
            'minat_pelatihan' => 'nullable|string',
        ]);

        $validated['jumlah_tanggungan'] = $validated['jumlah_tanggungan'] ?? 0;

        $masyarakat->update($validated);

        return redirect()->route('admin.masyarakat')->with('success', 'Data masyarakat berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $masyarakat = Masyarakat::find($id);

        if ($masyarakat) {
            $masyarakat->delete();
            return redirect()->route('admin.masyarakat')->with('success', 'Data masyarakat berhasil dihapus!');
        }

        return redirect()->route('admin.masyarakat')->with('error', 'Data tidak ditemukan!');
    }

    public function show($id)
{
    $masyarakat = Masyarakat::findOrFail($id);
    return view('admin.masyarakat_show', compact('masyarakat'));
}
}