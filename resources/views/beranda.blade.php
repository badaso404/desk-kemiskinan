@extends('layouts.app')

@section('title', 'Beranda - Pemberdayaan Masyarakat Jakarta Barat')

@section('content')
<!-- HERO -->
<section class="hero" id="tentang">
    <div class="hero-inner">
        <div class="hero-text">
            <h1>Pendataan dan Pemberdayaan Masyarakat Jakarta Barat</h1>
            <p>
                Platform resmi Pemerintah Kota Administrasi Jakarta Barat untuk pendataan warga
                dan fasilitasi akses program pelatihan keterampilan guna meningkatkan
                kesejahteraan masyarakat.
            </p>
            <a href="#pelatihan" class="btn-outline">Lihat Pelatihan</a>
        </div>
        <div class="hero-media">
            @include('partials.gambar', [
                'file' => 'hero-kegiatan.jpg',
                'label' => 'Foto Kegiatan Pelatihan',
                'class' => 'hero-image',
            ])
        </div>
    </div>
</section>

<!-- STATISTIK -->
<section class="stats">
    <div class="stats-grid">
        @foreach ($statistik as $item)
            <div class="stat-card">
                <strong>{{ $item['angka'] }}</strong>
                <span>{{ $item['label'] }}</span>
            </div>
        @endforeach
    </div>
</section>

<!-- CARA BERGABUNG -->
<section class="steps">
    <h2>Cara Bergabung</h2>
    <div class="steps-grid">
        @foreach ($langkah as $i => $item)
            <div class="step">
                <div class="step-icon">
                    @switch($item['ikon'])
                        @case('daftar')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <circle cx="10" cy="8" r="3.2"/><path d="M3.5 19c0-3.2 2.9-5.3 6.5-5.3"/>
                                <path d="M17 13v6M20 16h-6"/>
                            </svg>
                            @break
                        @case('isi-data')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M14 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h5"/><path d="M14 3l5 5"/><path d="M14 3v5h5"/>
                                <path d="M19.2 13.8a1.6 1.6 0 0 1 2.3 2.3L17 20.6l-3 .7.7-3Z"/>
                            </svg>
                            @break
                        @case('verifikasi')
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M12 3l7 3v6c0 4.2-2.9 7.7-7 9-4.1-1.3-7-4.8-7-9V6Z"/><path d="m9 12 2 2 4-4"/>
                            </svg>
                            @break
                        @default
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M12 4 2 9l10 5 10-5-10-5Z"/><path d="M6 12v4c0 1.1 2.7 2.5 6 2.5s6-1.4 6-2.5v-4"/>
                            </svg>
                    @endswitch
                </div>
                <h3>{{ $i + 1 }}. {{ $item['judul'] }}</h3>
                <p>{{ $item['teks'] }}</p>
            </div>
        @endforeach
    </div>
</section>

<!-- PELATIHAN UNGGULAN -->
<section class="training" id="pelatihan">
    <div class="training-head">
        <div>
            <h2>Pelatihan Unggulan</h2>
            <p>Tingkatkan keterampilan Anda dengan program terbaru.</p>
        </div>
        <a href="#" class="link-all">Lihat Semua &rarr;</a>
    </div>

    <div class="training-grid">
        @foreach ($pelatihan as $item)
            <a href="{{ route('pelatihan.detail', $item['slug']) }}" class="training-card">
                @include('partials.gambar', [
                    'file' => $item['gambar'],
                    'label' => $item['kategori'],
                    'class' => 'training-image',
                ])

                <div class="training-body">
                    <div class="training-meta">
                        <span class="tag">{{ $item['kategori'] }}</span>
                        <span class="kuota">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <circle cx="9" cy="8" r="3"/><path d="M3 19c0-3 2.7-5 6-5s6 2 6 5"/><circle cx="17" cy="9" r="2.2"/>
                            </svg>
                            {{ $item['kuota'] }}
                        </span>
                    </div>

                    <h3>{{ $item['judul'] }}</h3>
                    <p class="training-org">{{ $item['penyelenggara'] }}</p>

                    <ul class="training-info">
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <rect x="3" y="5" width="18" height="16" rx="2"/><path d="M3 10h18M8 3v4M16 3v4"/>
                            </svg>
                            {{ $item['tanggal'] }}
                        </li>
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                                <path d="M12 21s7-5.3 7-11a7 7 0 1 0-14 0c0 5.7 7 11 7 11Z"/><circle cx="12" cy="10" r="2.5"/>
                            </svg>
                            {{ $item['lokasi'] }}
                        </li>
                    </ul>

                    <span class="training-more">
                        Lihat Detail
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </span>
                </div>
            </a>
        @endforeach
    </div>
</section>
@endsection
