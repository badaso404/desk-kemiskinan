<?php

namespace Database\Seeders;

use App\Models\Masyarakat;
use App\Models\Mitra;
use App\Models\Program;
use Illuminate\Database\Seeder;

class PemberdayaanSeeder extends Seeder
{
    /**
     * Data contoh agar modul Pemberdayaan dan Rekomendasi bisa langsung dicoba.
     */
    public function run(): void
    {
        $penyelenggara = [
            [
                'nama' => 'Pusat Pelatihan Kerja Daerah Jakarta Barat',
                'jenis' => 'UKPD',
                'bidang' => 'Pelatihan Keterampilan',
                'narahubung' => 'Bagian Penyelenggaraan',
                'telepon' => '0215551001',
                'alamat' => 'Jl. Raya Kembangan, Jakarta Barat',
                'program' => [
                    [
                        'nama' => 'Pelatihan Menjahit Tingkat Dasar',
                        'jenis' => 'Pelatihan',
                        'kategori' => 'Keterampilan',
                        'lokasi' => 'Kembangan, Jakarta Barat',
                        'tanggal_mulai' => '2026-09-01',
                        'tanggal_selesai' => '2026-09-10',
                        'kuota' => 20,
                        'peserta' => 18,
                        'status' => 'Berjalan',
                        'kriteria' => 'menjahit, keterampilan tangan',
                        'keahlian_dihasilkan' => 'menjahit, pola dasar',
                        'deskripsi' => 'Pelatihan menjahit dari nol sampai mampu membuat pakaian sederhana.',
                    ],
                    [
                        'nama' => 'Pelatihan Teknik Otomotif Dasar',
                        'jenis' => 'Pelatihan',
                        'kategori' => 'Otomotif',
                        'lokasi' => 'Cengkareng, Jakarta Barat',
                        'tanggal_mulai' => '2026-10-05',
                        'tanggal_selesai' => '2026-10-20',
                        'kuota' => 15,
                        'peserta' => 4,
                        'status' => 'Pendaftaran',
                        'kriteria' => 'mekanik dasar, mengemudi',
                        'keahlian_dihasilkan' => 'mekanik dasar, servis ringan',
                        'deskripsi' => 'Perawatan dan perbaikan ringan kendaraan roda dua dan empat.',
                    ],
                ],
            ],
            [
                'nama' => 'Suku Dinas PPKUKM Jakarta Barat',
                'jenis' => 'UKPD',
                'bidang' => 'Koperasi dan UKM',
                'narahubung' => 'Seksi Pemberdayaan',
                'telepon' => '0215551002',
                'alamat' => 'Kantor Walikota Jakarta Barat',
                'program' => [
                    [
                        'nama' => 'Bimbingan Teknis Kewirausahaan Kuliner',
                        'jenis' => 'Bimbingan Teknis',
                        'kategori' => 'Kuliner',
                        'lokasi' => 'Kebon Jeruk, Jakarta Barat',
                        'tanggal_mulai' => '2026-09-22',
                        'tanggal_selesai' => '2026-09-25',
                        'kuota' => 25,
                        'peserta' => 5,
                        'status' => 'Pendaftaran',
                        'kriteria' => 'memasak, kuliner, wirausaha',
                        'keahlian_dihasilkan' => 'kuliner, manajemen usaha',
                        'deskripsi' => 'Pengelolaan usaha kuliner rumahan, dari resep standar sampai perizinan.',
                    ],
                ],
            ],
            [
                'nama' => 'PT Sinar Sejahtera Logistik',
                'jenis' => 'CSR',
                'bidang' => 'Logistik',
                'narahubung' => 'Ibu Hartati',
                'telepon' => '0215552001',
                'alamat' => 'Kawasan Industri Kalideres, Jakarta Barat',
                'program' => [
                    [
                        'nama' => 'Pelatihan Pemasaran Digital Dasar',
                        'jenis' => 'Pelatihan',
                        'kategori' => 'Teknologi',
                        'lokasi' => 'Kalideres, Jakarta Barat',
                        'tanggal_mulai' => '2026-08-15',
                        'tanggal_selesai' => '2026-08-20',
                        'kuota' => 20,
                        'peserta' => 20,
                        'status' => 'Selesai',
                        'kriteria' => 'komputer dasar, wirausaha',
                        'keahlian_dihasilkan' => 'pemasaran digital, komputer dasar',
                        'deskripsi' => 'Memasarkan produk secara daring lewat marketplace dan media sosial.',
                    ],
                    [
                        'nama' => 'Seminar Kesiapan Kerja untuk Pemuda',
                        'jenis' => 'Seminar',
                        'kategori' => 'Pengembangan Diri',
                        'lokasi' => 'Grogol Petamburan, Jakarta Barat',
                        'tanggal_mulai' => '2026-09-30',
                        'tanggal_selesai' => '2026-09-30',
                        'kuota' => 100,
                        'peserta' => 42,
                        'status' => 'Pendaftaran',
                        'kriteria' => 'administrasi, komputer dasar, wirausaha',
                        'keahlian_dihasilkan' => null,
                        'deskripsi' => 'Seminar sehari tentang menyiapkan lamaran dan menghadapi wawancara.',
                    ],
                ],
            ],
            [
                'nama' => 'Yayasan Karya Bersama',
                'jenis' => 'CSR',
                'bidang' => 'Sosial Kemasyarakatan',
                'narahubung' => 'Bapak Rudi',
                'telepon' => '0215552002',
                'alamat' => 'Kembangan, Jakarta Barat',
                'program' => [
                    [
                        'nama' => 'Workshop Administrasi Perkantoran',
                        'jenis' => 'Workshop',
                        'kategori' => 'Administrasi',
                        'lokasi' => 'Tambora, Jakarta Barat',
                        'tanggal_mulai' => '2026-10-01',
                        'tanggal_selesai' => '2026-10-03',
                        'kuota' => 30,
                        'peserta' => 8,
                        'status' => 'Pendaftaran',
                        'kriteria' => 'administrasi, komputer dasar',
                        'keahlian_dihasilkan' => 'administrasi, pengarsipan',
                        'deskripsi' => 'Keterampilan dasar administrasi dan pengarsipan digital.',
                    ],
                ],
            ],
        ];

        foreach ($penyelenggara as $data) {
            $daftarProgram = $data['program'];
            unset($data['program']);

            $mitra = Mitra::updateOrCreate(['nama' => $data['nama']], $data);

            foreach ($daftarProgram as $program) {
                $mitra->program()->updateOrCreate(
                    ['nama' => $program['nama']],
                    $program + ['penyelenggara' => $mitra->nama]
                );
            }
        }

        $this->seedWarga();
    }

