<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kandidat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-[#f8fafc] text-gray-800 antialiased h-screen flex overflow-hidden">

    <main class="flex-1 p-8 overflow-y-auto">
        <div class="mb-8">
            <a href="{{ route('penempatan.index') }}" class="inline-flex items-center gap-2 text-[14px] text-gray-500 hover:text-[#086b50] transition mb-3 font-medium">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Data Penempatan
            </a>
            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Informasi Kandidat</h2>
                <a href="{{ route('penempatan.edit', $penempatan->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-2.5 rounded-full font-medium text-[14px] transition flex items-center gap-2">
                    Edit Data
                </a>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 max-w-3xl">
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Nama Lengkap</p>
                    <p class="text-lg font-semibold text-gray-900">{{ $penempatan->nama }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">NIK</p>
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
    </main>
</body>
</html>