@extends('layouts.admin')

@section('title', 'Edit Penempatan')

@section('content')
    <script src="https://cdn.tailwindcss.com"></script>

    <div class="mb-6">
        <a href="{{ route('penempatan.index') }}" class="text-[#12395B] hover:underline font-medium text-[14px] flex items-center gap-1">
            &larr; Kembali ke Daftar Penempatan
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight mb-6">Ubah Data Penempatan</h2>

        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('penempatan.update', $penempatan->id) }}" method="POST" class="space-y-5">
            @csrf
            @method('PUT')

            <!-- Pilih Kandidat -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kandidat (Masyarakat) <span class="text-red-500">*</span></label>
                <select name="masyarakat_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-[#12395B] focus:border-[#12395B] text-[14px] text-gray-700 bg-gray-50" required>
                    @foreach($daftarMasyarakat as $orang)
                        <option value="{{ $orang->id }}" @selected(old('masyarakat_id', $penempatan->masyarakat_id) == $orang->id)>
                            {{ $orang->nik }} - {{ $orang->nama }}
                        </option>
                    @endforeach
                </select>
                @error('masyarakat_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <!-- Pilih Program -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Posisi / Program <span class="text-red-500">*</span></label>
                <select name="program_id" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-[#12395B] focus:border-[#12395B] text-[14px] text-gray-700 bg-gray-50" required>
                    @foreach($daftarProgram as $prog)
                        <option value="{{ $prog->id }}" @selected(old('program_id', $penempatan->program_id) == $prog->id)>
                            {{ $prog->nama }} ({{ $prog->mitra->nama ?? $prog->penyelenggara }})
                        </option>
                    @endforeach
                </select>
                @error('program_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-5">
                <!-- Tanggal Penempatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Penempatan</label>
                    <input type="date" name="tanggal_penempatan"
                           value="{{ old('tanggal_penempatan', $penempatan->tanggal_penempatan) }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-[#12395B] focus:border-[#12395B] text-[14px] text-gray-700 bg-gray-50">
                    @error('tanggal_penempatan') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <!-- Status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status Penempatan <span class="text-red-500">*</span></label>
                    <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-[#12395B] focus:border-[#12395B] text-[14px] text-gray-700 bg-gray-50" required>
                        <option value="Seleksi" @selected(old('status', $penempatan->status) == 'Seleksi')>Seleksi</option>
                        <option value="Diterima" @selected(old('status', $penempatan->status) == 'Diterima')>Diterima</option>
                        <option value="Bekerja" @selected(old('status', $penempatan->status) == 'Bekerja')>Bekerja</option>
                        <option value="Ditolak" @selected(old('status', $penempatan->status) == 'Ditolak')>Ditolak</option>
                    </select>
                    @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                <a href="{{ route('penempatan.index') }}" class="px-5 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg text-[14px] font-medium transition">Batal</a>
                <button type="submit" class="px-5 py-2 bg-[#12395B] hover:bg-[#0d2a43] text-white rounded-lg text-[14px] font-medium transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
@endsection
