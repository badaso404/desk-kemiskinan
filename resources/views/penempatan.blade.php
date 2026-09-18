@extends('layouts.admin')

@section('title', 'Penempatan')

@section('content')

    {{-- Script Tailwind (Bisa dihapus jika Tailwind sudah terinstall via NPM/Vite di file master layout Anda) --}}
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Notifikasi Pesan Sukses -->
    @if(session('success'))
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            <span class="text-[14px] font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header Halaman -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">PENEMPATAN</h2>
            <p class="text-gray-500 mt-2 text-[15px]">Pantau dan kelola penempatan tenaga kerja.</p>
        </div>

    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Card 1: Total Penerimaan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 text-xs font-semibold tracking-widest uppercase">Total Penerimaan</span>
                <div class="bg-[#3B82F6] text-white w-9 h-9 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                </div>
            </div>
            <div class="text-[40px] leading-none font-bold text-gray-900">{{ $stats['total'] ?? 0 }}</div>
        </div>

        <!-- Card 2: Belum Ditempatkan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 text-xs font-semibold tracking-widest uppercase">Belum Ditempatkan</span>
                <div class="bg-[#C16212] text-white w-9 h-9 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
            <div class="text-[40px] leading-none font-bold text-gray-900">{{ $stats['belum'] ?? 0 }}</div>
        </div>

        <!-- Card 3: Sudah Ditempatkan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex flex-col justify-between">
            <div class="flex justify-between items-center mb-4">
                <span class="text-gray-500 text-xs font-semibold tracking-widest uppercase">Sudah Ditempatkan</span>
                <div class="bg-[#2A7553] text-white w-9 h-9 rounded-full flex items-center justify-center shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                </div>
            </div>
            <div class="text-[40px] leading-none font-bold text-gray-900">{{ $stats['sudah'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white rounded-[1rem] shadow-sm border border-gray-100 overflow-hidden mt-6">

        <!-- Toolbar (Pencarian & Filter) -->
        <div class="p-5 flex justify-between items-center bg-white border-b border-gray-50">
            <div class="relative w-[340px]">
                <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <input type="text" placeholder="Cari kandidat..." class="w-full pl-10 pr-4 py-2 border border-gray-100 rounded-full text-[14px] text-gray-600 focus:outline-none focus:ring-1 focus:ring-[#12395B] bg-[#F8FAFC]">
            </div>
            <div class="flex gap-3">
                <div class="relative">
                    <select class="appearance-none border border-gray-100 text-gray-600 text-[14px] py-2 pl-4 pr-10 rounded-full bg-[#F8FAFC] outline-none cursor-pointer hover:bg-gray-50">
                        <option>Pemberi Kerja</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
                <div class="relative">
                    <select class="appearance-none border border-gray-100 text-gray-600 text-[14px] py-2 pl-4 pr-10 rounded-full bg-[#F8FAFC] outline-none cursor-pointer hover:bg-gray-50">
                        <option>Status</option>
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <!-- Header Tabel -->
                <thead class="bg-[#F4F7FB] text-[#475569] text-[13px] font-bold tracking-wide uppercase">
                    <tr>
                        <th class="px-6 py-4 whitespace-nowrap">Nama Kandidat & NIK</th>
                        <th class="px-6 py-4 whitespace-nowrap">Posisi</th>
                        <th class="px-6 py-4 whitespace-nowrap">Pemberi Kerja</th>
                        <th class="px-6 py-4 whitespace-nowrap">Tanggal Penempatan</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Status</th>
                        <th class="px-6 py-4 text-center whitespace-nowrap">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-[14px] text-[#475569]">

                    @forelse($kandidat ?? [] as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <!-- Kolom Nama & NIK -->
                            <td class="px-6 py-4">
                                <p class="font-semibold text-gray-900 text-[15px]">{{ $item->nama }}</p>
                                <p class="text-gray-400 text-[13px] mt-0.5">{{ $item->nik }}</p>
                            </td>

                            <!-- Kolom Posisi -->
                            <td class="px-6 py-4">{{ $item->posisi }}</td>

                            <!-- Kolom Pemberi Kerja -->
                            <td class="px-6 py-4">{{ $item->pemberi_kerja }}</td>

                            <!-- Kolom Tanggal Penempatan -->
                            <td class="px-6 py-4">
                                {{ $item->tanggal_penempatan ? \Carbon\Carbon::parse($item->tanggal_penempatan)->translatedFormat('d M Y') : '-' }}
                            </td>

                            <!-- Kolom Status (Badge) -->
                            <td class="px-6 py-4 text-center">
                                @php
                                    $badgeStyle = match($item->status) {
                                        'Bekerja'  => 'bg-[#D1FAE5] text-[#065F46]',
                                        'Seleksi'  => 'bg-[#FEF08A] text-[#854D0E]',
                                        'Diterima' => 'bg-[#DBEAFE] text-[#1E40AF]',
                                        default    => 'bg-gray-100 text-gray-600',
                                    };
                                @endphp
                                <span class="{{ $badgeStyle }} py-1.5 px-4 rounded-full text-[13px] font-semibold inline-block">
                                    {{ $item->status }}
                                </span>
                            </td>

                           <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-3">
                                <a href="{{ route('penempatan.edit', $item->id) }}" class="text-gray-400 hover:text-[#12395B] transition" title="Edit Data">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <a href="{{ route('penempatan.show', $item->id) }}" class="text-gray-400 hover:text-[#12395B] transition" title="Lihat Detail">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </div>
                          </td>
                        </tr>
                    @empty
                        <!-- Tampilan Jika Data Kosong -->
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-14 h-14 text-gray-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                    </svg>
                                    <p class="text-gray-500 font-medium text-lg">Belum ada data penempatan</p>
                                    <p class="text-gray-400 text-[14px] mt-1">Silakan klik tombol <span class="font-semibold text-gray-500">"+ Tambah Data"</span> di atas untuk memulai.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination (Footer Tabel) -->
        <div class="p-5 border-t border-gray-100 flex justify-between items-center text-[14px] text-[#475569] bg-white">
            <div>
                Menampilkan
                @if(isset($kandidat) && $kandidat->count() > 0) 1–{{ $kandidat->count() }} @else 0 @endif
                dari {{ $stats['total'] ?? 0 }} data
            </div>

            <div class="flex items-center gap-2">
                <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 text-gray-400 hover:bg-gray-50 transition cursor-pointer">&lt;</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full bg-[#12395B] text-white font-semibold shadow-sm">1</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 text-gray-600 hover:bg-gray-50 transition cursor-pointer">2</button>
                <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 text-gray-600 hover:bg-gray-50 transition cursor-pointer">3</button>
                <span class="px-1 text-gray-400">...</span>
                <button class="w-8 h-8 flex items-center justify-center rounded-full border border-gray-200 text-gray-400 hover:bg-gray-50 transition cursor-pointer">&gt;</button>
            </div>
        </div>

    </div>

@endsection
