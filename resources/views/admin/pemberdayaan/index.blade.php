@extends('layouts.admin')

@section('title', 'Pemberdayaan')

@section('content')
@php $tab = request('tab') === 'program' ? 'program' : 'mitra'; @endphp

<div class="page-head">
    <h1>Pemberdayaan</h1>
    <p>Kelola penyelenggara program (UKPD &amp; CSR) dan susun program pelatihan, seminar, serta bimbingan teknis untuk warga.</p>
</div>

@include('admin.partials.notifikasi')

<div class="chip-strip">
    <span class="chip"><strong>{{ $ringkasan['ukpd'] }}</strong> Penyelenggara UKPD</span>
    <span class="chip"><strong>{{ $ringkasan['csr'] }}</strong> Penyelenggara CSR</span>
    <span class="chip"><strong>{{ $ringkasan['program_aktif'] }}</strong> Program aktif</span>
    <span class="chip"><strong>{{ $ringkasan['kursi'] }}</strong> Kursi tersedia</span>
</div>

<div class="tabs-header">
    <div class="tabs">
        <a href="{{ route('admin.pemberdayaan') }}" class="tab {{ $tab === 'mitra' ? 'is-active' : '' }}">
            Penyelenggara ({{ $ringkasan['ukpd'] + $ringkasan['csr'] }})
        </a>
        <a href="{{ route('admin.pemberdayaan', ['tab' => 'program']) }}" class="tab {{ $tab === 'program' ? 'is-active' : '' }}">
            Program ({{ $program->count() }})
        </a>
    </div>

    @if ($tab === 'program')
        <a href="{{ route('admin.program.create') }}" class="btn-primary create-program-btn">Buat Program</a>
    @endif
</div>

