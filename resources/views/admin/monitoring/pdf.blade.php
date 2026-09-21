<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Monitoring Program Pemberdayaan</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; color: #1e293b; line-height: 1.4; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #12395B; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #12395B; font-size: 15px; text-transform: uppercase; }
        .header p { margin: 3px 0 0 0; color: #64748b; font-size: 9px; }
        
        .stat-grid { width: 100%; margin-bottom: 15px; border-collapse: collapse; }
        .stat-card { background: #f8fafc; border: 1px solid #cbd5e1; padding: 8px; text-align: center; }
        .stat-label { font-size: 8px; color: #64748b; font-weight: bold; text-transform: uppercase; }
        .stat-value { font-size: 14px; font-weight: bold; color: #0f172a; margin-top: 3px; }
        
        .section-title { font-size: 11px; font-weight: bold; color: #12395B; margin-top: 15px; margin-bottom: 6px; border-left: 3px solid #12395B; padding-left: 6px; text-transform: uppercase; }
        
        .table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .table th, .table td { border: 1px solid #cbd5e1; padding: 5px 7px; text-align: left; }
        .table th { background-color: #f1f5f9; color: #334155; font-weight: bold; font-size: 8.5px; text-transform: uppercase; }
        .table-striped tbody tr:nth-of-type(odd) { background-color: #f8fafc; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h2>Laporan Monitoring & Pemberdayaan Masyarakat</h2>
        <p>Tanggal Cetak: {{ date('d F Y, H:i') }} WIB | Oleh: Administrator</p>
    </div>

    <!-- 1. SUMMARY CARDS -->
    <table class="stat-grid">
        <tr>
            <td class="stat-card">
                <div class="stat-label">Total Masyarakat</div>
                <div class="stat-value">{{ number_format($totalMasyarakat) }}</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Membutuhkan Kerja</div>
                <div class="stat-value" style="color: #d97706;">{{ number_format($butuhPekerjaan) }}</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Tingkat Penempatan</div>
                <div class="stat-value" style="color: #16a34a;">{{ $tingkatPenempatan }}%</div>
            </td>
            <td class="stat-card">
                <div class="stat-label">Total Penempatan</div>
                <div class="stat-value" style="color: #12395B;">{{ number_format($totalPenempatan) }}</div>
            </td>
        </tr>
    </table>

    <!-- 2. DISTRIBUSI PEKERJAAN (PERSENTASE SAMA DEGAN UI) -->
    <div class="section-title">1. Pemetaan Kondisi Pekerjaan Warga</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th>Status Pekerjaan Saat Ini</th>
                <th style="width: 25%;" class="text-center">Jumlah Warga</th>
                <th style="width: 20%;" class="text-center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distribusiPekerjaan as $index => $row)
                @php
                    $pct = $totalMasyarakat > 0 ? round(($row->total / $totalMasyarakat) * 100, 1) : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $row->status_pekerjaan }}</strong></td>
                    <td class="text-center">{{ number_format($row->total) }} Orang</td>
                    <td class="text-center"><strong>{{ $pct }}%</strong></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- 3. KECAMATAN REKAPITULASI (PERSENTASE SAMA DENGAN UI) -->
    <div class="section-title">2. Rekapitulasi Data Wilayah (Kecamatan)</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th>Kecamatan</th>
                <th style="width: 25%;" class="text-center">Warga Membutuhkan Kerja</th>
                <th style="width: 25%;" class="text-center">Total Warga Terdaftar</th>
                <th style="width: 20%;" class="text-center">Rasio Kebutuhan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekapKecamatan as $index => $kec)
                @php
                    $rasio = $kec->total_warga > 0 ? round(($kec->butuh_kerja / $kec->total_warga) * 100, 1) : 0;
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $kec->kecamatan }}</strong></td>
                    <td class="text-center" style="color: #d97706; font-weight: bold;">{{ number_format($kec->butuh_kerja) }} Warga</td>
                    <td class="text-center">{{ number_format($kec->total_warga) }} Warga</td>
                    <td class="text-center"><strong>{{ $rasio }}%</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Data kecamatan belum tersedia.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- 4. PEMBARUAN PENEMPATAN -->
    <div class="section-title">3. Riwayat Penempatan Program</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 5%;" class="text-center">No</th>
                <th>Nama Warga</th>
                <th>NIK</th>
                <th>Program Pemberdayaan</th>
                <th style="width: 15%;" class="text-center">Status</th>
                <th style="width: 20%;">Tanggal Update</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($penempatanTerbaru as $index => $p)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $p->masyarakat?->nama ?? '-' }}</strong></td>
                    <td>{{ $p->masyarakat?->nik ?? '-' }}</td>
                    <td>{{ $p->program?->nama ?? '-' }}</td>
                    <td class="text-center"><strong>{{ $p->status }}</strong></td>
                    <td>{{ $p->updated_at ? $p->updated_at->format('d/m/Y H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada riwayat penempatan program.</td>
                </tr>
            @endforelse
    <!-- REKAPITULASI PROGRAM & KUOTA (UKPD / CSR) -->
    <div class="section-title">Rekapitulasi Kuota & Serapan Program (UKPD / CSR)</div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th style="width: 4%;" class="text-center">No</th>
                <th>Program Pemberdayaan</th>
                <th>Mitra Penyelenggara</th>
                <th style="width: 10%;" class="text-center">Kategori</th>
                <th style="width: 12%;" class="text-center">Kuota Total</th>
                <th style="width: 12%;" class="text-center">Warga Masuk</th>
                <th style="width: 12%;" class="text-center">Sisa Kuota</th>
                <th style="width: 14%;" class="text-center">Serapan (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($rekapProgram as $index => $prog)
                @php
                    $kuota = $prog->kuota ?? $prog->kapasitas ?? 0;
                    $masuk = $prog->total_masuk ?? 0;
                    $sisa = max(0, $kuota - $masuk);
                    $serapan = $kuota > 0 ? round(($masuk / $kuota) * 100, 1) : 0;
                    $isCsr = strtoupper($prog->mitra?->kategori ?? '') === 'CSR';
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td><strong>{{ $prog->nama_program ?? $prog->nama }}</strong></td>
                    <td>{{ $prog->mitra?->nama_mitra ?? $prog->mitra?->nama ?? '-' }}</td>
                    <td class="text-center"><strong>{{ $isCsr ? 'CSR' : 'UKPD' }}</strong></td>
                    <td class="text-center">{{ number_format($kuota) }}</td>
                    <td class="text-center" style="color: #12395B; font-weight: bold;">{{ number_format($masuk) }}</td>
                    <td class="text-center" style="color: #d97706;">{{ number_format($sisa) }}</td>
                    <td class="text-center"><strong>{{ $serapan }}%</strong></td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Belum ada data program pemberdayaan.</td>
                </tr>
            @endforelse
        </tbody>
</table>

</body>
</html>