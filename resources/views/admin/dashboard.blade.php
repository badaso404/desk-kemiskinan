@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-head">
    <h1>Selamat Datang, {{ auth()->user()->name }}</h1>
    <p>Kelola data masyarakat dan kesempatan kerja.</p>
</div>

<!-- KARTU RINGKASAN -->
<section class="stat-grid">
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Total Masyarakat</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="1.8">
                <circle cx="9" cy="8" r="3"/><path d="M3 19c0-3 2.7-5 6-5s6 2 6 5"/><path d="M17 14c2.3 0 4 1.6 4 4"/><circle cx="17" cy="9" r="2.2"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['total_masyarakat']) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Membutuhkan<br>Pekerjaan</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="1.8">
                <rect x="3" y="7" width="18" height="13" rx="2"/><path d="M9 7V5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2"/><path d="m4 5 16 16"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['butuh_pekerjaan']) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Kebutuhan UKPD</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="1.8">
                <rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h2M14 7h2M8 11h2M14 11h2M8 15h2M14 15h2"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['kebutuhan_ukpd']) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Kebutuhan CSR</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="1.8">
                <path d="M3 13h4l3 5 3-11 2 6h6"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['kebutuhan_csr']) }}</strong>
    </div>
</section>

<!-- BARIS GRAFIK -->
<section class="grid-two">
    <article class="card">
        <h2>Status Masyarakat</h2>
        <div class="bar-list">
            @php $maksimal = max(array_column($statusMasyarakat, 'jumlah')) ?: 1; @endphp
            @foreach ($statusMasyarakat as $status)
                <div class="bar-item">
                    <div class="bar-label">
                        <span>{{ $status['label'] }}</span>
                        <span>{{ number_format($status['jumlah']) }}</span>
                    </div>
                    <div class="bar-track">
                        <div class="bar-fill"
                             style="width: {{ round($status['jumlah'] / $maksimal * 100) }}%; background: {{ $status['warna'] }};"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </article>

    <article class="card">
        <h2>Kebutuhan Pekerjaan</h2>
        @php
            $ukpd = $ringkasan['kebutuhan_ukpd'];
            $csr = $ringkasan['kebutuhan_csr'];
            $totalKebutuhan = $ukpd + $csr;
            $keliling = 2 * M_PI * 70; // r = 70
            $porsiUkpd = $totalKebutuhan ? $ukpd / $totalKebutuhan * $keliling : 0;
        @endphp
        <div class="donut-wrapper">
            <svg class="donut" viewBox="0 0 160 160">
                <circle cx="80" cy="80" r="70" fill="none" stroke="#eef2ff" stroke-width="16"/>
                <circle cx="80" cy="80" r="70" fill="none" stroke="#1d4ed8" stroke-width="16"
                        stroke-dasharray="{{ $porsiUkpd }} {{ $keliling }}"
                        stroke-linecap="butt" transform="rotate(-90 80 80)"/>
                <circle cx="80" cy="80" r="70" fill="none" stroke="#c2570c" stroke-width="16"
                        stroke-dasharray="{{ $keliling - $porsiUkpd }} {{ $keliling }}"
                        stroke-dashoffset="{{ -$porsiUkpd }}"
                        stroke-linecap="butt" transform="rotate(-90 80 80)"/>
            </svg>
            <div class="donut-center">
                <strong>{{ $totalKebutuhan }}</strong>
                <span>Total</span>
            </div>
        </div>
        <div class="legend">
            <span class="legend-item"><i style="background:#1d4ed8"></i> UKPD ({{ $ukpd }})</span>
            <span class="legend-item"><i style="background:#c2570c"></i> CSR ({{ $csr }})</span>
        </div>
    </article>
</section>

<!-- BARIS BAWAH -->
<section class="grid-side">
    <article class="card">
        <h2>Rekomendasi Terbaru</h2>
        <div class="reco-list">
            @foreach ($rekomendasi as $item)
                <div class="reco-item">
                    <div>
                        <strong>{{ $item['posisi'] }}</strong>
                        <span>Match: {{ $item['match'] }}%</span>
                    </div>
                    <a href="#" class="reco-go" aria-label="Lihat {{ $item['posisi'] }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    </article>

    <article class="card">
        <div class="card-head">
            <h2>Masyarakat Terbaru</h2>
            <a href="#" class="card-link">Lihat Semua</a>
        </div>
        <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Wilayah</th>
                        <th>Keahlian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($masyarakatTerbaru as $warga)
                        <tr>
                            <td class="cell-nama">{{ $warga['nama'] }}</td>
                            <td>{{ $warga['wilayah'] }}</td>
                            <td>{{ $warga['keahlian'] }}</td>
                            <td>
                                <span class="badge badge-{{ \Illuminate\Support\Str::slug($warga['status']) }}">
                                    {{ $warga['status'] }}
                                </span>
                            </td>
                            <td>
                                <a href="#" class="btn-edit" aria-label="Ubah data {{ $warga['nama'] }}">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                    </svg>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection
