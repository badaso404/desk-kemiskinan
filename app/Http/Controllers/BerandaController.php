<?php

namespace App\Http\Controllers;

use App\Support\DataPelatihan;

class BerandaController extends Controller
{
    public function index()
    {
        $statistik = [
            ['angka' => '45K+', 'label' => 'Warga Terdata'],
            ['angka' => '42K+', 'label' => 'Data Terverifikasi'],
            ['angka' => '120+', 'label' => 'Program Pelatihan'],
            ['angka' => '15K+', 'label' => 'Peserta Pelatihan'],
        ];

        $langkah = [
            [
                'judul' => 'Daftar',
                'teks' => 'Datang ke kami untuk mendaftarkan diri.',
                'ikon' => 'daftar',
            ],
            [
                'judul' => 'Isi Data',
                'teks' => 'Kami akan memasukkan data pelapor untuk mendapatkan program ini.',
                'ikon' => 'isi-data',
            ],
            [
                'judul' => 'Verifikasi',
                'teks' => 'Kami akan verifikasi ulang apakah pelapor cocok untuk mendapatkan program ini.',
                'ikon' => 'verifikasi',
            ],
            [
                'judul' => 'Akses Program',
                'teks' => 'Pelapor akan ditempatkan di program sesuai kriteria pelapor.',
                'ikon' => 'akses',
            ],
        ];

        $pelatihan = DataPelatihan::all();

        return view('beranda', compact('statistik', 'langkah', 'pelatihan'));
    }
}