    /**
     * Beberapa warga contoh supaya modul Rekomendasi punya bahan pencocokan.
     */
    private function seedWarga(): void
    {
        $warga = [
            ['nik' => '3173010101990001', 'nama' => 'Andi Saputra', 'jenis_kelamin' => 'Laki-laki', 'kecamatan' => 'Cengkareng', 'kelurahan' => 'Kapuk', 'keahlian' => 'mengemudi', 'minat_pelatihan' => 'mekanik dasar', 'pendidikan_terakhir' => 'SMA/SMK'],
            ['nik' => '3173010101990002', 'nama' => 'Budi Darmawan', 'jenis_kelamin' => 'Laki-laki', 'kecamatan' => 'Tambora', 'kelurahan' => 'Angke', 'keahlian' => 'komputer dasar', 'minat_pelatihan' => 'administrasi', 'pendidikan_terakhir' => 'SMA/SMK'],
            ['nik' => '3173010101990003', 'nama' => 'Citra Sari', 'jenis_kelamin' => 'Perempuan', 'kecamatan' => 'Kembangan', 'kelurahan' => 'Meruya Utara', 'keahlian' => 'keterampilan tangan', 'minat_pelatihan' => 'menjahit', 'pendidikan_terakhir' => 'SMP'],
            ['nik' => '3173010101990004', 'nama' => 'Dewi Lestari', 'jenis_kelamin' => 'Perempuan', 'kecamatan' => 'Kebon Jeruk', 'kelurahan' => 'Sukabumi Utara', 'keahlian' => 'memasak', 'minat_pelatihan' => 'wirausaha', 'pendidikan_terakhir' => 'SMA/SMK'],
            ['nik' => '3173010101990005', 'nama' => 'Eko Prasetyo', 'jenis_kelamin' => 'Laki-laki', 'kecamatan' => 'Grogol Petamburan', 'kelurahan' => 'Jelambar', 'keahlian' => 'komputer dasar', 'minat_pelatihan' => 'wirausaha', 'pendidikan_terakhir' => 'D3'],
        ];

        foreach ($warga as $data) {
            $lengkap = $data + [
                'tanggal_lahir' => '1999-01-01',
                'telepon' => '081200000000',
                'alamat' => $data['kelurahan'].', '.$data['kecamatan'].', Jakarta Barat',
                'status_pekerjaan' => 'Belum Bekerja',
            ];

            $orang = Masyarakat::firstOrNew(['nik' => $data['nik']]);
            $orang->forceFill($lengkap)->save();
        }
    }
}
