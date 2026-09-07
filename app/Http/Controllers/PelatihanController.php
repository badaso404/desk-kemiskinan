<?php

namespace App\Http\Controllers;

use App\Support\DataPelatihan;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PelatihanController extends Controller
{
    public function show(string $slug)
    {
        $pelatihan = DataPelatihan::cari($slug);

        if (! $pelatihan) {
            throw new NotFoundHttpException('Pelatihan tidak ditemukan.');
        }

        $lainnya = array_values(array_filter(
            DataPelatihan::all(),
            fn ($item) => $item['slug'] !== $slug
        ));

        return view('pelatihan.detail', compact('pelatihan', 'lainnya'));
    }
}
