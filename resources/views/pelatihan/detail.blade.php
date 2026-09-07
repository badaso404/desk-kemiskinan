@extends('layouts.app')

@section('title', $pelatihan['judul'].' - Pemberdayaan Masyarakat Jakarta Barat')

@section('content')
<section class="detail">
    <a href="{{ route('beranda') }}#pelatihan" class="detail-back">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M19 12H5M11 18l-6-6 6-6"/>
        </svg>
        Kembali ke daftar pelatihan
    </a>

    <div class="detail-head">
        <span class="tag">{{ $pelatihan['kategori'] }}</span>
        <h1>{{ $pelatihan['judul'] }}</h1>
        <p class="detail-org">{{ $pelatihan['penyelenggara'] }}</p>
    </div>

    @include('partials.gambar', [
        'file' => $pelatihan['gambar'],
        'label' => $pelatihan['kategori'],
        'class' => 'detail-image',
    ])

    <div class="detail-grid">
        <div class="detail-main">
            <article class="detail-block">
                <h2>Tentang Program</h2>
                <p>{{ $pelatihan['deskripsi'] }}</p>
            </article>

            <article class="detail-block">
                <h2>Materi Pelatihan</h2>
                <ul class="detail-list">
                    @foreach ($pelatihan['materi'] as $materi)
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m5 13 4 4L19 7"/>
                            </svg>
                            {{ $materi }}
                        </li>
                    @endforeach
                </ul>
            </article>

            <article class="detail-block">
                <h2>Persyaratan Peserta</h2>
                <ul class="detail-list">
                    @foreach ($pelatihan['syarat'] as $syarat)
                        <li>
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="m5 13 4 4L19 7"/>
                            </svg>
                            {{ $syarat }}
                        </li>
                    @endforeach
                </ul>
            </article>
        </div>

        <aside class="detail-side">
            <h2>Informasi Pelaksanaan</h2>
            <dl class="detail-facts">
                <div>
                    <dt>Tanggal</dt>
                    <dd>{{ $pelatihan['tanggal'] }}</dd>
                </div>
                <div>
                    <dt>Lokasi</dt>
                    <dd>{{ $pelatihan['lokasi'] }}</dd>
                </div>
                <div>
                    <dt>Durasi</dt>
                    <dd>{{ $pelatihan['durasi'] }}</dd>
                </div>
                <div>
                    <dt>Kuota</dt>
                    <dd>{{ $pelatihan['kuota'] }}</dd>
                </div>
                <div>
                    <dt>Biaya</dt>
                    <dd>{{ $pelatihan['biaya'] }}</dd>
                </div>
            </dl>
            <p class="detail-note">
                Pendataan peserta dilakukan melalui kelurahan sesuai alur Cara Bergabung.
            </p>
        </aside>
    </div>

    @if ($lainnya)
        <div class="detail-other">
            <h2>Pelatihan Lainnya</h2>
            <div class="training-grid">
                @foreach ($lainnya as $item)
                    <a href="{{ route('pelatihan.detail', $item['slug']) }}" class="training-card">
                        @include('partials.gambar', [
                            'file' => $item['gambar'],
                            'label' => $item['kategori'],
                            'class' => 'training-image',
                        ])
                        <div class="training-body">
                            <div class="training-meta">
                                <span class="tag">{{ $item['kategori'] }}</span>
                                <span class="kuota">{{ $item['kuota'] }}</span>
                            </div>
                            <h3>{{ $item['judul'] }}</h3>
                            <p class="training-org">{{ $item['penyelenggara'] }}</p>
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
        </div>
    @endif
</section>
@endsection
