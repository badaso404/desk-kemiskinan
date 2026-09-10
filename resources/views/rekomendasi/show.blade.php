@extends('layouts.admin')

@section('title', 'Detail Rekomendasi')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="space-y-6 p-8 text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif; background: #FAF8F5; min-height: calc(100vh - 90px);">
    <div class="flex items-center justify-between gap-3">
        <div>
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-emerald-700">Detail Masyarakat</p>
            <h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-900">Andi Saputra</h1>
        </div>
        <a href="{{ route('admin.rekomendasi.index') }}" class="inline-flex items-center gap-2 rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.1fr_1.9fr]">
        <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
            <div class="flex items-center gap-4">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-blue-100 text-xl font-bold text-blue-600">AS</div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900">Andi Saputra</h2>
                    <p class="text-sm text-slate-500">NIK: 3171234567890001</p>
                </div>
            </div>

            <div class="mt-6 space-y-4 text-sm text-slate-600">
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Kecamatan</span>
                    <span class="font-semibold text-slate-800">Kebayoran Baru</span>
                </div>
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Kelurahan</span>
                    <span class="font-semibold text-slate-800">Jakarta Selatan</span>
                </div>
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Status</span>
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Aktif
                    </span>
                </div>
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 pb-3">
                    <span class="text-slate-500">Keahlian</span>
                    <span class="font-semibold text-slate-800">Driver, Mekanik Dasar</span>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center justify-between gap-3">
                    <h2 class="text-xl font-bold text-slate-900">Rekomendasi Pekerjaan</h2>
                    <span class="rounded-full bg-emerald-100 px-2.5 py-1 text-xs font-bold text-emerald-700">Match 94%</span>
                </div>

                <div class="mt-5 grid gap-4 md:grid-cols-2">
                    @foreach ($perusahaan as $mitra)
                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-4">
                            <div class="flex items-start justify-between gap-3">
                                <p class="text-xs font-semibold uppercase tracking-[0.18em] {{ $mitra['sumber'] === 'UKPD' ? 'text-blue-700' : 'text-orange-700' }}">
                                    {{ $mitra['sumber'] }}
                                </p>
                                <span class="rounded-full bg-emerald-100 px-2 py-1 text-[10px] font-bold text-emerald-700">Match {{ $mitra['match'] }}%</span>
                            </div>
                            <h3 class="mt-2 text-lg font-bold text-slate-900">{{ $mitra['nama'] }}</h3>
                            <p class="mt-1 text-sm font-semibold text-slate-700">{{ $mitra['posisi'] }}</p>
                            <p class="mt-2 text-sm text-slate-600">{{ $mitra['lokasi'] }} &middot; {{ $mitra['tersedia'] }} posisi tersedia</p>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-xl font-bold text-slate-900">Alasan Rekomendasi</h2>

                <ul class="mt-5 space-y-3 text-sm text-slate-600">
                    <li class="flex gap-3">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-[10px] font-bold text-emerald-700">✓</span>
                        <span>Memiliki kemampuan fokus pada mobilitas dan operasional harian.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-[10px] font-bold text-emerald-700">✓</span>
                        <span>Kompetensi dasar mekanik mendukung perawatan kendaraan dan tugas lapangan.</span>
                    </li>
                    <li class="flex gap-3">
                        <span class="mt-0.5 inline-flex h-5 w-5 items-center justify-center rounded-full bg-emerald-100 text-[10px] font-bold text-emerald-700">✓</span>
                        <span>Profil kerja yang sesuai dengan kriteria kebutuhan mitra pemberdayaan setempat.</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
