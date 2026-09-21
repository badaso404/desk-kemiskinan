@extends('layouts.admin')

@section('title', 'Detail Penempatan')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="mb-6">
        <a href="{{ route('penempatan.index') }}" class="text-[#12395B] hover:underline font-medium text-[14px] flex items-center gap-1">
            &larr; Kembali ke Daftar Penempatan
        </a>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Detail Penempatan</h2>

        @php
            $badgeStyle = match($penempatan->status) {
                'Bekerja'  => 'bg-[#D1FAE5] text-[#065F46]',
                'Seleksi'  => 'bg-[#FEF08A] text-[#854D0E]',
                'Diterima' => 'bg-[#DBEAFE] text-[#1E40AF]',
                'Ditolak'  => 'bg-[#FEE2E2] text-[#991B1B]',
                default    => 'bg-gray-100 text-gray-600',
            };
        @endphp
        <span class="{{ $badgeStyle }} py-1.5 px-5 rounded-full text-[14px] font-bold">
            Status: {{ $penempatan->status }}
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kartu Data Kandidat -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Kandidat</h3>
            <div class="space-y-3 text-[14px]">
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Nama Lengkap</span> <span class="font-medium text-gray-900">{{ $penempatan->masyarakat->nama ?? '-' }}</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">NIK</span> <span class="font-medium text-gray-900">{{ $penempatan->masyarakat->nik ?? '-' }}</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Jenis Kelamin</span> <span class="font-medium text-gray-900">{{ $penempatan->masyarakat->jenis_kelamin ?? '-' }}</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Telepon</span> <span class="font-medium text-gray-900">{{ $penempatan->masyarakat->telepon ?? '-' }}</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Pendidikan</span> <span class="font-medium text-gray-900">{{ $penempatan->masyarakat->pendidikan_terakhir ?? '-' }}</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Domisili</span> <span class="font-medium text-gray-900">{{ $penempatan->masyarakat->kecamatan ?? '-' }}, {{ $penempatan->masyarakat->kelurahan ?? '-' }}</span></div>
            </div>
        </div>

        <!-- Kartu Data Program/Pekerjaan -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Informasi Program / Pekerjaan</h3>
            <div class="space-y-3 text-[14px]">
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Posisi / Program</span> <span class="font-medium text-gray-900">{{ $penempatan->program->nama ?? '-' }}</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Kategori</span> <span class="font-medium text-gray-900">{{ $penempatan->program->kategori ?? '-' }} ({{ $penempatan->program->jenis ?? '-' }})</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Pemberi Kerja / Mitra</span> <span class="font-medium text-gray-900">{{ $penempatan->program->mitra->nama ?? $penempatan->program->penyelenggara ?? '-' }}</span></div>
                <div><span class="text-gray-500 block text-xs uppercase tracking-wider">Lokasi</span> <span class="font-medium text-gray-900">{{ $penempatan->program->lokasi ?? '-' }}</span></div>
                <div>
                    <span class="text-gray-500 block text-xs uppercase tracking-wider">Tanggal Penempatan</span>
                    <span class="font-medium text-gray-900">
                        {{ $penempatan->tanggal_penempatan ? \Carbon\Carbon::parse($penempatan->tanggal_penempatan)->translatedFormat('d F Y') : 'Belum ditentukan' }}
                    </span>
                </div>
            </div>
        </div>
    </div>
@endsection
