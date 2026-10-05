@extends('layouts.admin')

@section('title', 'Monitoring & Laporan Pemberdayaan')

@section('content')
<style>
    :root {
        --neutral:      #f8fafc;
        --surface:      #ffffff;
        --brand:        #12395B;
        --brand-soft:   #eef4f9;
        --accent:       #dc2626;
        --text:         #0f172a;
        --text-mute:    #64748b;
        --line:         #e5e7eb;
        --line-soft:    #f1f5f9;

        /* Semantic */
        --success:      #16a34a;
        --success-soft: #dcfce7;
        --warning:      #d97706;
        --warning-soft: #fef3c7;
        --danger:       #dc2626;
        --danger-soft:  #fee2e2;
    }

    .monitoring-wrapper {
        display: flex;
        flex-direction: column;
        gap: 1.25rem;
        color: var(--text);
    }

    /* ================= HEADER ================= */
    .monitoring-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid var(--line);
    }
    .header-text h1 {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--brand);
        margin: 0 0 .3rem 0;
        letter-spacing: -.015em;
    }
    .header-text p {
        font-size: .85rem;
        color: var(--text-mute);
        margin: 0;
        line-height: 1.4;
    }
    .btn-download-pdf {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        background: var(--accent);
        color: #fff;
        font-weight: 600;
        font-size: .85rem;
        padding: .6rem 1.15rem;
        border-radius: 6px;
        text-decoration: none;
        transition: background .15s ease;
    }
    .btn-download-pdf:hover { background: #b91c1c; color: #fff; }
    .btn-download-pdf:focus-visible { outline: 2px solid var(--brand); outline-offset: 2px; }

    /* ================= STAT ================= */
    .stat-layout {
        display: grid;
        grid-template-columns: minmax(220px, 1fr) 2fr;
        gap: 1rem;
        align-items: stretch;
    }
    .stat-hero {
        background: var(--brand);
        color: #fff;
        border-radius: 10px;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        min-height: 168px;
    }
    .stat-hero-label {
        font-size: .72rem;
        font-weight: 600;
        letter-spacing: .1em;
        text-transform: uppercase;
        color: rgba(255,255,255,.7);
        margin: 0;
    }
    .stat-hero-value {
        font-size: 3.25rem;
        font-weight: 700;
        line-height: 1;
        letter-spacing: -.03em;
        color: #fff;
        margin: .75rem 0;
        font-variant-numeric: tabular-nums;
    }
    .stat-hero-foot {
        font-size: .78rem;
        color: rgba(255,255,255,.65);
        margin: 0;
        line-height: 1.4;
    }
    .stat-rows {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }
    .stat-row-item {
        display: grid;
        grid-template-columns: 1fr auto;
        align-items: center;
        gap: 1.5rem;
        padding: 1.05rem 1.5rem;
        border-bottom: 1px solid var(--line-soft);
        flex: 1;
    }
    .stat-row-item:last-child { border-bottom: none; }
    .stat-row-left {
        display: flex;
        align-items: center;
        gap: .65rem;
        min-width: 0;
    }
    .stat-row-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: var(--brand);
        flex-shrink: 0;
        opacity: .55;
    }
    .stat-row-dot.is-soft { opacity: .25; }
    .stat-row-label {
        font-size: .85rem;
        font-weight: 500;
        color: var(--text-mute);
        margin: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .stat-row-right {
        display: flex;
        align-items: baseline;
        gap: .75rem;
        justify-content: flex-end;
        min-width: 0;
    }
    .stat-row-value {
        font-size: 1.4rem;
        font-weight: 700;
        color: var(--text);
        line-height: 1;
        font-variant-numeric: tabular-nums;
        letter-spacing: -.01em;
    }
    .stat-row-value.brand { color: var(--brand); }
    .stat-row-note {
        font-size: .72rem;
        color: var(--text-mute);
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }
    .stat-row-progress {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: .4rem;
        min-width: 140px;
    }
    .stat-row-progress .stat-row-right { width: 100%; }
    .mini-track {
        width: 100%;
        height: 4px;
        background: var(--line-soft);
        border-radius: 2px;
        overflow: hidden;
    }
    .mini-fill {
        height: 100%;
        background: var(--brand);
        border-radius: 2px;
    }

    /* ================= PANEL ================= */
    .card-panel {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 10px;
        padding: 1.25rem 1.5rem;
        min-width: 0;
        display: flex;
        flex-direction: column;
    }
    .panel-head {
        margin-bottom: 1.1rem;
        padding-bottom: .9rem;
        border-bottom: 1px solid var(--line-soft);
    }
    .panel-head-flex {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        flex-wrap: wrap;
        gap: .75rem;
    }
    .panel-head h2 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--brand);
        margin: 0 0 .25rem 0;
        letter-spacing: -.005em;
    }
    .panel-head p {
        font-size: .78rem;
        color: var(--text-mute);
        margin: 0;
        line-height: 1.4;
    }
    .panel-head-meta {
        display: flex;
        align-items: center;
        gap: .5rem;
        flex-wrap: wrap;
    }
    .count-pill {
        font-size: .72rem;
        font-weight: 600;
        background: var(--brand-soft);
        color: var(--brand);
        padding: 4px 10px;
        border-radius: 4px;
        white-space: nowrap;
        font-variant-numeric: tabular-nums;
    }
    .count-pill.tone-neutral {
        background: var(--neutral);
        color: var(--text-mute);
    }

    /* Panel footer (ringkasan di dasar panel) */
    .panel-foot {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
        padding-top: .9rem;
        border-top: 1px solid var(--line-soft);
        font-size: .78rem;
    }
    .panel-foot-label {
        color: var(--text-mute);
        font-weight: 500;
    }
    .panel-foot-value {
        color: var(--text);
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }

    /* ================= MAIN GRID ================= */
    .monitoring-main-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.25rem;
        align-items: stretch;
    }
    .grid-span-2 { grid-column: 1 / -1; }

    /* ================= STATUS LIST ================= */
    .status-list {
        display: flex;
        flex-direction: column;
        gap: .85rem;
        flex: 1;
        overflow-y: auto;
        padding-right: 6px;
    }
    .status-row {
        display: grid;
        grid-template-columns: minmax(110px, 150px) 1fr minmax(70px, auto);
        align-items: center;
        gap: .85rem;
    }
    .status-badge-pill {
        display: inline-block;
        width: 100%;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-align: center;
        background: var(--brand-soft);
        color: var(--brand);
    }
    .status-badge-pill.tone-success { background: var(--success-soft); color: #166534; }
    .status-badge-pill.tone-warning { background: var(--warning-soft); color: #854d0e; }
    .status-badge-pill.tone-danger  { background: var(--danger-soft);  color: #991b1b; }
    .status-badge-pill.tone-neutral { background: var(--brand-soft);   color: var(--brand); }

    .progress-track {
        width: 100%;
        height: 6px;
        background: var(--line-soft);
        border-radius: 3px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: var(--brand);
        border-radius: 3px;
        transition: width .4s ease;
    }
    .progress-fill.tone-success { background: var(--success); }
    .progress-fill.tone-warning { background: var(--warning); }
    .progress-fill.tone-danger  { background: var(--danger); }

    .status-meta {
        display: flex;
        align-items: baseline;
        justify-content: flex-end;
        gap: .35rem;
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
    }
    .status-meta-count {
        font-size: .9rem;
        font-weight: 700;
        color: var(--text);
    }
    .status-meta-sep {
        font-size: .7rem;
        color: var(--line);
    }
    .status-meta-pct {
        font-size: .72rem;
        font-weight: 600;
        color: var(--text-mute);
    }

    /* ================= KECAMATAN LIST ================= */
    .kecamatan-list {
        display: flex;
        flex-direction: column;
        flex: 1;
        overflow-y: auto;
        padding-right: 6px;
    }
    .kecamatan-item {
        display: flex;
        flex-direction: column;
        gap: .5rem;
        padding: .8rem 0;
        border-bottom: 1px solid var(--line-soft);
    }
    .kecamatan-item:last-child { border-bottom: none; }

    .kecamatan-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: .75rem;
    }
    .kecamatan-name {
        font-size: .85rem;
        font-weight: 600;
        color: var(--text);
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        min-width: 0;
    }
    .kecamatan-meta {
        font-size: .72rem;
        color: var(--text-mute);
        font-variant-numeric: tabular-nums;
        white-space: nowrap;
        flex-shrink: 0;
    }
    .kecamatan-meta strong {
        color: var(--text);
        font-weight: 700;
    }
    .kecamatan-meta .pct-badge {
        display: inline-block;
        margin-left: .35rem;
        padding: 2px 7px;
        border-radius: 4px;
        font-weight: 700;
        font-size: .7rem;
        background: var(--neutral);
        color: var(--text-mute);
    }
    .kecamatan-meta .pct-badge.tone-success { background: var(--success-soft); color: #166534; }
    .kecamatan-meta .pct-badge.tone-warning { background: var(--warning-soft); color: #854d0e; }
    .kecamatan-meta .pct-badge.tone-danger  { background: var(--danger-soft);  color: #991b1b; }

    .kecamatan-bar {
        height: 4px;
        background: var(--line-soft);
        border-radius: 2px;
        overflow: hidden;
    }
    .kecamatan-bar-fill {
        height: 100%;
        border-radius: 2px;
        background: var(--brand);
        transition: width .4s ease;
    }
    .kecamatan-bar-fill.tone-success { background: var(--success); }
    .kecamatan-bar-fill.tone-warning { background: var(--warning); }
    .kecamatan-bar-fill.tone-danger  { background: var(--danger); }

    /* ================= RECENT / TIMELINE ================= */
    .recent-list {
        display: flex;
        flex-direction: column;
        gap: .55rem;
        flex: 1;
        overflow-y: auto;
        padding-right: 6px;
    }
    .recent-item {
        display: grid;
        grid-template-columns: 10px 1fr auto;
        align-items: center;
        gap: 1rem;
        padding: .9rem 1.1rem;
        background: var(--neutral);
        border-radius: 8px;
        transition: background .15s ease, transform .15s ease;
    }
    .recent-item:hover {
        background: var(--brand-soft);
        transform: translateX(2px);
    }
    .recent-item-marker {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: var(--brand);
        box-shadow: 0 0 0 3px var(--surface);
        flex-shrink: 0;
    }
    .recent-item-marker.tone-success { background: var(--success); }
    .recent-item-marker.tone-warning { background: var(--warning); }
    .recent-item-marker.tone-danger  { background: var(--danger); }
    .recent-item-marker.tone-neutral { background: var(--text-mute); }
    .recent-item-marker.tone-info    { background: #2563eb; }

    .recent-item-content { min-width: 0; }
    .recent-user-title {
        font-size: .85rem;
        font-weight: 600;
        color: var(--text);
        margin-bottom: .25rem;
        line-height: 1.4;
    }
    .recent-user-title .muted { font-weight: 400; color: var(--text-mute); }
    .recent-user-title .program-name { color: var(--brand); font-weight: 500; }
    .recent-user-time {
        font-size: .75rem;
        color: var(--text-mute);
        display: flex;
        align-items: center;
        gap: .35rem;
    }

    .badge-status-penempatan {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 4px;
        font-size: .72rem;
        font-weight: 600;
        white-space: nowrap;
    }
    .badge-status-penempatan.tone-success { background: var(--success-soft); color: #166534; }
    .badge-status-penempatan.tone-info    { background: #dbeafe; color: #1e40af; }
    .badge-status-penempatan.tone-warning { background: var(--warning-soft); color: #854d0e; }
    .badge-status-penempatan.tone-danger  { background: var(--danger-soft);  color: #991b1b; }
    .badge-status-penempatan.tone-neutral { background: var(--line-soft);    color: #475569; }

    /* ================= EMPTY ================= */
    .empty-state {
        text-align: center;
        padding: 2rem 1rem;
        color: var(--text-mute);
        font-size: .85rem;
    }
    .empty-state p { margin: 0; }

    /* ================= TABLE ================= */
    .table-wrapper {
        overflow-x: auto;
        border: 1px solid var(--line);
        border-radius: 8px;
    }
    .rekap-table {
        width: 100%;
        border-collapse: collapse;
        font-size: .85rem;
        min-width: 800px;
    }
    .rekap-table thead th {
        background: var(--neutral);
        color: var(--text);
        text-transform: uppercase;
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .05em;
        padding: 12px;
        border-bottom: 1px solid var(--line);
        text-align: center;
        white-space: nowrap;
    }
    .rekap-table thead th.text-left { text-align: left; }
    .rekap-table tbody td {
        padding: 12px;
        border-bottom: 1px solid var(--line-soft);
        vertical-align: middle;
    }
    .rekap-table tbody tr:last-child td { border-bottom: none; }
    .rekap-table tbody tr { transition: background .12s ease; }
    .rekap-table tbody tr:hover { background: var(--neutral); }

    .rekap-table .col-no      { text-align: center; width: 40px; color: var(--text-mute); }
    .rekap-table .col-program { font-weight: 600; color: var(--brand); }
    .rekap-table .col-num     { text-align: center; font-weight: 600; font-variant-numeric: tabular-nums; }
    .rekap-table .col-center  { text-align: center; }

    .badge-category {
        display: inline-block;
        font-weight: 600;
        font-size: .7rem;
        padding: 3px 8px;
        border-radius: 4px;
        background: var(--brand-soft);
        color: var(--brand);
    }
    .badge-category.csr { background: #dbeafe; color: #1e40af; }

    .sisa-value {
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    .sisa-value.has-slot  { color: var(--warning); }
    .sisa-value.full      { color: var(--success); }

    .serapan-cell {
        display: flex;
        flex-direction: column;
        gap: 5px;
        min-width: 90px;
    }
    .serapan-pct {
        font-size: .78rem;
        font-weight: 700;
        font-variant-numeric: tabular-nums;
    }
    .serapan-pct.tone-success { color: var(--success); }
    .serapan-pct.tone-warning { color: var(--warning); }
    .serapan-pct.tone-danger  { color: var(--danger); }
    .serapan-pct.tone-neutral { color: var(--text-mute); }

    .serapan-track {
        height: 4px;
        background: var(--line-soft);
        border-radius: 2px;
        overflow: hidden;
    }
    .serapan-fill {
        height: 100%;
        border-radius: 2px;
        transition: width .4s ease;
    }
    .serapan-fill.tone-success { background: var(--success); }
    .serapan-fill.tone-warning { background: var(--warning); }
    .serapan-fill.tone-danger  { background: var(--danger); }
    .serapan-fill.tone-neutral { background: var(--text-mute); }

    /* ================= SCROLLBAR ================= */
    .status-list::-webkit-scrollbar,
    .kecamatan-list::-webkit-scrollbar,
    .recent-list::-webkit-scrollbar,
    .table-wrapper::-webkit-scrollbar { width: 6px; height: 6px; }
    .status-list::-webkit-scrollbar-thumb,
    .kecamatan-list::-webkit-scrollbar-thumb,
    .recent-list::-webkit-scrollbar-thumb,
    .table-wrapper::-webkit-scrollbar-thumb {
        background: #cbd5e1; border-radius: 3px;
    }

    /* ================= RESPONSIVE ================= */
    @media (max-width: 1024px) {
        .monitoring-main-grid { grid-template-columns: 1fr; }
        .grid-span-2 { grid-column: auto; }
    }
    @media (max-width: 900px) {
        .stat-layout { grid-template-columns: 1fr; }
        .stat-hero { min-height: auto; }
    }
    @media (max-width: 640px) {
        .btn-download-pdf { width: 100%; justify-content: center; }
        .status-row { grid-template-columns: minmax(90px,1fr) 1.5fr minmax(60px,auto); gap: .5rem; }
        .recent-item { grid-template-columns: 10px 1fr; row-gap: .5rem; }
        .recent-item > .badge-status-penempatan { grid-column: 2; justify-self: start; }
    }
    @media (max-width: 480px) {
        .stat-row-item { padding: .9rem 1.15rem; }
        .stat-row-value { font-size: 1.2rem; }
        .stat-row-note { display: none; }
        .stat-hero-value { font-size: 2.5rem; }
        .stat-row-progress { min-width: 100px; }
    }
</style>

@php
    /* Helper presentational — tidak mengubah data, hanya menentukan tone visual */
    $toneFor = function ($key) {
        $k = strtolower(trim((string) $key));
        return match (true) {
            str_contains($k, 'bekerja') && !str_contains($k, 'belum') => 'success',
            str_contains($k, 'phk') || str_contains($k, 'terkena')  => 'danger',
            str_contains($k, 'belum') || str_contains($k, 'mencari')=> 'warning',
            default => 'neutral',
        };
    };

    $hasCsr = $rekapProgram->contains(
        fn ($p) => strtoupper($p->mitra?->kategori ?? '') === 'CSR'
    );
    $colCount = $hasCsr ? 8 : 7;
@endphp

<div class="monitoring-wrapper">

    <!-- ============ HEADER ============ -->
    <div class="monitoring-header">
        <div class="header-text">
            <h1>Monitoring &amp; Laporan Program</h1>
            <p>Pemantauan status masyarakat, rekap data wilayah, dan ekspor laporan</p>
        </div>

        <a href="{{ route('admin.monitoring.download-pdf') }}" class="btn-download-pdf" target="_blank" rel="noopener">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <span>Download PDF</span>
        </a>
    </div>

    <!-- ============ STAT ============ -->
    <section class="stat-layout">
        <div class="stat-hero">
            <p class="stat-hero-label">Total Masyarakat</p>
            <div class="stat-hero-value">{{ number_format($totalMasyarakat) }}</div>
            <p class="stat-hero-foot">Terdaftar dalam sistem</p>
        </div>

        <div class="stat-rows">
            <div class="stat-row-item">
                <div class="stat-row-left">
                    <span class="stat-row-dot is-soft"></span>
                    <span class="stat-row-label">Membutuhkan Pekerjaan</span>
                </div>
                <div class="stat-row-right">
                    <span class="stat-row-value">{{ number_format($butuhPekerjaan) }}</span>
                </div>
            </div>

            <div class="stat-row-item">
                <div class="stat-row-left">
                    <span class="stat-row-dot"></span>
                    <span class="stat-row-label">Tingkat Penempatan</span>
                </div>
                <div class="stat-row-progress">
                    <div class="stat-row-right">
                        <span class="stat-row-value brand">{{ $tingkatPenempatan }}%</span>
                        <span class="stat-row-note">
                            {{ number_format($masyarakatDitempatkan) }} / {{ number_format($totalMasyarakat) }}
                        </span>
                    </div>
                    <div class="mini-track">
                        <div class="mini-fill" style="width: {{ min(100, (float) $tingkatPenempatan) }}%;"></div>
                    </div>
                </div>
            </div>

            <div class="stat-row-item">
                <div class="stat-row-left">
                    <span class="stat-row-dot is-soft"></span>
                    <span class="stat-row-label">Total Penempatan</span>
                </div>
                <div class="stat-row-right">
                    <span class="stat-row-value">{{ number_format($totalPenempatan) }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============ MAIN GRID ============ -->
    <div class="monitoring-main-grid">

        <!-- ===== Distribusi Status Pekerjaan ===== -->
        <article class="card-panel">
            <div class="panel-head panel-head-flex">
                <div>
                    <h2>Distribusi Status Pekerjaan</h2>
                    <p>Jumlah &amp; persentase warga berdasarkan kategori pekerjaan</p>
                </div>
                <div class="panel-head-meta">
                    <span class="count-pill">{{ number_format($totalMasyarakat) }} Warga</span>
                </div>
            </div>

            <div class="status-list">
                @forelse ($distribusiPekerjaan as $row)
                    @php
                        $pctFill = $maxCount > 0 ? round(($row->total / $maxCount) * 100) : 0;
                        if ($row->total > 0 && $pctFill < 6) $pctFill = 6;
                        $pctReal = $totalMasyarakat > 0 ? round(($row->total / $totalMasyarakat) * 100, 1) : 0;
                        $tone    = $toneFor($row->status_pekerjaan);
                    @endphp
                    <div class="status-row">
                        <span class="status-badge-pill tone-{{ $tone }}" title="{{ $row->status_pekerjaan }}">
                            {{ $row->status_pekerjaan }}
                        </span>
                        <div class="progress-track">
                            <div class="progress-fill tone-{{ $tone }}" style="width: {{ $pctFill }}%;"></div>
                        </div>
                        <div class="status-meta">
                            <span class="status-meta-count">{{ $row->total }}</span>
                            <span class="status-meta-sep">·</span>
                            <span class="status-meta-pct">{{ $pctReal }}%</span>
                        </div>
                    </div>
                @empty
                    <div class="empty-state"><p>Belum ada data status pekerjaan.</p></div>
                @endforelse
            </div>

            <div class="panel-foot">
                <span class="panel-foot-label">Total tercatat</span>
                <span class="panel-foot-value">{{ number_format($totalMasyarakat) }} warga</span>
            </div>
        </article>

        <!-- ===== Kasus per Kecamatan ===== -->
        <article class="card-panel">
            <div class="panel-head panel-head-flex">
                <div>
                    <h2>Kasus per Kecamatan</h2>
                    <p>Rasio warga yang butuh kerja terhadap total warga wilayah</p>
                </div>
                <div class="panel-head-meta">
                    <span class="count-pill tone-neutral">{{ $rekapKecamatan->count() }} Kecamatan</span>
                </div>
            </div>

            <div class="kecamatan-list">
                @forelse ($rekapKecamatan as $kec)
                    @php
                        $rasioKec = $kec->total_warga > 0 ? round(($kec->butuh_kerja / $kec->total_warga) * 100, 1) : 0;
                        $kecTone  = $rasioKec <= 0 ? 'success' : ($rasioKec < 50 ? 'warning' : 'danger');
                    @endphp
                    <div class="kecamatan-item">
                        <div class="kecamatan-head">
                            <span class="kecamatan-name">{{ $kec->kecamatan }}</span>
                            <span class="kecamatan-meta">
                                <strong>{{ $kec->butuh_kerja }}</strong> / {{ $kec->total_warga }}
                                <span class="pct-badge tone-{{ $kecTone }}">{{ $rasioKec }}%</span>
                            </span>
                        </div>
                        <div class="kecamatan-bar">
                            <div class="kecamatan-bar-fill tone-{{ $kecTone }}"
                                 style="width: {{ min(100, $rasioKec) }}%;"></div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state"><p>Belum ada data kecamatan terdaftar.</p></div>
                @endforelse
            </div>
        </article>

        <!-- ===== Rekapitulasi Kuota & Serapan Program ===== -->
        <article class="card-panel grid-span-2">
            <div class="panel-head panel-head-flex">
                <div>
                    <h2>Rekapitulasi Kuota &amp; Serapan Program</h2>
                    <p>Monitoring kapasitas, keterisian, dan sisa kuota per program</p>
                </div>
                <div class="panel-head-meta">
                    <span class="count-pill">{{ $rekapProgram->count() }} Program</span>
                </div>
            </div>

            <div class="table-wrapper">
                <table class="rekap-table">
                    <thead>
                        <tr>
                            <th class="col-no">No</th>
                            <th class="text-left">Nama Program</th>
                            <th class="text-left">Penyelenggara</th>
                            @if($hasCsr)
                                <th>Kategori</th>
                            @endif
                            <th>Kuota</th>
                            <th>Masuk</th>
                            <th>Sisa</th>
                            <th>Serapan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapProgram as $index => $prog)
                            @php
                                $kuota   = $prog->kuota ?? $prog->kapasitas ?? 0;
                                $masuk   = $prog->total_masuk ?? 0;
                                $sisa    = max(0, $kuota - $masuk);
                                $serapan = $kuota > 0 ? round(($masuk / $kuota) * 100, 1) : 0;
                                $isCsr   = strtoupper($prog->mitra?->kategori ?? '') === 'CSR';

                                if ($kuota === 0)        $serapanTone = 'neutral';
                                elseif ($serapan >= 100) $serapanTone = 'success';
                                elseif ($serapan > 0)    $serapanTone = 'warning';
                                else                     $serapanTone = 'danger';

                                $sisaTone = $sisa > 0 ? 'has-slot' : 'full';
                            @endphp
                            <tr>
                                <td class="col-no">{{ $index + 1 }}</td>
                                <td class="col-program">{{ $prog->nama_program ?? $prog->nama }}</td>
                                <td>{{ $prog->mitra?->nama_mitra ?? $prog->mitra?->nama ?? '-' }}</td>
                                @if($hasCsr)
                                    <td class="col-center">
                                        <span class="badge-category {{ $isCsr ? 'csr' : '' }}">
                                            {{ $isCsr ? 'CSR' : 'UKPD' }}
                                        </span>
                                    </td>
                                @endif
                                <td class="col-num">{{ number_format($kuota) }}</td>
                                <td class="col-num" style="color: var(--brand);">{{ number_format($masuk) }}</td>
                                <td class="col-num">
                                    <span class="sisa-value {{ $sisaTone }}">{{ number_format($sisa) }}</span>
                                </td>
                                <td class="col-center">
                                    <div class="serapan-cell">
                                        <span class="serapan-pct tone-{{ $serapanTone }}">{{ $serapan }}%</span>
                                        <div class="serapan-track">
                                            <div class="serapan-fill tone-{{ $serapanTone }}"
                                                 style="width: {{ min(100, $serapan) }}%;"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $colCount }}">
                                    <div class="empty-state"><p>Belum ada data program pemberdayaan.</p></div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </article>

    </div>

    <!-- ============ PEMBARUAN PENEMPATAN ============ -->
    <article class="card-panel">
        <div class="panel-head panel-head-flex">
            <div>
                <h2>Pembaruan Penempatan</h2>
                <p>Riwayat seluruh perubahan status penempatan warga ke program pemberdayaan</p>
            </div>
            <div class="panel-head-meta">
                <span class="count-pill">{{ number_format($penempatanTerbaru->count()) }} Data</span>
            </div>
        </div>

        <div class="recent-list">
            @forelse ($penempatanTerbaru as $p)
                @php
                    $statusTone = match($p->status) {
                        'Bekerja'  => 'success',
                        'Diterima' => 'info',
                        'Seleksi'  => 'warning',
                        'Ditolak'  => 'danger',
                        default    => 'neutral',
                    };
                @endphp
                <div class="recent-item">
                    <span class="recent-item-marker tone-{{ $statusTone }}"></span>
                    <div class="recent-item-content">
                        <div class="recent-user-title">
                            {{ $p->masyarakat?->nama ?? 'Warga' }}
                            <span class="muted">(NIK: {{ $p->masyarakat?->nik ?? '-' }})</span>
                            @if($p->program)
                                &middot; <span class="program-name">{{ $p->program->nama }}</span>
                            @endif
                        </div>
                        <div class="recent-user-time">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9"/>
                                <path d="M12 7v5l3 3"/>
                            </svg>
                            <span>Diperbarui: {{ $p->updated_at ? $p->updated_at->format('d M Y, H.i') : '-' }} WIB</span>
                        </div>
                    </div>
                    <span class="badge-status-penempatan tone-{{ $statusTone }}">
                        Status: {{ $p->status }}
                    </span>
                </div>
            @empty
                <div class="empty-state"><p>Belum ada riwayat penempatan program yang tersimpan.</p></div>
            @endforelse
        </div>
    </article>

</div>
@endsection