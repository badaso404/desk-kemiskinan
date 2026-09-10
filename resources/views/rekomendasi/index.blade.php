@extends('layouts.admin')

@section('title', 'Rekomendasi Pekerjaan')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="space-y-6 p-8 text-slate-800" style="font-family: 'Plus Jakarta Sans', sans-serif; background: #FAF8F5; min-height: calc(100vh - 90px);">
    <div>
        <h1 class="text-3xl font-extrabold tracking-tight text-slate-900">Rekomendasi Pekerjaan</h1>
        <p class="mt-1 text-sm text-slate-500">Kelola dan pantau pencocokan potensi masyarakat dengan peluang kerja yang tersedia.</p>
    </div>

    <form method="GET" class="space-y-4">
        <div class="relative">
            <svg class="pointer-events-none absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" placeholder="Cari Nama atau NIK..." class="w-full rounded-full border border-slate-200 bg-white py-3 pl-11 pr-4 text-sm text-slate-700 shadow-sm outline-none transition focus:border-transparent focus:ring-2 focus:ring-emerald-600" />
        </div>

        <div class="flex flex-wrap items-center gap-3 text-sm">
            <span class="inline-flex items-center gap-1.5 font-medium text-slate-500">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                Filter:
            </span>

            <select name="kecamatan" class="rounded-full border border-slate-200 bg-white px-4 py-1.5 text-xs font-semibold text-slate-700 shadow-sm outline-none focus:border-transparent focus:ring-2 focus:ring-emerald-600">
                <option value="">Semua Kecamatan</option>
                <option value="Kebayoran Baru">Kebayoran Baru</option>
                <option value="Tebet">Tebet</option>
                <option value="Menteng">Menteng</option>
            </select>

            <select name="keahlian" class="rounded-full border border-slate-200 bg-white px-4 py-1.5 text-xs font-semibold text-slate-700 shadow-sm outline-none focus:border-transparent focus:ring-2 focus:ring-emerald-600">
                <option value="">Semua Keahlian</option>
                <option value="Driver">Driver</option>
                <option value="Security">Security</option>
                <option value="Administrasi">Administrasi</option>
            </select>
        </div>
    </form>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3">
        <div class="flex min-h-[220px] flex-col justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 text-base font-bold text-blue-600">AS</div>
                        <div>
                            <h3 class="text-lg font-bold leading-snug text-slate-900">Andi Saputra</h3>
                            <p class="mt-0.5 flex items-center gap-1 text-[11px] text-slate-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/></svg>
                                3171234567890001
                            </p>
                            <p class="mt-0.5 flex items-center gap-1 text-[11px] text-slate-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Kebayoran Baru, Jakarta Selatan
                            </p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Aktif
                    </span>
                </div>

                <div class="mt-4">
                    <span class="mb-1.5 block text-[11px] font-medium text-slate-400">Keahlian / Minat:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">Driver</span>
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">Mekanik Dasar</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.rekomendasi.show', 1) }}" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#015843] px-4 py-2.5 text-[11px] font-semibold text-white transition hover:bg-[#014534]">
                <span>Lihat Rekomendasi</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="flex min-h-[220px] flex-col justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-indigo-100 text-base font-bold text-indigo-600">BD</div>
                        <div>
                            <h3 class="text-lg font-bold leading-snug text-slate-900">Budi Darmawan</h3>
                            <p class="mt-0.5 flex items-center gap-1 text-[11px] text-slate-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/></svg>
                                3171234567890002
                            </p>
                            <p class="mt-0.5 flex items-center gap-1 text-[11px] text-slate-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Tebet, Jakarta Selatan
                            </p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[10px] font-bold text-emerald-700">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Aktif
                    </span>
                </div>

                <div class="mt-4">
                    <span class="mb-1.5 block text-[11px] font-medium text-slate-400">Keahlian / Minat:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">Security</span>
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">Bela Diri</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.rekomendasi.show', 2) }}" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#015843] px-4 py-2.5 text-[11px] font-semibold text-white transition hover:bg-[#014534]">
                <span>Lihat Rekomendasi</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>

        <div class="flex min-h-[220px] flex-col justify-between rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">
            <div>
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-3.5">
                        <div class="flex h-12 w-12 items-center justify-center rounded-full bg-orange-100 text-base font-bold text-orange-600">CS</div>
                        <div>
                            <h3 class="text-lg font-bold leading-snug text-slate-900">Citra Sari</h3>
                            <p class="mt-0.5 flex items-center gap-1 text-[11px] text-slate-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/></svg>
                                3171234567890003
                            </p>
                            <p class="mt-0.5 flex items-center gap-1 text-[11px] text-slate-500">
                                <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Menteng, Jakarta Pusat
                            </p>
                        </div>
                    </div>
                    <span class="inline-flex items-center gap-1 rounded-full bg-amber-100 px-2.5 py-1 text-[10px] font-bold text-amber-700">
                        <svg class="h-3 w-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/></svg>
                        Diproses
                    </span>
                </div>

                <div class="mt-4">
                    <span class="mb-1.5 block text-[11px] font-medium text-slate-400">Keahlian / Minat:</span>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">Administrasi</span>
                        <span class="rounded-md bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-700">Komputer Dasar</span>
                    </div>
                </div>
            </div>

            <a href="{{ route('admin.rekomendasi.show', 3) }}" class="mt-5 inline-flex w-full items-center justify-center gap-2 rounded-full bg-[#015843] px-4 py-2.5 text-[11px] font-semibold text-white transition hover:bg-[#014534]">
                <span>Lihat Rekomendasi</span>
                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </a>
        </div>
    </div>
</div>
@endsection
