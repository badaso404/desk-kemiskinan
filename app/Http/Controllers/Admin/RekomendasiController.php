<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Masyarakat;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RekomendasiController extends Controller
{
    /**
     * Daftar usulan: satu baris = satu pasangan warga x program pelatihan.
     */
    public function index(Request $request)
    {
        $cari = trim((string) $request->query('cari'));
        $kecamatan = trim((string) $request->query('kecamatan'));
        $jenis = trim((string) $request->query('jenis'));

        $warga = Masyarakat::query()
            ->when($cari, fn ($query) => $query->where(fn ($q) => $q
                ->where('nama', 'like', "%{$cari}%")
                ->orWhere('nik', 'like', "%{$cari}%")))
            ->when($kecamatan, fn ($query) => $query->where('kecamatan', $kecamatan))
            ->orderBy('nama')
            ->get();

        $program = Program::with('mitra')
            ->whereIn('status', ['Pendaftaran', 'Berjalan'])
            ->when($jenis, fn ($query) => $query->where('jenis', $jenis))
            ->get();

        $usulan = $warga
            ->map(function (Masyarakat $orang) use ($program) {
                $terbaik = $this->cocokkan($orang, $program)->first();

                return $terbaik ? ['warga' => $orang] + $terbaik : null;
            })
            ->filter()
            ->sortByDesc('skor')
            ->values();

        return view('admin.rekomendasi.index', [
            'usulan' => $usulan,
            'cari' => $cari,
            'kecamatan' => $kecamatan,
            'jenis' => $jenis,
            'daftarKecamatan' => Masyarakat::query()->distinct()->orderBy('kecamatan')->pluck('kecamatan'),
            'jumlahProgram' => $program->count(),
        ]);
    }

    /**
     * Detail satu warga beserta seluruh program yang cocok.
     */
    public function show(Masyarakat $masyarakat)
    {
        $program = Program::with('mitra')->whereIn('status', ['Pendaftaran', 'Berjalan'])->get();

        return view('admin.rekomendasi.show', [
            'warga' => $masyarakat,
            'kecocokan' => $this->cocokkan($masyarakat, $program),
            'minatWarga' => $this->minatWarga($masyarakat),
        ]);
    }

    /**
     * Menghitung skor kecocokan warga terhadap tiap program.
     *
     * Skor disusun dari tiga hal:
     *   - irisan kriteria program dengan keahlian/minat warga (bobot 70)
     *   - kesamaan wilayah (bobot 20)
     *   - ketersediaan kursi (bobot 10)
     *
     * @param  Collection<int, Program>  $daftarProgram
     * @return Collection<int, array{program: Program, skor: int, kriteria_cocok: array<int, string>}>
     */
    private function cocokkan(Masyarakat $warga, Collection $daftarProgram): Collection
    {
        $minat = $this->minatWarga($warga);

        return $daftarProgram
            ->map(function (Program $program) use ($warga, $minat) {
                $kriteria = $program->daftar_kriteria;
                $cocok = array_values(array_intersect($minat, $kriteria));

                $skorKriteria = $kriteria ? count($cocok) / count($kriteria) * 70 : 0;
                $skorWilayah = $this->wilayahSama($warga->kecamatan, $program->lokasi) ? 20 : 0;
                $skorKursi = $program->sisa_kuota > 0 ? 10 : 0;

                return [
                    'program' => $program,
                    'skor' => (int) round($skorKriteria + $skorWilayah + $skorKursi),
                    'kriteria_cocok' => $cocok,
                ];
            })
            ->sortByDesc('skor')
            ->values();
    }

    /**
     * Gabungan keahlian yang sudah dimiliki dan minat pelatihan warga.
     *
     * @return array<int, string>
     */
    private function minatWarga(Masyarakat $warga): array
    {
        return array_values(array_unique(array_merge(
            Program::pecah($warga->keahlian),
            Program::pecah($warga->minat_pelatihan)
        )));
    }

    private function wilayahSama(?string $kecamatan, ?string $lokasi): bool
    {
        if (blank($kecamatan) || blank($lokasi)) {
            return false;
        }

        return str_contains(mb_strtolower($lokasi), mb_strtolower($kecamatan));
    }
}