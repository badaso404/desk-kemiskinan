<?php

namespace App\Exports;

use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MasyarakatDummyExport implements FromArray, WithHeadings, WithStyles
{
    protected int $perKecamatan;

    public function __construct(int $perKecamatan = 50)
    {
        $this->perKecamatan = $perKecamatan;
    }

    public function headings(): array
    {
        return [
            'nama',
            'nik',
            'jenis_kelamin',
            'tanggal_lahir',
            'telepon',
            'kecamatan',
            'kelurahan',
            'alamat',
            'pendidikan_terakhir',
            'status_pekerjaan',
            'keahlian_minat',
        ];
    }

    public function array(): array
    {
        $kecamatanKelurahan = [
            'Cengkareng' => [
                'Cengkareng Barat', 'Cengkareng Timur', 'Duri Kosambi',
                'Kapuk', 'Kedaung Kali Angke', 'Rawa Buaya',
            ],
            'Grogol Petamburan' => [
                'Grogol', 'Jelambar', 'Jelambar Baru',
                'Tanjung Duren Selatan', 'Tanjung Duren Utara',
                'Tomang', 'Wijaya Kusuma',
            ],
            'Kalideres' => [
                'Kalideres', 'Kamal', 'Pegadungan', 'Semanan', 'Tegal Alur',
            ],
            'Kebon Jeruk' => [
                'Duri Kepa', 'Kebon Jeruk', 'Kedoya Selatan', 'Kedoya Utara',
                'Kelapa Dua', 'Sukabumi Selatan', 'Sukabumi Utara',
            ],
            'Kembangan' => [
                'Joglo', 'Kembangan Selatan', 'Kembangan Utara',
                'Meruya Selatan', 'Meruya Utara', 'Srengseng',
            ],
            'Palmerah' => [
                'Jatipulo', 'Kemanggisan', 'Kota Bambu Selatan',
                'Kota Bambu Utara', 'Palmerah', 'Slipi',
            ],
            'Taman Sari' => [
                'Glodok', 'Keagungan', 'Krukut', 'Mangga Besar',
                'Maphar', 'Pinangsia', 'Taman Sari', 'Tangki',
            ],
            'Tambora' => [
                'Angke', 'Duri Selatan', 'Duri Utara', 'Jembatan Besi',
                'Jembatan Lima', 'Kali Anyar', 'Krendang', 'Pekojan',
                'Roa Malaka', 'Tambora', 'Tanah Sereal',
            ],
        ];

        $namaDepanLaki = [
            'Ahmad', 'Budi', 'Eko', 'Fajar', 'Hadi', 'Indra', 'Joko', 'Lukman',
            'Oscar', 'Tono', 'Umar', 'Wawan', 'Yusuf', 'Bayu', 'Rizki',
            'Hendra', 'Dedi', 'Slamet', 'Agus', 'Iwan', 'Andi', 'Rudi',
        ];

        $namaDepanPerempuan = [
            'Citra', 'Dewi', 'Gita', 'Kartika', 'Maya', 'Nanda', 'Putri',
            'Rina', 'Sari', 'Vina', 'Zahra', 'Dian', 'Anisa', 'Lina',
            'Siti', 'Rahma', 'Indah', 'Fitri', 'Ayu', 'Nia', 'Ratna', 'Lia',
        ];

        $namaBelakang = [
            'Pratama', 'Wijaya', 'Kusuma', 'Setiawan', 'Hidayat', 'Rahman',
            'Putra', 'Sari', 'Lestari', 'Nugroho', 'Santoso', 'Hartono',
            'Susanto', 'Wibowo', 'Handoko', 'Maulana', 'Firmansyah',
            'Saputra', 'Kurniawan', 'Utami',
        ];

        $pendidikan = ['SD', 'SMP', 'SMA/SMK', 'D3', 'S1', 'S2'];

        $statusPekerjaan = [
            'Belum / Tidak Bekerja',
            'Pekerja Lepas / Serabutan',
            'Terkena PHK',
        ];

        $keahlian = [
            'Otomotif, Mengemudi', 'Menjahit, Tata Busana', 'Memasak, Kuliner',
            'Komputer, Administrasi', 'Marketing, Penjualan', 'Bengkel, Las',
            'Kebersihan, Jasa', 'Desain Grafis', 'Bahasa Inggris', 'Perhotelan',
            'Servis Elektronik', 'Pertukangan', 'Barista, Kopi', 'Rias, Kecantikan',
        ];

        $namaJalan = [
            'Jl. Raya Cengkareng', 'Jl. Daan Mogot', 'Jl. Panjang',
            'Jl. Kedoya Raya', 'Jl. Meruya Ilir', 'Jl. Srengseng Raya',
            'Jl. Joglo Raya', 'Jl. Pos Pengumben', 'Jl. Panjang Arteri',
            'Jl. Tanjung Duren Raya', 'Jl. Kebon Jeruk Raya', 'Jl. Perjuangan',
            'Jl. Pangeran Tubagus Angke', 'Jl. Jembatan Dua', 'Jl. Latumenten',
            'Jl. Kyai Tapa', 'Jl. Tomang Raya', 'Jl. Teuku Nyak Arief',
        ];

        $rows      = [];
        $counter   = 1;
        $nameIndex = 0;
        $baseDate  = Carbon::now();

        foreach ($kecamatanKelurahan as $kecamatan => $listKelurahan) {
            for ($i = 1; $i <= $this->perKecamatan; $i++) {

                // Tentukan jenis kelamin dulu
                $jenisKelamin = (mt_rand(0, 1) === 1) ? 'Laki-laki' : 'Perempuan';

                // Ambil nama depan sesuai jenis kelamin
                if ($jenisKelamin === 'Laki-laki') {
                    $depan = $namaDepanLaki[$nameIndex % count($namaDepanLaki)];
                } else {
                    $depan = $namaDepanPerempuan[$nameIndex % count($namaDepanPerempuan)];
                }
                $belakang = $namaBelakang[($nameIndex * 3 + 7) % count($namaBelakang)];
                $nama     = "{$depan} {$belakang}";
                $nameIndex++;

                // NIK 16 digit unik
                $nik = '3173010' . str_pad((string) $counter, 9, '0', STR_PAD_LEFT);

                // Tanggal lahir: usia 18–55
                $usia         = mt_rand(18, 55);
                $tanggalLahir = $baseDate->copy()
                    ->subYears($usia)
                    ->subDays(mt_rand(0, 364))
                    ->format('Y-m-d');

                // Telepon: 08 + digit kedua (1-9) + 8 digit random = 11 digit total
                // Cocok dengan regex /^(\+62|62|0)8[1-9][0-9]{6,11}$/
                $telepon = '08' . mt_rand(1, 9) . str_pad((string) mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT);

                $kelurahan     = $listKelurahan[array_rand($listKelurahan)];
                $pendidikanVal = $pendidikan[array_rand($pendidikan)];
                $statusVal     = $statusPekerjaan[array_rand($statusPekerjaan)];
                $keahlianVal   = $keahlian[array_rand($keahlian)];

                // Alamat lengkap
                $alamatVal = $namaJalan[array_rand($namaJalan)]
                           . ' No. ' . mt_rand(1, 200)
                           . ', RT ' . str_pad((string) mt_rand(1, 15), 2, '0', STR_PAD_LEFT)
                           . '/RW ' . str_pad((string) mt_rand(1, 12), 2, '0', STR_PAD_LEFT);

                $rows[] = [
                    $nama,
                    $nik,
                    $jenisKelamin,
                    $tanggalLahir,
                    $telepon,
                    $kecamatan,
                    $kelurahan,
                    $alamatVal,
                    $pendidikanVal,
                    $statusVal,
                    $keahlianVal,
                ];

                $counter++;
            }
        }

        return $rows;
    }

    public function styles(Worksheet $sheet)
    {
        // Header — navy + teks putih + bold
        $sheet->getStyle('A1:K1')->getFont()->setBold(true);
        $sheet->getStyle('A1:K1')->getFont()->getColor()->setARGB('FFFFFFFF');
        $sheet->getStyle('A1:K1')->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FF12395B');

        $widths = [
            'A' => 22,  // nama
            'B' => 20,  // nik
            'C' => 14,  // jenis_kelamin
            'D' => 14,  // tanggal_lahir
            'E' => 16,  // telepon
            'F' => 22,  // kecamatan
            'G' => 22,  // kelurahan
            'H' => 32,  // alamat
            'I' => 18,  // pendidikan
            'J' => 22,  // status pekerjaan
            'K' => 26,  // keahlian
        ];
        foreach ($widths as $col => $w) {
            $sheet->getColumnDimension($col)->setWidth($w);
        }

        return [];
    }
}