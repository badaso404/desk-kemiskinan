@extends('layouts.admin')

@section('title', 'Rekomendasi - ' . $warga->nama)
 
@section('content')
<style>
    /* UTILITY & COLOR PALETTE (#12395B PRIMARY) */
    :root {
        --primary: #12395B;
        --primary-hover: #0d2a43;
        --primary-light: #ebf3fa;
        --primary-border: #b9d3eb;
    }

    .rekomendasi-container {
        width: 100%;
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 1.25rem;
        transition: color 0.2s ease;
    }
    .btn-back:hover { color: var(--primary); }

    .page-header {
        margin-bottom: 1.75rem;
    }
    .page-header h1 {
        font-size: clamp(1.35rem, 2vw, 1.75rem);
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.35rem 0;
        letter-spacing: -0.02em;
    }
    .page-header p {
        color: #64748b;
        font-size: clamp(0.85rem, 1.2vw, 0.95rem);
        margin: 0;
    }

    /* GRID LAYOUT (FULL WIDTH & ADAPTIVE) */
    .grid-layout {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 1.5rem;
        align-items: start;
        width: 100%;
    }

    /* CARD COMPONENTS */
    .custom-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.03);
        overflow: hidden;
        width: 100%;
        box-sizing: border-box;
    }

    /* NOTIFICATION */
    .alert-danger {
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
        padding: 1rem 1.25rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 0.875rem;
        font-weight: 500;
    }

    /* MATCH ITEM STYLING */
    .match-card {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        transition: background-color 0.2s ease;
    }
    .match-card:last-child {
        border-bottom: none;
    }
    .match-card:hover {
        background-color: #f8fafc;
    }

    .match-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        margin-bottom: 1.25rem;
    }

    .match-title {
        font-size: clamp(1rem, 1.5vw, 1.125rem);
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 0.35rem 0;
    }

    .match-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        flex-wrap: wrap;
        color: #64748b;
        font-size: 0.85rem;
    }

    /* BADGES & TAGS */
    .badge-pill {
        display: inline-flex;
        align-items: center;
        padding: 2px 10px;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: capitalize;
    }
    .badge-ukpd { background: var(--primary-light); color: var(--primary); border: 1px solid var(--primary-border); }
    .badge-csr { background: #fdf2f8; color: #be185d; border: 1px solid #fbcfe8; }
    .badge-buka, .badge-aktif { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .badge-tutup { background: #fef2f2; color: #b91c1c; border: 1px solid #fecaca; }

    .tag-item {
        background: #f1f5f9;
        color: #334155;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.78rem;
        font-weight: 500;
        border: 1px solid #e2e8f0;
    }

    /* SKOR BADGE HARMONIZED WITH PRIMARY */
    .skor-box {
        background: var(--primary-light);
        border: 1px solid var(--primary-border);
        padding: 0.6rem 1rem;
        border-radius: 12px;
        text-align: center;
        min-width: 90px;
        flex-shrink: 0;
    }
    .skor-number {
        font-size: 1.25rem;
        font-weight: 800;
        color: var(--primary);
        line-height: 1;
    }
    .skor-label {
        font-size: 0.6875rem;
        color: #334155;
        font-weight: 600;
        text-transform: uppercase;
        margin-top: 2px;
        letter-spacing: 0.5px;
    }

    /* RESPONSIVE METRICS GRID */
    .metrics-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
        align-items: start;
        background: #fafafa;
        padding: 1.25rem;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
    }

    .metric-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }
    .metric-label {
        font-size: 0.725rem;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .metric-value {
        font-size: 0.875rem;
        font-weight: 600;
        color: #1e293b;
    }

    /* BUTTONS & FOOTER ACTION */
    .action-container {
        margin-top: 1.25rem;
        display: flex;
        justify-content: flex-end;
    }

    .btn-action {
        background: linear-gradient(135deg, #12395B, #1c527e);
        color: #ffffff;
        padding: 0.65rem 1.25rem;
        border-radius: 10px;
        font-size: 0.875rem;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        transition: all 0.2s ease;
        box-shadow: 0 3px 10px rgba(18, 57, 91, 0.25);
    }
    .btn-action:hover {
        background: linear-gradient(135deg, #0d2a43, #12395B);
        box-shadow: 0 4px 14px rgba(18, 57, 91, 0.35);
        transform: translateY(-1px);
    }

    /* EMPTY STATE */
    .empty-box {
        padding: 4rem 2rem;
        text-align: center;
        color: #64748b;
    }
    .empty-icon {
        width: 64px;
        height: 64px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem auto;
        color: #94a3b8;
    }

    /* MEDIA QUERIES (RESPONSIVE BREAKPOINTS) */
    @media (max-width: 1200px) {
        .grid-layout {
            grid-template-columns: 1fr;
        }
        .metrics-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 640px) {
        .match-card {
            padding: 1rem;
        }
        .match-header {
            flex-direction: column-reverse;
            align-items: flex-start;
            gap: 0.75rem;
        }
        .skor-box {
            align-self: flex-start;
        }
        .metrics-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
            padding: 1rem;
        }
        .action-container {
            width: 100%;
        }
        .btn-action {
            width: 100%;
        }
    }
</style>

<div class="rekomendasi-container">

    <!-- NOTIFIKASI ERROR -->
    @if(session('error'))
        <div class="alert-danger">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    <!-- TOMBOL KEMBALI -->
    <a href="{{ route('admin.rekomendasi.index') }}" class="btn-back">
        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Rekomendasi
    </a>

    <!-- HEADER -->
    <div class="page-header">
        <h1>Rekomendasi Program</h1>
        <p>Analisis pencocokan otomatis berdasarkan keahlian, minat, dan kualifikasi warga.</p>
    </div>

    <!-- GRID UTAMA (FULL WIDTH) -->
    <div class="grid-layout">

        <!-- KOLOM KIRI: PROFIL WARGA -->
        <aside class="custom-card" style="padding: 1.5rem; height: fit-content;">
            <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1.25rem; padding-bottom: 1rem; border-bottom: 1px solid #f1f5f9;">
                <div style="width: 52px; height: 52px; border-radius: 50%; background: linear-gradient(135deg, #12395B, #1c527e); color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.25rem; flex-shrink: 0; box-shadow: 0 4px 12px rgba(18, 57, 91, 0.25);">
                    {{ strtoupper(substr($warga->nama, 0, 1)) }}
                </div>
                <div>
                    <h2 style="font-size: 1.15rem; font-weight: 700; color: #0f172a; margin: 0 0 0.2rem 0;">{{ $warga->nama }}</h2>
                    <span style="font-size: 0.8rem; color: #64748b; font-weight: 500;">Profil Detail Warga</span>
                </div>
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <!-- NIK -->
                <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="padding: 6px; background: #f8fafc; border-radius: 8px; color: #475569; display: flex; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 012-2h2a2 2 0 012 2v1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.725rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">NIK</span>
                        <strong style="font-size: 0.875rem; color: #1e293b; font-family: monospace; letter-spacing: 0.5px;">{{ $warga->nik }}</strong>
                    </div>
                </div>

                <!-- KECAMATAN -->
                <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="padding: 6px; background: #ebf3fa; border-radius: 8px; color: #12395B; display: flex; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.725rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Kecamatan</span>
                        <strong style="font-size: 0.875rem; color: #1e293b;">{{ $warga->kecamatan }}</strong>
                    </div>
                </div>

                <!-- KELURAHAN -->
                <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="padding: 6px; background: #ebf3fa; border-radius: 8px; color: #12395B; display: flex; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.725rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Kelurahan</span>
                        <strong style="font-size: 0.875rem; color: #1e293b;">{{ $warga->kelurahan }}</strong>
                    </div>
                </div>

                <!-- PENDIDIKAN -->
                <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="padding: 6px; background: #eff6ff; border-radius: 8px; color: #1d4ed8; display: flex; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0112 20.055a11.952 11.952 0 01-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.725rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Pendidikan</span>
                        <strong style="font-size: 0.875rem; color: #1e293b;">{{ $warga->pendidikan_terakhir }}</strong>
                    </div>
                </div>

                <!-- STATUS PEKERJAAN -->
                <div style="display: flex; align-items: flex-start; gap: 0.75rem;">
                    <div style="padding: 6px; background: #fff7ed; border-radius: 8px; color: #c2410c; display: flex; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <span style="display: block; font-size: 0.725rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px;">Status Pekerjaan</span>
                        <span style="display: inline-block; margin-top: 3px; padding: 3px 10px; background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; border-radius: 9999px; font-size: 0.78rem; font-weight: 600;">
                            {{ $warga->status_pekerjaan }}
                        </span>
                    </div>
                </div>

                <!-- KEAHLIAN & MINAT -->
                <div style="display: flex; align-items: flex-start; gap: 0.75rem; padding-top: 0.85rem; border-top: 1px dashed #e2e8f0;">
                    <div style="padding: 6px; background: #f3e8ff; border-radius: 8px; color: #7e22ce; display: flex; flex-shrink: 0;">
                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <div style="width: 100%;">
                        <span style="display: block; font-size: 0.725rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem;">Keahlian & Minat</span>
                        <div style="display: flex; flex-wrap: wrap; gap: 0.35rem;">
                            @forelse ($minatWarga as $minat)
                                <span class="tag-item">{{ $minat }}</span>
                            @empty
                                <span style="font-size: 0.8rem; color: #94a3b8; font-style: italic;">Belum diisi</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- KOLOM KANAN: LIST PROGRAM REKOMENDASI -->
        <section class="custom-card">
            <!-- HEAD -->
            <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid #f1f5f9; display: flex; justify-content: space-between; align-items: center; background: #fafafa; flex-wrap: wrap; gap: 0.5rem;">
                <h2 style="font-size: 1.1rem; font-weight: 700; color: #0f172a; margin: 0;">
                    Program Cocok 
                    <span style="background: #ebf3fa; color: #12395B; font-size: 0.8rem; padding: 2px 8px; border-radius: 9999px; margin-left: 0.5rem; font-weight: 600;">
                        {{ $kecocokan->count() }}
                    </span>
                </h2>
                <span style="font-size: 0.8rem; color: #64748b;">Diurutkan dari skor tertinggi</span>
            </div>

            <!-- CONTENT / MATCH LIST -->
            @if ($kecocokan->isEmpty())
                <div class="empty-box">
                    <div class="empty-icon">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 style="font-size: 1rem; font-weight: 700; color: #334155; margin: 0 0 0.5rem 0;">Tidak Ada Program yang Cocok</h3>
                    <p style="font-size: 0.875rem; margin: 0 auto; max-width: 440px; line-height: 1.5;">
                        Periksa kembali keahlian dan minat di profil warga ini, atau tambahkan program pemberdayaan baru yang sesuai.
                    </p>
                </div>
            @else
                <div>
                    @foreach ($kecocokan as $item)
                        @php $program = $item['program']; @endphp
                        <article class="match-card">
                            <!-- HEADER MATCH ITEM -->
                            <div class="match-header">
                                <div>
                                    <h3 class="match-title">{{ $program->nama }}</h3>
                                    <div class="match-meta">
                                        @if ($program->mitra)
                                            <span class="badge-pill badge-{{ strtolower($program->mitra->jenis) }}">
                                                {{ $program->mitra->jenis }}
                                            </span>
                                        @endif
                                        <span>{{ $program->mitra?->nama ?? $program->penyelenggara }}</span>
                                        <span>&middot;</span>
                                        <span style="display: flex; align-items: center; gap: 3px;">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                            {{ $program->lokasi }}
                                        </span>
                                    </div>
                                </div>
                                <div class="skor-box">
                                    <div class="skor-number">{{ $item['skor'] }}%</div>
                                    <div class="skor-label">Kecocokan</div>
                                </div>
                            </div>

                            <!-- METRICS GRID -->
                            <div class="metrics-grid">
                                <div class="metric-item">
                                    <span class="metric-label">Kriteria Match</span>
                                    <div style="display: flex; flex-wrap: wrap; gap: 0.25rem; margin-top: 2px;">
                                        @foreach ($item['kriteria_cocok'] as $kriteria)
                                            <span class="tag-item">{{ $kriteria }}</span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="metric-item">
                                    <span class="metric-label">Jadwal Pelaksanaan</span>
                                    <span class="metric-value">
                                        {{ $program->tanggal_mulai->format('d M') }} – {{ $program->tanggal_selesai->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="metric-item">
                                    <span class="metric-label">Sisa Kuota</span>
                                    <span class="metric-value">
                                        <strong style="color: #12395B;">{{ $program->sisa_kuota }}</strong> / {{ $program->kuota }} Kursi
                                    </span>
                                </div>

                                <div class="metric-item">
                                    <span class="metric-label">Status Program</span>
                                    <div>
                                        <span class="badge-pill badge-{{ strtolower($program->status) }}">
                                            {{ $program->status }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- FOOTER / ACTION BUTTON -->
                            <div class="action-container">
                                <form action="{{ route('penempatan.store') }}" method="POST" style="width: 100%; display: flex; justify-content: flex-end;">
                                    @csrf
                                    <input type="hidden" name="masyarakat_id" value="{{ $warga->id }}">
                                    <input type="hidden" name="program_id" value="{{ $program->id }}">
                                    <input type="hidden" name="status" value="Seleksi"> 
                                    <input type="hidden" name="tanggal_penempatan" value="{{ now()->format('Y-m-d') }}">

                                    <button type="submit" 
                                            class="btn-action"
                                            onclick="return confirm('Tempatkan {{ $warga->nama }} ke program {{ $program->nama }} secara langsung?')">
                                        <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                        Tempatkan Langsung
                                    </button>
                                </form>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </section>

    </div>
</div>
@endsection