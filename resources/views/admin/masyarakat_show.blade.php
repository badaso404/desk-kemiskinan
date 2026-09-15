@extends('layouts.admin')

@section('title', 'Detail Masyarakat - ' . $masyarakat->nama)

@section('content')
<style>
    .detail-container { width: 100%; margin: 0 auto; box-sizing: border-box; }
    .btn-back { display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; font-size: 0.875rem; font-weight: 600; text-decoration: none; }
    .btn-back:hover { color: #12395B; }
    
    .detail-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.25rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .action-buttons-group {
        display: flex;
        gap: 0.6rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .detail-grid { display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start; }
    .custom-card { background: #fff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 20px -2px rgba(0,0,0,0.03); overflow: hidden; padding: 1.5rem; box-sizing: border-box; }
    .section-title { font-size: 1rem; font-weight: 700; color: #12395B; margin-bottom: 1rem; padding-bottom: 0.5rem; border-bottom: 2px solid #ebf3fa; display: flex; align-items: center; justify-content: space-between; }
    
    .info-list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; margin-bottom: 1.5rem; }
    .info-item { display: flex; flex-direction: column; gap: 0.2rem; }
    .info-item.full-width { grid-column: 1 / -1; }
    .info-label { font-size: 0.725rem; color: #94a3b8; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 0.875rem; font-weight: 600; color: #1e293b; word-break: break-word; }
    
    .tag-pill { background: #ebf3fa; color: #12395B; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 500; border: 1px solid #b9d3eb; display: inline-block; margin: 2px 2px 2px 0; }
    
    /* AKSI BUTTONS DI DETAIL */
    .btn-action-edit {
        background-color: #12395B;
        color: #ffffff;
        padding: 0.55rem 1.1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: background-color 0.2s ease;
    }
    .btn-action-edit:hover { background-color: #0d2a43; color: #ffffff; }

    .btn-action-delete {
        background-color: #fef2f2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        padding: 0.55rem 1.1rem;
        border-radius: 8px;
        font-size: 0.85rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.4rem;
        transition: background-color 0.2s ease;
    }
    .btn-action-delete:hover { background-color: #fee2e2; }

    /* MEDIA QUERIES RESPONSIVE */
    @media (max-width: 1024px) {
        .detail-grid { grid-template-columns: 1fr; }
    }

    @media (max-width: 640px) {
        .detail-header-bar { flex-direction: column; align-items: stretch; }
        .action-buttons-group { width: 100%; }
        .action-buttons-group a, .action-buttons-group form, .action-buttons-group button { flex: 1; width: 100%; }
        .info-list { grid-template-columns: 1fr; }
        .info-item { grid-column: span 1 !important; }
        .custom-card { padding: 1.25rem; }
    }
</style>

<div class="detail-container">
    <!-- BAR NAVIGASI ATAS & AKSI -->
    <div class="detail-header-bar">
        <a href="{{ route('admin.masyarakat') }}" class="btn-back">
            &larr; Kembali ke Data Masyarakat
        </a>

        <!-- TOMBOL EDIT & HAPUS -->
        <div class="action-buttons-group">
            <a href="{{ route('admin.masyarakat.edit', $masyarakat->id) }}" class="btn-action-edit">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Ubah Data
            </a>

            <form action="{{ route('admin.masyarakat.destroy', $masyarakat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $masyarakat->nama }}?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-action-delete">
                    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Hapus Data
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <!-- KARTU PROFIL RINGKAS -->
        <div class="custom-card" style="text-align: center;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #12395B, #1c527e); color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 2rem; margin: 0 auto 1rem auto; box-shadow: 0 4px 12px rgba(18, 57, 91, 0.25);">
                {{ strtoupper(substr($masyarakat->nama, 0, 1)) }}
            </div>
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #0f172a; margin: 0 0 0.25rem 0;">{{ $masyarakat->nama }}</h2>
            <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 1rem 0;">NIK: {{ $masyarakat->nik }}</p>
            
            <span style="display: inline-block; padding: 6px 14px; background: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; border-radius: 9999px; font-size: 0.8rem; font-weight: 600;">
                {{ $masyarakat->status_pekerjaan }}
            </span>

            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; text-align: left;">
                <div class="info-item" style="margin-bottom: 0.8rem;">
                    <span class="info-label">Telepon / WhatsApp</span>
                    <span class="info-value">{{ $masyarakat->telepon }}</span>
                </div>
                <div class="info-item" style="margin-bottom: 0.8rem;">
                    <span class="info-label">Kecamatan</span>
                    <span class="info-value">{{ $masyarakat->kecamatan }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Kelurahan</span>
                    <span class="info-value">{{ $masyarakat->kelurahan }}</span>
                </div>
            </div>
        </div>

        <!-- DETAIL DATA LENGKAP -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            <!-- INFORMASI PRIBADI & ALAMAT -->
            <div class="custom-card">
                <div class="section-title">Informasi Pribadi & Domisili</div>
                <div class="info-list">
                    <div class="info-item"><span class="info-label">Jenis Kelamin</span><span class="info-value">{{ $masyarakat->jenis_kelamin }}</span></div>
                    <div class="info-item"><span class="info-label">Tanggal Lahir</span><span class="info-value">{{ \Carbon\Carbon::parse($masyarakat->tanggal_lahir)->format('d F Y') }}</span></div>
                    <div class="info-item full-width"><span class="info-label">Alamat Lengkap</span><span class="info-value">{{ $masyarakat->alamat }}</span></div>
                </div>
            </div>

            <!-- KONDISI EKONOMI & DTKS -->
            <div class="custom-card">
                <div class="section-title">Kondisi Sosial & Ekonomi</div>
                <div class="info-list">
                    <div class="info-item"><span class="info-label">Status DTKS</span><span class="info-value">{{ $masyarakat->status_dtks ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-label">Pendapatan Bulanan</span><span class="info-value">{{ $masyarakat->pendapatan_bulanan ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-label">Jumlah Tanggungan</span><span class="info-value">{{ $masyarakat->jumlah_tanggungan }} Orang</span></div>
                    <div class="info-item"><span class="info-label">Status Kepemilikan Rumah</span><span class="info-value">{{ $masyarakat->status_rumah ?? '-' }}</span></div>
                </div>
            </div>

            <!-- PENDIDIKAN & KEAHLIAN -->
            <div class="custom-card">
                <div class="section-title">Pendidikan, Keahlian & Minat</div>
                <div class="info-list">
                    <div class="info-item"><span class="info-label">Pendidikan Terakhir</span><span class="info-value">{{ $masyarakat->pendidikan_terakhir }}</span></div>
                    <div class="info-item"><span class="info-label">Jurusan</span><span class="info-value">{{ $masyarakat->jurusan ?? '-' }}</span></div>
                    <div class="info-item full-width">
                        <span class="info-label" style="margin-bottom: 0.4rem;">Keahlian yang Dimiliki</span>
                        <div>
                            @foreach (explode(',', $masyarakat->keahlian) as $skill)
                                <span class="tag-pill">{{ trim($skill) }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label" style="margin-bottom: 0.4rem;">Minat Pelatihan</span>
                        <div>
                            @if($masyarakat->minat_pelatihan)
                                @foreach (explode(',', $masyarakat->minat_pelatihan) as $minat)
                                    <span class="tag-pill" style="background: #fdf2f8; color: #be185d; border-color: #fbcfe8;">{{ trim($minat) }}</span>
                                @endforeach
                            @else
                                <span style="font-size: 0.85rem; color: #94a3b8; font-style: italic;">Belum diisi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT KERJA -->
            <div class="custom-card">
                <div class="section-title">Pengalaman & Rencana Pekerjaan</div>
                <div class="info-list">
                    <div class="info-item"><span class="info-label">Pengalaman Terakhir</span><span class="info-value">{{ $masyarakat->pengalaman_terakhir ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-label">Lama Pengalaman</span><span class="info-value">{{ $masyarakat->lama_pengalaman ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-label">Lama Menganggur</span><span class="info-value">{{ $masyarakat->lama_menganggur ?? '-' }}</span></div>
                    <div class="info-item"><span class="info-label">Tipe Pekerjaan Dicari</span><span class="info-value">{{ $masyarakat->tipe_pekerjaan_dicari ?? '-' }}</span></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection