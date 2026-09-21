@extends('layouts.admin')

@section('title', 'Monitoring & Laporan Pemberdayaan')

@section('content')
<style>
    :root {
        --primary: #12395B;
        --primary-light: #ebf3fa;
        --text-dark: #0f172a;
        --text-muted: #64748b;
    }

    .monitoring-wrapper {
        width: 100%;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .monitoring-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-bottom: 1.75rem;
    }

    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .header-icon-box {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        background-color: var(--primary);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 4px 12px rgba(18, 57, 91, 0.25);
    }

    .header-text h1 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 0.2rem 0;
    }

    .header-text p {
        font-size: 0.875rem;
        color: var(--text-muted);
        margin: 0;
    }

    .btn-download-pdf {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background-color: #dc2626;
        color: #ffffff;
        font-weight: 600;
        font-size: 0.875rem;
        padding: 0.625rem 1.25rem;
        border-radius: 10px;
        text-decoration: none;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
        transition: all 0.2s ease;
    }

    .btn-download-pdf:hover {
        background-color: #b91c1c;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.35);
        transform: translateY(-1px);
    }

    /* TOP STATS GRID */
    .stat-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.75rem;
    }

    .stat-card-item {
        background: #ffffff;
        border-radius: 14px;
        padding: 1.25rem 1.5rem;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .stat-card-label {
        font-size: 0.8rem;
        font-weight: 600;
        color: #94a3b8;
        margin-bottom: 0.5rem;
        display: block;
    }

    .stat-card-value {
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-dark);
        line-height: 1;
    }

    .stat-card-value.green { color: #16a34a; }
    .stat-card-value.amber { color: #d97706; }
    .stat-card-value.blue { color: #12395B; }

    /* MAIN GRID */
    .monitoring-main-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.75rem;
    }

    .card-panel {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        padding: 1.5rem;
        margin-bottom: 1.75rem;
    }

    .panel-head {
        margin-bottom: 1.5rem;
    }

    .panel-head h2 {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0 0 0.25rem 0;
    }

    .panel-head p {
        font-size: 0.8rem;
        color: var(--text-muted);
        margin: 0;
    }

    /* PROGRESS BAR STATUS PEKERJAAN */
    .status-list {
        display: flex;
        flex-direction: column;
        gap: 0.85rem;
    }

    .status-row {
        display: grid;
        grid-template-columns: 160px 1fr 40px 50px;
        align-items: center;
        gap: 0.75rem;
    }

    .status-badge-pill {
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        text-align: center;
        background: var(--primary-light);
        color: var(--primary);
    }

    .progress-track {
        width: 100%;
        height: 8px;
        background-color: #f1f5f9;
        border-radius: 9999px;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        border-radius: 9999px;
        background-color: var(--primary);
        transition: width 0.4s ease;
    }

    .status-count {
        font-size: 0.875rem;
        font-weight: 700;
        color: var(--text-dark);
        text-align: right;
    }

    .status-pct {
        font-size: 0.775rem;
        font-weight: 600;
        color: #64748b;
        text-align: right;
    }

    /* REKAP KECAMATAN LIST */
    .kecamatan-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .kecamatan-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 0.6rem;
        border-bottom: 1px dashed #f1f5f9;
    }

    .kecamatan-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .kecamatan-info {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 0.9rem;
        font-weight: 600;
        color: #334155;
    }

    .kecamatan-stats {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-size: 0.875rem;
    }

    .stat-aktif-text {
        color: #d97706;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .stat-total-text {
        color: var(--text-dark);
        font-weight: 700;
        min-width: 20px;
        text-align: right;
    }

    .stat-pct-badge {
        font-size: 0.75rem;
        font-weight: 700;
        background: #f1f5f9;
        color: #475569;
        padding: 2px 8px;
        border-radius: 6px;
    }

    /* RECENT UPDATES */
    .recent-list {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .recent-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.85rem 1rem;
        background-color: #fafafa;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .recent-user-title {
        font-size: 0.9rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.2rem;
    }

    .recent-user-time {
        font-size: 0.775rem;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 0.35rem;
    }

    .badge-status-penempatan {
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    @media (max-width: 1024px) {
        .stat-grid-4 { grid-template-columns: repeat(2, 1fr); }
        .monitoring-main-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .stat-grid-4 { grid-template-columns: 1fr; }
        .status-row { grid-template-columns: 110px 1fr 30px 40px; }
    }
</style>

<div class="monitoring-wrapper">

    <!-- HEADER + TOMBOL DOWNLOAD PDF -->
    <div class="monitoring-header">
        <div class="header-left">
            <div class="header-icon-box">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div class="header-text">
                <h1>Monitoring &amp; Laporan Program</h1>
                <p>Pemantauan status masyarakat, rekap data wilayah, dan ekspor laporan</p>
            </div>
        </div>

        <a href="{{ route('admin.monitoring.download-pdf') }}" class="btn-download-pdf" target="_blank">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Download PDF Full</span>
        </a>
    </div>

    <!-- 4 RINGKASAN CARDS DINAMIS -->
    <section class="stat-grid-4">
        <div class="stat-card-item">
            <span class="stat-card-label">Total Masyarakat</span>
            <div class="stat-card-value">{{ number_format($totalMasyarakat) }}</div>
        </div>

        <div class="stat-card-item">
            <span class="stat-card-label">Membutuhkan Pekerjaan</span>
            <div class="stat-card-value amber">{{ number_format($butuhPekerjaan) }}</div>
        </div>

        <div class="stat-card-item">
            <span class="stat-card-label">Tingkat Penempatan</span>
            <div class="stat-card-value green">{{ $tingkatPenempatan }}%</div>
            <small style="font-size: 0.75rem; color: #64748b; display: block; margin-top: 6px;">
                {{ number_format($masyarakatDitempatkan) }} dari {{ number_format($totalMasyarakat) }} warga
            </small>
        </div>

        <div class="stat-card-item">
            <span class="stat-card-label">Total Penempatan</span>
            <div class="stat-card-value blue">{{ number_format($totalPenempatan) }}</div>
        </div>
    </section>

    <!-- MAIN GRID DINAMIS -->
    <div class="monitoring-main-grid">

        <!-- KIRI: DISTRIBUSI STATUS PEKERJAAN (ADA PERSENTASE) -->
        <article class="card-panel" style="margin-bottom: 0;">
            <div class="panel-head">
                <h2>Distribusi Status Pekerjaan</h2>
                <p>Jumlah &amp; persentase warga berdasarkan kategori pekerjaan</p>
            </div>

            <div class="status-list">
                @forelse ($distribusiPekerjaan as $row)
                    @php 
                        $pctFill = round(($row->total / $maxCount) * 100);
                        if ($row->total > 0 && $pctFill < 6) $pctFill = 6;

                        // Persentase Asli
                        $pctReal = $totalMasyarakat > 0 ? round(($row->total / $totalMasyarakat) * 100, 1) : 0;
                    @endphp
                    <div class="status-row">
                        <div>
                            <span class="status-badge-pill" title="{{ $row->status_pekerjaan }}">
                                {{ $row->status_pekerjaan }}
                            </span>
                        </div>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: {{ $pctFill }}%;"></div>
                        </div>
                        <div class="status-count">{{ $row->total }}</div>
                        <div class="status-pct">{{ $pctReal }}%</div>
                    </div>
                @empty
                    <p style="text-align: center; color: #94a3b8; padding: 1.5rem 0;">Belum ada data status pekerjaan.</p>
                @endforelse
            </div>
        </article>

        <!-- KANAN: REKAPITULASI KECAMATAN (ADA PERSENTASE) -->
        <article class="card-panel" style="margin-bottom: 0;">
            <div class="panel-head">
                <h2>Kasus per Kecamatan</h2>
                <p>Total warga &amp; persentase warga yang butuh kerja per wilayah</p>
            </div>

            <div class="kecamatan-list">
                @forelse ($rekapKecamatan as $kec)
                    @php
                        $rasioKec = $kec->total_warga > 0 ? round(($kec->butuh_kerja / $kec->total_warga) * 100, 1) : 0;
                    @endphp
                    <div class="kecamatan-item">
                        <div class="kecamatan-info">
                            <svg width="16" height="16" fill="none" stroke="#12395B" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <circle cx="12" cy="11" r="3"/>
                            </svg>
                            <span>{{ $kec->kecamatan }}</span>
                        </div>
                        <div class="kecamatan-stats">
                            <span class="stat-aktif-text">{{ $kec->butuh_kerja }} butuh kerja</span>
                            <span class="stat-total-text">{{ $kec->total_warga }} total</span>
                            <span class="stat-pct-badge">{{ $rasioKec }}%</span>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #94a3b8; padding: 1.5rem 0;">Belum ada data kecamatan terdaftar.</p>
                @endforelse
            </div>
        </article>
        <!-- REKAPITULASI KUOTA PROGRAM PEMBERDAYAAN (UKPD & CSR) -->
        <article class="card-panel">
            <div class="panel-head">
                <h2>Rekapitulasi Kuota &amp; Serapan Program (UKPD / CSR)</h2>
                <p>Monitoring kapasitas kuota, jumlah warga yang masuk, dan sisa kuota per program</p>
            </div>

            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem;">
                    <thead>
                        <tr style="background: #f8fafc; color: #475569; text-transform: uppercase; font-size: 0.75rem; border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 10px; text-align: center; width: 40px;">No</th>
                            <th style="padding: 10px; text-align: left;">Nama Program Pemberdayaan</th>
                            <th style="padding: 10px; text-align: left;">Penyelenggara</th>
                            <th style="padding: 10px; text-align: center;">Kategori</th>
                            <th style="padding: 10px; text-align: center;">Kuota Total</th>
                            <th style="padding: 10px; text-align: center;">Warga Masuk</th>
                            <th style="padding: 10px; text-align: center;">Sisa Kuota</th>
                            <th style="padding: 10px; text-align: center;">Persentase Serapan</th>
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
                            <tr style="border-bottom: 1px dashed #f1f5f9;">
                                <td style="padding: 10px; text-align: center; font-weight: 700;">{{ $index + 1 }}</td>
                                <td style="padding: 10px; font-weight: 700; color: #12395B;">{{ $prog->nama_program ?? $prog->nama }}</td>
                                <td style="padding: 10px;">{{ $prog->mitra?->nama_mitra ?? $prog->mitra?->nama ?? '-' }}</td>
                                <td style="padding: 10px; text-align: center;">
                                    @if($isCsr)
                                        <span style="background: #dbeafe; color: #1e40af; font-weight: 700; font-size: 0.7rem; padding: 3px 8px; border-radius: 6px;">CSR</span>
                                    @else
                                        <span style="background: #dcfce7; color: #166534; font-weight: 700; font-size: 0.7rem; padding: 3px 8px; border-radius: 6px;">UKPD</span>
                                    @endif
                                </td>
                                <td style="padding: 10px; text-align: center; font-weight: 700;">{{ number_format($kuota) }}</td>
                                <td style="padding: 10px; text-align: center; font-weight: 700; color: #12395B;">{{ number_format($masuk) }}</td>
                                <td style="padding: 10px; text-align: center; font-weight: 700; color: {{ $sisa > 0 ? '#d97706' : '#dc2626' }};">
                                    {{ number_format($sisa) }}
                                </td>
                                <td style="padding: 10px; text-align: center;">
                                    <span style="font-weight: 700; color: {{ $serapan >= 100 ? '#dc2626' : '#16a34a' }};">
                                        {{ $serapan }}%
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="text-align: center; color: #94a3b8; padding: 1.5rem 0;">Belum ada data program pemberdayaan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>
            </div>

    <!-- PANEL BAWAH: SELURUH PEMBARUAN PENEMPATAN -->
    <article class="card-panel">
        <div class="panel-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
            <div>
                <h2>Pembaruan Penempatan</h2>
                <p>Riwayat seluruh perubahan status penempatan warga ke program pemberdayaan</p>
            </div>
            <span style="font-size: 0.8rem; font-weight: 700; background: #ebf3fa; color: #12395B; padding: 4px 12px; border-radius: 9999px;">
                Total: {{ number_format($penempatanTerbaru->count()) }} Data
            </span>
        </div>

        <!-- KONTAINER SCROLLABLE -->
        <div class="recent-list" style="max-height: 440px; overflow-y: auto; padding-right: 4px;">
            @forelse ($penempatanTerbaru as $p)
                <div class="recent-item">
                    <div>
                        <div class="recent-user-title">
                            {{ $p->masyarakat?->nama ?? 'Warga' }} 
                            <span style="font-weight: 400; color: #64748b;">(NIK: {{ $p->masyarakat?->nik ?? '-' }})</span>
                            @if($p->program)
                                &middot; <span style="color: #12395B; font-weight: 600;">{{ $p->program->nama }}</span>
                            @endif
                        </div>
                        <div class="recent-user-time">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 3"/>
                            </svg>
                            <span>Diperbarui: {{ $p->updated_at ? $p->updated_at->format('d M Y, H.i') : '-' }} WIB</span>
                        </div>
                    </div>
                    <div>
                        @php
                            $badgeStyle = match($p->status) {
                                'Bekerja'  => 'background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0;',
                                'Diterima' => 'background: #dbeafe; color: #1e40af; border: 1px solid #bfdbfe;',
                                'Seleksi'  => 'background: #fef08a; color: #854d0e; border: 1px solid #fde047;',
                                'Ditolak'  => 'background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;',
                                default    => 'background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;',
                            };
                        @endphp
                        <span class="badge-status-penempatan" style="{{ $badgeStyle }}">
                            Status: {{ $p->status }}
                        </span>
                    </div>
                </div>
            @empty
                <p style="text-align: center; color: #94a3b8; padding: 2rem 0;">Belum ada riwayat penempatan program yang tersimpan.</p>
            @endforelse
        </div>
    </article>

</div>
@endsection