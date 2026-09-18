@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
@php
    $userRole = auth()->user()->role ?? 'admin';

    // Mapping Nama Role untuk Judul Utama Selamat Datang
    $roleLabels = [
        'admin'          => 'Administrator',
        'kecamatan'      => 'Kecamatan',
        'pimpinan_kesra' => 'Pimpinan Kesra',
        'kelurahan'      => 'Kelurahan',
        'walikota'       => 'Walikota',
    ];

    // Subtitle Deskripsi Sesuai Role
    $roleDescriptions = [
        'admin'          => 'Kelola pendataan warga dan penyelenggaraan program pemberdayaan secara penuh.',
        'kecamatan'      => 'Kelola pendataan warga dan monitoring program pemberdayaan wilayah Kecamatan.',
        'pimpinan_kesra' => 'Kelola dan koordinasikan program penanggulangan kemiskinan dan Kesra.',
        'kelurahan'      => 'Pendataan dan verifikasi awal berkas warga di tingkat Kelurahan.',
        'walikota'       => 'Ringkasan eksekutif monitoring data kemiskinan dan statistik penempatan warga.',
    ];

    $namaRole = $roleLabels[$userRole] ?? 'Pengguna';
    $descRole = $roleDescriptions[$userRole] ?? 'Kelola pendataan warga dan penyelenggaraan program pemberdayaan.';
@endphp

<div class="page-head">
    <h1>Selamat Datang, {{ $namaRole }}</h1>
    <p>{{ $descRole }}</p>
</div>

<!-- KARTU RINGKASAN -->
<section class="stat-grid">
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Warga Terdata</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="1.8">
                <circle cx="9" cy="8" r="3"/><path d="M3 19c0-3 2.7-5 6-5s6 2 6 5"/><path d="M17 14c2.3 0 4 1.6 4 4"/><circle cx="17" cy="9" r="2.2"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['total_masyarakat']) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Program Aktif</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#2f7d57" stroke-width="1.8">
                <path d="M12 4 2 9l10 5 10-5-10-5Z"/><path d="M6 12v4c0 1.1 2.7 2.5 6 2.5s6-1.4 6-2.5v-4"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['program_aktif']) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Kursi dari UKPD</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#1d4ed8" stroke-width="1.8">
                <rect x="4" y="3" width="16" height="18" rx="2"/><path d="M8 7h2M14 7h2M8 11h2M14 11h2M8 15h2M14 15h2"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['kursi_ukpd']) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head">
            <span>Kursi dari CSR</span>
            <svg viewBox="0 0 24 24" fill="none" stroke="#c2570c" stroke-width="1.8">
                <path d="M3 13h4l3 5 3-11 2 6h6"/>
            </svg>
        </div>
        <strong>{{ number_format($ringkasan['kursi_csr']) }}</strong>
    </div>
</section>

<!-- BARIS GRAFIK -->
<section class="grid-two">
    <article class="card">
        <h2>Status Program</h2>
        <div class="bar-list">
            @php $maksimal = max(array_column($statusProgram, 'jumlah')) ?: 1; @endphp
            @foreach ($statusProgram as $status)
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
        <h2>Sumber Kursi Program</h2>
        @php
            $ukpd = $ringkasan['kursi_ukpd'];
            $csr = $ringkasan['kursi_csr'];
            $totalKursi = $ukpd + $csr;
            $keliling = 2 * M_PI * 70; // r = 70
            $porsiUkpd = $totalKursi ? $ukpd / $totalKursi * $keliling : 0;
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
                <strong>{{ $totalKursi }}</strong>
                <span>Kursi</span>
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
        <div class="card-head">
            <h2>Pendaftaran Dibuka</h2>
            @if(in_array($userRole, ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan']))
                <a href="{{ route('admin.pemberdayaan', ['tab' => 'program']) }}" class="card-link">Kelola</a>
            @endif
        </div>
        <div class="reco-list">
            @forelse ($programTerbuka as $program)
                <div class="reco-item">
                    <div>
                        <strong>{{ $program->nama }}</strong>
                        <span>{{ $program->sisa_kuota }} kursi tersisa &middot; mulai {{ \Carbon\Carbon::parse($program->tanggal_mulai)->format('d M') }}</span>
                    </div>
                    @if(in_array($userRole, ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan']))
                        <a href="{{ route('admin.program.edit', $program) }}" class="reco-go" aria-label="Kelola {{ $program->nama }}">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </a>
                    @endif
                </div>
            @empty
                <p class="empty-state">Belum ada program yang membuka pendaftaran.</p>
            @endforelse
        </div>
    </article>

    <article class="card">
        <div class="card-head">
            <h2>Warga Terbaru</h2>
            @if(in_array($userRole, ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan']))
                <a href="{{ route('admin.masyarakat') }}" class="card-link">Lihat Semua</a>
            @endif
        </div>
        <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Kecamatan</th>
                        <th>Keahlian</th>
                        <th>Minat Pelatihan</th>
                        @if(in_array($userRole, ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan']))
                            <th>Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($masyarakatTerbaru as $warga)
                        <tr>
                            <td class="cell-nama">{{ $warga->nama }}</td>
                            <td>{{ $warga->kecamatan }}</td>
                            <td>{{ $warga->keahlian ?: '—' }}</td>
                            <td>{{ $warga->minat_pelatihan ?: '—' }}</td>
                            @if(in_array($userRole, ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan']))
                                <td class="cell-aksi">
                                    <a href="{{ route('admin.rekomendasi.show', $warga) }}" class="btn-link">Rekomendasi</a>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr><td colspan="{{ in_array($userRole, ['admin', 'kecamatan', 'pimpinan_kesra', 'kelurahan']) ? 5 : 4 }}"><p class="empty-state">Belum ada warga terdata.</p></td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </article>
</section>
@endsection