@if ($tab === 'mitra')
    <section class="card">
        <div class="card-head" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
            <h2>Penyelenggara Program</h2>

            <div style="display: flex; align-items: center; gap: 10px;">
                <form action="{{ route('admin.pemberdayaan') }}" method="GET" style="margin: 0;">
                    <input type="hidden" name="tab" value="mitra">
                    <select name="jenis" onchange="this.form.submit()" style="padding: 0.5rem; border-radius: 4px; border: 1px solid #ccc;">
                        <option value="">Semua Jenis</option>
                        <option value="UKPD" {{ request('jenis') === 'UKPD' ? 'selected' : '' }}>UKPD</option>
                        <option value="CSR" {{ request('jenis') === 'CSR' ? 'selected' : '' }}>CSR</option>
                    </select>
                </form>

                <a href="{{ route('admin.mitra.create') }}" class="btn-primary">+ Tambah Penyelenggara</a>
            </div>
        </div>

        @if ($mitra->isEmpty())
            <p class="empty-state">Belum ada penyelenggara terdaftar atau tidak ada data yang sesuai filter.</p>
        @else
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Penyelenggara</th>
                            <th>Jenis</th>
                            <th>Bidang</th>
                            <th>Program</th>
                            <th>Kursi Tersedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mitra as $item)
                            <tr>
                                <td class="cell-nama">{{ $item->nama }}</td>
                                <td><span class="badge badge-{{ strtolower($item->jenis) }}">{{ $item->jenis }}</span></td>
                                <td>{{ $item->bidang ?: '—' }}</td>
                                <td>{{ $item->program->whereIn('status', ['Pendaftaran', 'Berjalan'])->count() }} aktif</td>
                                <td>{{ $item->sisa_kuota }}</td>
                                <td class="cell-aksi">
                                    <a href="{{ route('admin.mitra.show', $item) }}" class="btn-icon" title="Lihat Detail" aria-label="Lihat detail {{ $item->nama }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true">
                                            <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                            <circle cx="12" cy="12" r="2.5"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@else
    <section class="card program-filter-shell">
        <style>
            .program-filter-shell {
                background: #f6f9fc;
                border: 1px solid #e5edf5;
                padding: 0;
                overflow: hidden;
            }
            .program-filter-layout {
                display: grid;
                grid-template-columns: 360px minmax(0, 1fr);
                min-height: 640px;
            }
            .tabs-header {
                display: flex;
                align-items: center;
                justify-content: space-between;
                gap: 1rem;
                margin: 1rem 0 0.5rem;
            }
            .create-program-btn {
                white-space: nowrap;
                padding: 0.72rem 1.2rem;
                font-size: 0.92rem;
                border-radius: 10px;
                box-shadow: none;
            }
            .program-sidebar {
                background: #eef3f9;
                border-right: 1px solid #dfeaf4;
                padding: 1.25rem;
            }
            .program-sidebar-top {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0.75rem;
                margin-bottom: 1rem;
            }
            .program-sidebar-top h3 {
                margin: 0;
                font-size: 1.1rem;
                color: #0f172a;
            }
            .program-sidebar-top .btn-primary {
                padding: 0.55rem 0.9rem;
                font-size: 0.8rem;
                white-space: nowrap;
            }
            .program-sidebar-form {
                display: flex;
                flex-direction: column;
                gap: 0.9rem;
                margin-bottom: 1.25rem;
            }
            .program-search {
                position: relative;
            }
            .program-search input {
                width: 100%;
                box-sizing: border-box;
                padding: 0.8rem 0.9rem 0.8rem 2.7rem;
                border: 1px solid #dfeaf4;
                border-radius: 10px;
                background: #fff;
                font-size: 0.92rem;
                color: #1e293b;
                outline: none;
            }
            .program-search input:focus {
                border-color: #12395B;
                box-shadow: 0 0 0 4px rgba(18, 57, 91, 0.08);
            }
            .program-search svg {
                position: absolute;
                left: 0.9rem;
                top: 50%;
                transform: translateY(-50%);
                stroke: #64748b;
            }
            .type-filter {
                display: flex;
                gap: 0.5rem;
                flex-wrap: wrap;
            }
            .type-filter a {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 76px;
                padding: 0.5rem 0.75rem;
                border-radius: 999px;
                border: 1px solid #dfeaf4;
                background: #fff;
                color: #475569;
                text-decoration: none;
                font-size: 0.78rem;
                font-weight: 600;
                transition: all 0.2s ease;
            }
            .type-filter a.is-active,
            .type-filter a:hover {
                background: #dfeaf7;
                border-color: #bfd0eb;
                color: #12395B;
            }
            .mitra-list {
                display: flex;
                flex-direction: column;
                gap: 0.8rem;
                margin-top: 0.5rem;
            }
            .mitra-item {
                display: block;
                width: 100%;
                padding: 0.9rem 0.95rem;
                border: 1px solid #dfeaf4;
                border-radius: 12px;
                background: rgba(255,255,255,0.72);
                text-decoration: none;
                color: #1e293b;
                transition: all 0.2s ease;
            }
            .mitra-item:hover,
            .mitra-item.is-selected {
                background: #ffffff;
                border-color: #bfd0eb;
                box-shadow: 0 8px 18px rgba(18, 57, 91, 0.08);
                transform: translateY(-1px);
            }
            .mitra-item-row {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 0.7rem;
            }
            .mitra-code {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                min-width: 56px;
                padding: 0.32rem 0.5rem;
                border-radius: 999px;
                font-size: 0.7rem;
                font-weight: 700;
                letter-spacing: 0.03em;
                background: #dfeaf7;
                color: #12395B;
            }
            .mitra-code.csr {
                background: #fbe9f2;
                color: #9d1b5a;
            }
            .mitra-name {
                margin-top: 0.6rem;
                font-size: 1rem;
                font-weight: 700;
                line-height: 1.35;
            }
            .mitra-meta {
                margin-top: 0.28rem;
                font-size: 0.78rem;
                color: #64748b;
            }
            .program-panel {
                background: #ffffff;
                padding: 1.5rem;
            }
            .program-header {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1rem;
                margin-bottom: 1.25rem;
                padding-bottom: 1rem;
                border-bottom: 1px solid #edf2f7;
            }
            .program-header-title {
                display: flex;
                flex-direction: column;
                gap: 0.35rem;
            }
            .program-header-title h2 {
                margin: 0;
                font-size: 1.6rem;
                color: #0f172a;
            }
            .program-header-title p {
                margin: 0;
                color: #64748b;
                font-size: 0.9rem;
            }
            .program-header-actions {
                display: flex;
                align-items: center;
                gap: 0.75rem;
                flex-wrap: wrap;
            }
            .program-summary {
                display: grid;
                grid-template-columns: repeat(3, minmax(120px, 1fr));
                gap: 0.85rem;
                margin-bottom: 1.4rem;
            }
            .summary-box {
                background: #f8fbff;
                border: 1px solid #e7eef8;
                border-radius: 12px;
                padding: 0.8rem 0.9rem;
            }
            .summary-box span {
                display: block;
                font-size: 0.72rem;
                color: #64748b;
                margin-bottom: 0.35rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
            .summary-box strong {
                font-size: 1.05rem;
                color: #12395B;
            }
            .program-list {
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            .program-card {
                background: #fff;
                border: 1px solid #e7edf5;
                border-radius: 16px;
                padding: 1rem 1.1rem;
                box-shadow: 0 10px 18px rgba(15, 23, 42, 0.03);
            }
            .program-card-top {
                display: flex;
                justify-content: space-between;
                align-items: flex-start;
                gap: 1rem;
            }
            .program-card-left {
                display: flex;
                flex-direction: column;
                gap: 0.5rem;
            }
            .program-card-meta {
                display: flex;
                align-items: center;
                gap: 0.5rem;
                flex-wrap: wrap;
            }
            .program-status {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.32rem 0.65rem;
                border-radius: 999px;
                font-size: 0.7rem;
                font-weight: 700;
                background: #eaf5ff;
                color: #12395B;
                border: 1px solid #d5e8ff;
            }
            .program-type {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.3rem 0.65rem;
                border-radius: 999px;
                font-size: 0.7rem;
                font-weight: 700;
                background: #eef8f0;
                color: #166534;
                border: 1px solid #cfead7;
            }
            .program-name {
                margin: 0;
                font-size: 1.05rem;
                font-weight: 700;
                color: #0f172a;
            }
            .program-sponsor {
                margin: 0;
                font-size: 0.85rem;
                color: #64748b;
            }
            .program-brief {
                display: flex;
                flex-wrap: wrap;
                gap: 0.5rem;
                margin-top: 0.8rem;
            }
            .program-pill {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                padding: 0.38rem 0.7rem;
                border-radius: 999px;
                font-size: 0.72rem;
                background: #edf7ef;
                color: #166534;
                border: 1px solid #d4ead9;
            }
            .program-right {
                display: flex;
                flex-direction: column;
                align-items: flex-end;
                justify-content: space-between;
                min-width: 110px;
                gap: 0.65rem;
            }
            .program-score {
                font-size: 1.8rem;
                font-weight: 800;
                color: #12395B;
                line-height: 1;
            }
            .program-score-note {
                font-size: 0.76rem;
                color: #64748b;
            }
            .program-action {
                display: inline-flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                padding: 0.85rem 1rem;
                border-radius: 12px;
                color: #fff;
                background: linear-gradient(135deg, #12395B, #1d4f88);
                text-decoration: none;
                font-weight: 700;
                font-size: 0.96rem;
                box-shadow: 0 10px 18px rgba(18, 57, 91, 0.15);
            }
            @media (max-width: 980px) {
                .program-filter-layout {
                    grid-template-columns: 1fr;
                }
                .program-sidebar {
                    border-right: 0;
                    border-bottom: 1px solid #dfeaf4;
                }
            }
            @media (max-width: 640px) {
                .program-header {
                    flex-direction: column;
                    align-items: stretch;
                }
                .program-summary {
                    grid-template-columns: 1fr;
                }
                .program-card-top {
                    flex-direction: column;
                    align-items: stretch;
                }
                .program-right {
                    align-items: stretch;
                    min-width: 0;
                }
            }
        </style>

        <div class="program-filter-layout">
            <aside class="program-sidebar">
                <div class="program-sidebar-top">
                    <h3>Penyelenggara</h3>
                </div>

                <form class="program-sidebar-form" action="{{ route('admin.pemberdayaan', ['tab' => 'program']) }}" method="GET">
                    <input type="hidden" name="tab" value="program">
                    <input type="hidden" name="mitra_id" value="{{ $selectedMitra?->id ?? '' }}">

                    <div class="program-search">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <circle cx="11" cy="11" r="7"></circle>
                            <path d="M20 20l-3.5-3.5"></path>
                        </svg>
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari penyelenggara...">
                    </div>

                    <div class="type-filter">
                        <a href="{{ route('admin.pemberdayaan', ['tab' => 'program', 'search' => $search, 'jenis' => '']) }}" class="{{ empty($jenis) ? 'is-active' : '' }}">Semua</a>
                        <a href="{{ route('admin.pemberdayaan', ['tab' => 'program', 'search' => $search, 'jenis' => 'UKPD']) }}" class="{{ $jenis === 'UKPD' ? 'is-active' : '' }}">UKPD</a>
                        <a href="{{ route('admin.pemberdayaan', ['tab' => 'program', 'search' => $search, 'jenis' => 'CSR']) }}" class="{{ $jenis === 'CSR' ? 'is-active' : '' }}">CSR</a>
                    </div>
                </form>

                @if ($mitra->isEmpty())
                    <p class="empty-state">Tidak ada penyelenggara sesuai filter.</p>
                @else
                    <div class="mitra-list">
                        @foreach ($mitra as $item)
                            @php
                                $selected = $selectedMitra && $selectedMitra->id === $item->id;
                                $typeClass = strtolower($item->jenis) === 'csr' ? 'csr' : '';
                                $query = ['tab' => 'program', 'search' => $search, 'jenis' => $jenis, 'mitra_id' => $item->id];
                            @endphp
                            <a href="{{ route('admin.pemberdayaan', $query) }}" class="mitra-item {{ $selected ? 'is-selected' : '' }}">
                                <div class="mitra-item-row">
                                    <span class="mitra-code {{ $typeClass }}">{{ $item->jenis }}</span>
                                    <span style="font-size:0.7rem;color:#64748b;font-weight:600;">{{ $item->program->count() }} program</span>
                                </div>
                                <div class="mitra-name">{{ $item->nama }}</div>
                                <div class="mitra-meta">{{ $item->bidang ?: 'Pemberdayaan masyarakat' }}</div>
                            </a>
                        @endforeach
                    </div>
                @endif
            </aside>

            <div class="program-panel">
                @if (!$selectedMitra)
                    <div class="empty-state" style="padding: 2rem 0;">Pilih penyelenggara untuk melihat daftar programnya.</div>
                @else
                    <div class="program-header">
                        <div class="program-header-title">
                            <h2>{{ $selectedMitra->nama }}</h2>
                            <p>{{ $selectedMitra->bidang ?: 'Program pemberdayaan masyarakat' }}</p>
                        </div>
                        <div class="program-header-actions">
                            <span class="program-status">{{ $selectedMitra->jenis }}</span>
                            <a href="{{ route('admin.mitra.show', $selectedMitra) }}" class="btn-ghost">Lihat Detail</a>
                        </div>
                    </div>

                    <div class="program-summary">
                        <div class="summary-box">
                            <span>Program</span>
                            <strong>{{ $program->count() }}</strong>
                        </div>
                        <div class="summary-box">
                            <span>Kursi</span>
                            <strong>{{ $program->sum('kuota') }}</strong>
                        </div>
                        <div class="summary-box">
                            <span>Peserta</span>
                            <strong>{{ $program->sum('peserta') }}</strong>
                        </div>
                    </div>

                    @if ($program->isEmpty())
                        <p class="empty-state">Belum ada program untuk penyelenggara ini.</p>
                    @else
                        <div class="program-list">
                            @foreach ($program as $item)
                                <article class="program-card">
                                    <div class="program-card-top">
                                        <div class="program-card-left">
                                            <div class="program-card-meta">
                                                <span class="program-status">{{ $item->status }}</span>
                                                <span class="program-type">{{ $item->jenis }}</span>
                                            </div>
                                            <h3 class="program-name">{{ $item->nama }}</h3>
                                            <p class="program-sponsor">{{ $selectedMitra->nama }} · {{ $item->kategori }}</p>
                                        </div>

                                        <div class="program-right">
                                            <div class="program-score">{{ $item->persen_terisi }}%</div>
                                            <div class="program-score-note">{{ $item->peserta }}/{{ $item->kuota }} peserta</div>
                                        </div>
                                    </div>

                                    <div class="program-brief">
                                        @if ($item->kriteria)
                                            <span class="program-pill">{{ $item->kriteria }}</span>
                                        @endif
                                        @if ($item->tanggal_mulai)
                                            <span class="program-pill">{{ $item->tanggal_mulai->format('d M Y') }} – {{ $item->tanggal_selesai->format('d M Y') }}</span>
                                        @endif
                                        @if ($item->lokasi)
                                            <span class="program-pill">{{ $item->lokasi }}</span>
                                        @endif
                                    </div>

                                    <div style="margin-top: 1rem; display: flex; gap: 0.6rem; justify-content: flex-end;">
                                        <a href="{{ route('admin.program.show', $item) }}" class="btn-ghost">Detail</a>
                                        <a href="{{ route('admin.program.edit', $item) }}" class="btn-primary">Edit</a>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </section>
@endif
@endsection
