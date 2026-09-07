<?php

namespace App\Support;

/**
 * Sumber data pelatihan sementara.
 * Ganti isi all() dengan query model saat tabel pelatihan sudah tersedia.
 */
class DataPelatihan
{
    public static function all(): array
    {
        return [
            [
                'slug' => 'pemasaran-digital-dasar',
                'gambar' => 'pelatihan-digital.jpg',
                'kategori' => 'Teknologi',
                'kuota' => 'Sisa Kuota: 12',
                'judul' => 'Pelatihan Pemasaran Digital Dasar',
                'penyelenggara' => 'Suku Dinas Tenaga Kerja, Transmigrasi dan Energi',
                'tanggal' => '15 - 20 Nov 2024',
                'lokasi' => 'Aula Walikota Jakarta Barat',
                'durasi' => '6 hari (30 jam pelajaran)',
                'biaya' => 'Gratis',
                'deskripsi' => 'Program pengenalan pemasaran digital bagi warga yang ingin memasarkan produk atau jasanya secara daring. Peserta dibimbing dari dasar, mulai dari menyiapkan akun toko sampai menyusun konten promosi sederhana.',
                'materi' => [
                    'Dasar pemasaran digital dan perilaku konsumen daring',
                    'Membuat dan menata etalase toko di marketplace',
                    'Fotografi produk menggunakan telepon genggam',
                    'Menyusun konten promosi media sosial',
                    'Membaca laporan penjualan sederhana',
                ],
                'syarat' => [
                    'Warga ber-KTP Jakarta Barat',
                    'Berusia minimal 17 tahun',
                    'Terdata dan terverifikasi oleh kelurahan',
                    'Memiliki telepon pintar',
                ],
            ],
            [
                'slug' => 'kewirausahaan-kuliner',
                'gambar' => 'pelatihan-kuliner.jpg',
                'kategori' => 'Kuliner',
                'kuota' => 'Sisa Kuota: 5',
                'judul' => 'Bimbingan Teknis Kewirausahaan Kuliner',
                'penyelenggara' => 'Suku Dinas PPKUKM',
                'tanggal' => '22 - 25 Nov 2024',
                'lokasi' => 'Kecamatan Kebon Jeruk',
                'durasi' => '4 hari (24 jam pelajaran)',
                'biaya' => 'Gratis',
                'deskripsi' => 'Bimbingan teknis bagi pelaku usaha kuliner rumahan agar mampu mengelola usaha secara lebih tertata, mulai dari standar kebersihan pangan sampai perhitungan harga jual yang wajar.',
                'materi' => [
                    'Keamanan dan kebersihan pengolahan pangan',
                    'Menyusun resep standar dan takaran porsi',
                    'Menghitung harga pokok dan harga jual',
                    'Pengemasan dan pelabelan produk',
                    'Pengurusan izin usaha mikro',
                ],
                'syarat' => [
                    'Warga ber-KTP Jakarta Barat',
                    'Berusia minimal 17 tahun',
                    'Terdata dan terverifikasi oleh kelurahan',
                    'Sedang atau berencana menjalankan usaha kuliner',
                ],
            ],
            [
                'slug' => 'menjahit-tingkat-dasar',
                'gambar' => 'pelatihan-menjahit.jpg',
                'kategori' => 'Keterampilan',
                'kuota' => 'Penuh',
                'judul' => 'Pelatihan Menjahit Tingkat Dasar',
                'penyelenggara' => 'Pusat Pelatihan Kerja Daerah',
                'tanggal' => '01 - 10 Des 2024',
                'lokasi' => 'PPKD Jakarta Barat',
                'durasi' => '10 hari (60 jam pelajaran)',
                'biaya' => 'Gratis',
                'deskripsi' => 'Pelatihan keterampilan menjahit dari nol, diarahkan untuk menyiapkan peserta bekerja di industri konveksi atau membuka jasa jahit mandiri. Praktik dilakukan langsung dengan mesin jahit di workshop PPKD.',
                'materi' => [
                    'Pengenalan dan perawatan mesin jahit',
                    'Mengukur badan dan membuat pola dasar',
                    'Teknik memotong bahan',
                    'Menjahit pakaian sederhana',
                    'Penyelesaian akhir dan pemeriksaan mutu',
                ],
                'syarat' => [
                    'Warga ber-KTP Jakarta Barat',
                    'Berusia minimal 17 tahun',
                    'Terdata dan terverifikasi oleh kelurahan',
                    'Sehat jasmani dan siap mengikuti seluruh sesi',
                ],
            ],
        ];
    }

    public static function cari(string $slug): ?array
    {
        foreach (self::all() as $pelatihan) {
            if ($pelatihan['slug'] === $slug) {
                return $pelatihan;
            }
        }

        return null;
    }
}
