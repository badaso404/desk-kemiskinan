<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data - Panel Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8fafc] text-gray-800 antialiased h-screen flex overflow-hidden">

    <!-- Konten Utama (Asumsi sidebar menggunakan layout / include, di sini saya fokus ke konten) -->
    <main class="flex-1 p-8 overflow-y-auto">
        <div class="mb-8">
            <a href="{{ route('penempatan.index') }}" class="inline-flex items-center gap-2 text-[14px] text-gray-500 hover:text-[#086b50] transition mb-3 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Data Penempatan
            </a>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Edit Data Kandidat</h2>
            <p class="text-gray-500 mt-2 text-[15px]">Perbarui informasi kandidat: {{ $penempatan->nama }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
            <!-- Arahkan Action ke Route Update dan gunakan method PUT -->
            <form action="{{ route('penempatan.update', $penempatan->id) }}" method="POST" class="p-8">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    <div class="col-span-1">
                        <label class="block text-[14px] font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $penempatan->nama) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50]">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[14px] font-semibold text-gray-700 mb-2">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $penempatan->nik) }}" required 
                        minlength="16" 
                        maxlength="16" 
                        pattern="\d{16}" 
                        title="Peringatan: NIK harus terdiri dari tepat 16 digit angka!"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50]">
                    
                    <div class="col-span-1 md:col-span-2 py-2"><hr class="border-gray-100"></div>

                    <div class="col-span-1">
                        <label class="block text-[14px] font-semibold text-gray-700 mb-2">Posisi</label>
                        <input type="text" name="posisi" value="{{ old('posisi', $penempatan->posisi) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50]">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[14px] font-semibold text-gray-700 mb-2">Pemberi Kerja</label>
                        <input type="text" name="pemberi_kerja" value="{{ old('pemberi_kerja', $penempatan->pemberi_kerja) }}" required class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50]">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[14px] font-semibold text-gray-700 mb-2">Tanggal Penempatan</label>
                        <input type="date" name="tanggal" value="{{ old('tanggal', $penempatan->tanggal_penempatan) }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50]">
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[14px] font-semibold text-gray-700 mb-2">Status Kerja</label>
                        <div class="relative">
                            <select name="status" required class="w-full appearance-none px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50] cursor-pointer">
                                <option value="Seleksi" {{ $penempatan->status == 'Seleksi' ? 'selected' : '' }}>Seleksi</option>
                                <option value="Diterima" {{ $penempatan->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Bekerja" {{ $penempatan->status == 'Bekerja' ? 'selected' : '' }}>Bekerja</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('penempatan.index') }}" class="px-6 py-2.5 rounded-full text-[14px] font-semibold text-gray-600 hover:bg-gray-100 transition">Batal</a>
                    <button type="submit" class="bg-[#086b50] hover:bg-[#06503c] text-white px-8 py-2.5 rounded-full font-semibold text-[14px] shadow-sm transition">
                        Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>