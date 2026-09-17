@extends('layouts.admin')

@section('title', $program->nama)

@section('content')
<a href="{{ route('admin.pemberdayaan', ['tab' => 'program']) }}" class="link-back">&larr; Kembali ke Pemberdayaan</a>

<section class="program-hero">
    <div class="program-hero-main">
        <div class="program-kicker">
            <span class="badge badge-{{ strtolower($program->status) }}">{{ $program->status }}</span>
            <span>{{ $program->jenis }}</span>
            <span>{{ $program->kategori }}</span>
        </div>
        <h1>{{ $program->nama }}</h1>
        <p class="program-lead">{{ $program->deskripsi ?: 'Program pemberdayaan untuk meningkatkan kapasitas dan keahlian warga.' }}</p>
        <div class="program-meta">
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M12 21s7-6.1 7-12a7 7 0 1 0-14 0c0 5.9 7 12 7 12Z"/><circle cx="12" cy="9" r="2.5"/></svg>
                {{ $program->lokasi }}
            </span>
            <span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="4.5" width="18" height="16" rx="2"/><path d="M16 2.5v4M8 2.5v4M3 9h18"/></svg>
                {{ $program->tanggal_mulai->format('d M Y') }} – {{ $program->tanggal_selesai->format('d M Y') }}
            </span>
        </div>
    </div>
    <div class="program-hero-actions">
        <a href="{{ route('admin.program.edit', $program) }}" class="btn-icon" title="Ubah Program" aria-label="Ubah program {{ $program->nama }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
            </svg>
        </a>
        <form action="{{ route('admin.program.destroy', $program) }}" method="POST"
              onsubmit="return confirm('Hapus program {{ $program->nama }}?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon is-danger" title="Hapus Program" aria-label="Hapus program {{ $program->nama }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </button>
        </form>
    </div>
</section>

@include('admin.partials.notifikasi')

<section class="program-metrics">
    <div class="program-metric">
        <span class="program-metric-label">Peserta terdaftar</span>
        <strong>{{ $program->peserta }} <small>/ {{ $program->kuota }}</small></strong>
        <div class="program-progress" aria-label="{{ $program->persen_terisi }} persen kuota terisi">
            <span style="width: {{ $program->persen_terisi }}%"></span>
        </div>
        <span class="program-metric-note">{{ $program->persen_terisi }}% kuota terisi</span>
    </div>
    <div class="program-metric">
        <span class="program-metric-label">Kursi tersedia</span>
        <strong>{{ $program->sisa_kuota }}</strong>
        <span class="program-metric-note">dari {{ $program->kuota }} total kursi</span>
    </div>
    <div class="program-metric">
        <span class="program-metric-label">Penyelenggara</span>
        <strong class="program-metric-text">{{ $program->mitra?->nama ?? $program->penyelenggara }}</strong>
        <span class="program-metric-note">{{ $program->mitra ? $program->mitra->jenis . ' · Mitra' : 'Dikelola Pemkot' }}</span>
    </div>
</section>

<div class="program-detail-grid">
    <section class="card">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">Informasi kegiatan</span>
                <h2>Ringkasan Program</h2>
            </div>
            <svg class="section-heading-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5v-16Z"/><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/></svg>
        </div>
        <dl class="detail-facts detail-facts-spacious">
            <div><dt>Penyelenggara</dt><dd>{{ $program->mitra?->nama ?? $program->penyelenggara }}</dd></div>
            <div><dt>Lokasi</dt><dd>{{ $program->lokasi }}</dd></div>
            <div><dt>Jadwal</dt><dd>{{ $program->tanggal_mulai->format('d M Y') }} – {{ $program->tanggal_selesai->format('d M Y') }}</dd></div>
            <div><dt>Status</dt><dd><span class="badge badge-{{ strtolower($program->status) }}">{{ $program->status }}</span></dd></div>
        </dl>
    </section>

    <section class="card">
        <div class="section-heading">
            <div>
                <span class="section-eyebrow">Profil peserta</span>
                <h2>Kriteria &amp; Keahlian</h2>
            </div>
            <svg class="section-heading-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="12" cy="8" r="3.5"/><path d="M4.5 20c.7-3.3 3.2-5 7.5-5s6.8 1.7 7.5 5"/></svg>
        </div>
        <div class="program-detail-block">
            <span class="detail-label">Kriteria peserta</span>
            <div class="tag-list">
                @forelse ($program->daftar_kriteria as $kriteria)
                    <span class="detail-tag">{{ $kriteria }}</span>
                @empty
                    <span class="muted-copy">Belum ada kriteria peserta.</span>
                @endforelse
            </div>
        </div>
        <div class="program-detail-block">
            <span class="detail-label">Keahlian yang dihasilkan</span>
            <div class="tag-list">
                @forelse ($program->daftar_keahlian_dihasilkan as $keahlian)
                    <span class="detail-tag detail-tag-accent">{{ $keahlian }}</span>
                @empty
                    <span class="muted-copy">Belum ada keahlian yang dicatat.</span>
                @endforelse
            </div>
        </div>
    </section>
</div>

<section class="card program-description">
    <div class="section-heading">
        <div>
            <span class="section-eyebrow">Gambaran umum</span>
            <h2>Deskripsi Program</h2>
        </div>
        <svg class="section-heading-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><path d="M5 4h14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Z"/><path d="M7 8h10M7 12h10M7 16h6"/></svg>
    </div>
    <p>{{ $program->deskripsi ?: 'Belum ada deskripsi untuk program ini.' }}</p>
</section>
@endsection
