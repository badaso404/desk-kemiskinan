<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Penempatan - Panel Admin</title>
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Kustomisasi input date icon */
        input[type="date"]::-webkit-calendar-picker-indicator { cursor: pointer; opacity: 0.6; }
    </style>
</head>
<body class="bg-[#f8fafc] text-gray-800 antialiased h-screen flex overflow-hidden">

    <!-- ================= SIDEBAR ================= -->
    <aside class="w-[260px] bg-[#0A5C45] text-white flex flex-col justify-between flex-shrink-0">
        <div>
            <!-- Logo & Title -->
            <div class="px-6 py-8">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#21775E] rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                    </div> 
                    <h1 class="font-bold text-lg tracking-wide">Panel Admin</h1>
                </div>
                <p class="text-[13px] text-gray-300 ml-11 mt-1">Kota Jakarta Barat</p>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-2 px-4 space-y-1 text-[15px] font-medium">
                <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg text-gray-200 hover:bg-white/10 transition">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg text-gray-200 hover:bg-white/10 transition">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    Data Masyarakat
                </a>
                <!-- Active Menu: Penempatan -->
                <a href="/penempatan" class="flex items-center gap-3 py-3 px-4 rounded-lg bg-white/10 text-white border-l-4 border-transparent">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Penempatan
                </a>
                <a href="#" class="flex items-center gap-3 py-3 px-4 rounded-lg text-gray-200 hover:bg-white/10 transition">
                    <svg class="w-5 h-5 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                    Pengaturan
                </a>
            </nav>
        </div>
    </aside>

    <!-- ================= MAIN CONTENT ================= -->
    <main class="flex-1 p-8 overflow-y-auto">
        
        <!-- Header & Breadcrumb -->
        <div class="mb-8">
            <a href="/penempatan" class="inline-flex items-center gap-2 text-[14px] text-gray-500 hover:text-[#086b50] transition mb-3 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Data Penempatan
            </a>
            <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Tambah Data Baru</h2>
            <p class="text-gray-500 mt-2 text-[15px]">Masukkan informasi detail kandidat, posisi, dan status penempatan.</p>
        </div>

        <!-- Formulir Container -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
            
            {{-- Form dimulai (Tambahkan method POST dan action ke route simpan nantinya) --}}
            <form action="{{ route('penempatan.store') }}" method="POST" class="p-8">
                @csrf {{-- Token keamanan Laravel --}}
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                    
                    <!-- Nama Kandidat -->
                    <div class="col-span-1">
                        <label for="nama" class="block text-[14px] font-semibold text-gray-700 mb-2">Nama Lengkap Kandidat <span class="text-red-500">*</span></label>
                        <input type="text" id="nama" name="nama" placeholder="Contoh: Ahmad Santoso" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50] transition placeholder-gray-400">
                    </div>

                    <!-- NIK -->
                    <div class="col-span-1">
                        <label for="nik" class="block text-[14px] font-semibold text-gray-700 mb-2">Nomor Induk Kependudukan (NIK) <span class="text-red-500">*</span></label>
                        <input type="text" id="nik" name="nik" placeholder="16 Digit NIK" required 
                        minlength="16" 
                        maxlength="16" 
                        pattern="\d{16}" 
                        title="Peringatan: NIK harus terdiri dari tepat 16 digit angka!"
                        onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                        class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50] transition placeholder-gray-400">
                    </div>

                    <!-- Pemisah Garis -->
                    <div class="col-span-1 md:col-span-2 py-2">
                        <hr class="border-gray-100">
                    </div>

                    <!-- Posisi -->
                    <div class="col-span-1">
                        <label for="posisi" class="block text-[14px] font-semibold text-gray-700 mb-2">Posisi / Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" id="posisi" name="posisi" placeholder="Contoh: Teknisi Lapangan" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50] transition placeholder-gray-400">
                    </div>

                    <!-- Pemberi Kerja -->
                    <div class="col-span-1">
                        <label for="pemberi_kerja" class="block text-[14px] font-semibold text-gray-700 mb-2">Pemberi Kerja / Instansi <span class="text-red-500">*</span></label>
                        <input type="text" id="pemberi_kerja" name="pemberi_kerja" placeholder="Contoh: Dinas Bina Marga" required
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50] transition placeholder-gray-400">
                    </div>

                    <!-- Tanggal Penempatan -->
                    <div class="col-span-1">
                        <label for="tanggal" class="block text-[14px] font-semibold text-gray-700 mb-2">Tanggal Penempatan</label>
                        <input type="date" id="tanggal" name="tanggal" 
                            class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50] transition">
                        <p class="text-xs text-gray-400 mt-1.5">*Kosongkan jika status masih Seleksi</p>
                    </div>

                    <!-- Status -->
                    <div class="col-span-1">
                        <label for="status" class="block text-[14px] font-semibold text-gray-700 mb-2">Status Kerja <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <select id="status" name="status" required
                                class="w-full appearance-none px-4 py-3 rounded-xl border border-gray-200 bg-[#F8FAFC] text-[15px] text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#086b50]/20 focus:border-[#086b50] transition cursor-pointer">
                                <option value="" disabled selected>Pilih Status...</option>
                                <option value="Seleksi">Seleksi</option>
                                <option value="Diterima">Diterima</option>
                                <option value="Bekerja">Bekerja</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Action Buttons -->
                <div class="mt-10 flex items-center justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="/penempatan" class="px-6 py-2.5 rounded-full text-[14px] font-semibold text-gray-600 hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit" class="bg-[#086b50] hover:bg-[#06503c] text-white px-8 py-2.5 rounded-full font-semibold text-[14px] shadow-sm transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Data
                    </button>
                </div>
            </form>
            
        </div>
    </main>

</body>
</html>