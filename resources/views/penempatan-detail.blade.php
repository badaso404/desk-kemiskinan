@extends('layouts.admin')

@section('title', 'Detail Kandidat')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="mb-8">
        <a href="{{ route('penempatan.index') }}" class="inline-flex items-center gap-2 text-[14px] text-gray-500 hover:text-[#12395B] transition mb-3 font-medium">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Data Penempatan
        </a>
        <div class="flex justify-between items-center">
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Informasi Kandidat</h2>
            <a href="{{ route('penempatan.edit', $penempatan->id) }}" class="bg-blue-50 hover:bg-blue-100 text-[#12395B] px-5 py-2.5 rounded-full font-medium text-[14px] transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Data
            </a>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl">
        <div class="grid grid-cols-2 gap-y-8 gap-x-6">
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                <p class="text-lg font-semibold text-gray-900">{{ $penempatan->nama }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nomor Induk Kependudukan (NIK)</p>
                <p class="text-lg text-gray-700">{{ $penempatan->nik }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Posisi</p>
                <p class="text-lg text-gray-700">{{ $penempatan->posisi }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Pemberi Kerja</p>
                <p class="text-lg text-gray-700">{{ $penempatan->pemberi_kerja }}</p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Tanggal Penempatan</p>
                <p class="text-lg text-gray-700">
                    {{ $penempatan->tanggal_penempatan ? \Carbon\Carbon::parse($penempatan->tanggal_penempatan)->translatedFormat('d F Y') : '-' }}
                </p>
            </div>
            <div>
                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Status</p>
                @php
                    $badgeStyle = match($penempatan->status) {
                        'Bekerja'  => 'bg-[#D1FAE5] text-[#065F46]',
                        'Seleksi'  => 'bg-[#FEF08A] text-[#854D0E]',
                        'Diterima' => 'bg-[#DBEAFE] text-[#1E40AF]',
                        default    => 'bg-gray-100 text-gray-600',
                    };
                @endphp
                <span class="{{ $badgeStyle }} py-1.5 px-4 rounded-full text-[13px] font-semibold inline-block">
                    {{ $penempatan->status }}
                </span>
            </div>
        </div>
    </div>
@endsection
