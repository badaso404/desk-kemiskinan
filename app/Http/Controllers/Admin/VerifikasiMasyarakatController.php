<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditTrail;
use App\Models\Masyarakat;
use Illuminate\Http\Request;

class VerifikasiMasyarakatController extends Controller
{
    // Nama method disesuaikan dengan Route Anda
    public function verifikasi_masyarakat(Request $request)
    {
        // Query hanya untuk masyarakat yang BELUM DIVERIFIKASI
        $unverifiedQuery = Masyarakat::where(function($q) {
            $q->where('status_verifikasi', '!=', 'Terverifikasi')
              ->orWhereNull('status_verifikasi');
        });

        if ($request->filled('search')) {
            $search = strtolower(trim($request->search));
            $unverifiedQuery->where(function($q) use ($search) {
                $q->whereRaw('LOWER(nama) LIKE ?', ["%{$search}%"])
                  ->orWhereRaw('LOWER(nik) LIKE ?', ["%{$search}%"]);
            });
        }

        $masyarakatList = $unverifiedQuery->latest()->get();

        $selectedId = $request->get('id', optional($masyarakatList->first())->id);
        $selectedMasyarakat = $selectedId ? Masyarakat::find($selectedId) : null;

        $ringkasan = [
            'total_masyarakat' => Masyarakat::count(),
            'belum_verifikasi' => Masyarakat::where(function($q) {
                                      $q->where('status_verifikasi', '!=', 'Terverifikasi')
                                        ->orWhereNull('status_verifikasi');
                                  })->count(),
            'terverifikasi'    => Masyarakat::where('status_verifikasi', 'Terverifikasi')->count(),
        ];

        return view('admin.Verifikasi-data.verifikasi_masyarakat', compact('masyarakatList', 'selectedMasyarakat', 'ringkasan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'desil'              => 'nullable|string',
            'tanggal_verifikasi' => 'required|date',
            'status_verifikasi'  => 'required|in:Pending,Terverifikasi',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $masyarakat = Masyarakat::findOrFail($id);
        
        $masyarakat->update([
            'desil'              => $request->desil,
            'tanggal_verifikasi' => $request->tanggal_verifikasi ?? now()->toDateString(),
            'status_verifikasi'  => $request->status_verifikasi,
            'catatan_verifikasi' => $request->catatan_verifikasi,
            'updated_at'         => now(),
        ]);

        if (class_exists(AuditTrail::class)) {
            AuditTrail::log(
                'update_desil',
                'masyarakat',
                'Verifikasi status masyarakat "' . $masyarakat->nama . '" diubah menjadi ' . $request->status_verifikasi,
                Masyarakat::class,
                $masyarakat->id,
                ['nik' => $masyarakat->nik, 'status_verifikasi' => $request->status_verifikasi,
                'desil' => $request->desil ? 'Desil ' . $request->desil : '-']
                
            );
        }

        return redirect()->back()->with('success', 'Status verifikasi data masyarakat berhasil diperbarui!');
    }
}