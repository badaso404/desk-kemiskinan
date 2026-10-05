@extends('layouts.admin')

@section('title', 'Detail Warga - ' . $masyarakat->nama)

@section('content')
<style>
    /* BASE NEUTRALS & LAYOUT */
    .detail-container { width: 100%; margin: 0 auto; box-sizing: border-box; font-family: sans-serif; }
    .btn-back { display: inline-flex; align-items: center; gap: 0.5rem; color: #64748b; font-size: 0.875rem; font-weight: 600; text-decoration: none; transition: color 0.2s; }
    .btn-back:hover { color: #12395B; }
    
    .detail-header-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; flex-wrap: wrap; gap: 1rem; }
    .action-buttons-group { display: flex; gap: 0.6rem; align-items: center; flex-wrap: wrap; }
    .detail-grid { display: grid; grid-template-columns: 320px 1fr; gap: 1.5rem; align-items: start; }
    
    .custom-card { background: #fff; border-radius: 12px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); overflow: hidden; padding: 1.5rem; box-sizing: border-box; }
    .section-title { font-size: 0.95rem; font-weight: 700; color: #12395B; margin-bottom: 1rem; padding-bottom: 0.6rem; border-bottom: 2px solid #ebf3fa; display: flex; align-items: center; justify-content: space-between; }
    
    .info-list { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.2rem 1rem; }
    .info-item { display: flex; flex-direction: column; gap: 0.25rem; }
    .info-item.full-width { grid-column: 1 / -1; }
    .info-label { font-size: 0.725rem; color: #64748b; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 0.9rem; font-weight: 600; color: #1e293b; word-break: break-word; }
    
    /* --- COLOR PALETTE (3 MAIN COLORS) --- */
    
    /* 1. NAVY BLUE (Primary/Info) */
    .tag-pill { background: #ebf3fa; color: #12395B; border: 1px solid #b9d3eb; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; display: inline-block; margin: 2px 4px 4px 0; }
    .badge-info { background: #ebf3fa; color: #12395B; border: 1px solid #b9d3eb; padding: 4px 12px; border-radius: 9999px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem; }
    .btn-action-reco { background-color: #12395B; color: #ffffff; border: 1px solid #12395B; padding: 0.55rem 1.1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: background-color 0.2s; }
    .btn-action-reco:hover { background-color: #0d2a43; }
    .btn-action-edit { background-color: #ffffff; color: #12395B; border: 1px solid #12395B; padding: 0.55rem 1.1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 0.4rem; transition: background-color 0.2s; }
    .btn-action-edit:hover { background-color: #ebf3fa; }

    /* 2. EMERALD GREEN (Success/Verify) */
    .tag-pill-success { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 10px; border-radius: 6px; font-size: 0.78rem; font-weight: 600; display: inline-block; margin: 2px 4px 4px 0; }
    .badge-success { background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; padding: 4px 12px; border-radius: 9999px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem; }
    .btn-action-verify { background-color: #059669; color: #ffffff; padding: 0.75rem 1.5rem; border-radius: 8px; font-size: 0.925rem; font-weight: 700; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: background-color 0.2s; }
    .btn-action-verify:hover { background-color: #047857; }

    /* 3. CRIMSON RED (Danger/Warning) */
    .badge-danger { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 4px 12px; border-radius: 9999px; font-size: 0.78rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.35rem; }
    .btn-action-delete { background-color: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 0.55rem 1.1rem; border-radius: 8px; font-size: 0.85rem; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 0.4rem; transition: background-color 0.2s; }
    .btn-action-delete:hover { background-color: #fee2e2; }

    /* NEUTRAL BADGE */
    .badge-neutral { background: #f1f5f9; color: #64748b; border: 1px solid #e2e8f0; padding: 4px 12px; border-radius: 9999px; font-size: 0.78rem; font-weight: 600; display: inline-flex; }

    /* MODAL POPUP CONFIRMATION STYLING */
    .modal-backdrop { position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px); display: none; align-items: center; justify-content: center; z-index: 9999; }
    .modal-card { background: #ffffff; border-radius: 16px; padding: 1.75rem; max-width: 420px; width: 90%; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); box-sizing: border-box; }
    .modal-icon-warning { width: 48px; height: 48px; border-radius: 50%; background: #ecfdf5; color: #059669; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; }
    .modal-title { font-size: 1.15rem; font-weight: 700; color: #1e293b; margin: 0 0 0.5rem 0; }
    .modal-desc { font-size: 0.9rem; color: #64748b; line-height: 1.5; margin-bottom: 1.5rem; }
    .modal-actions { display: flex; gap: 0.75rem; justify-content: flex-end; }
    
    .btn-modal-cancel { background: #f1f5f9; color: #475569; border: none; padding: 0.65rem 1.25rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem; cursor: pointer; transition: background-color 0.2s; }
    .btn-modal-cancel:hover { background: #e2e8f0; }

    /* MEDIA QUERIES RESPONSIVE */
    @media (max-width: 1024px) { .detail-grid { grid-template-columns: 1fr; } }
    @media (max-width: 640px) {
        .detail-header-bar { flex-direction: column; align-items: stretch; }
        .action-buttons-group { width: 100%; }
        .action-buttons-group a, .action-buttons-group form, .action-buttons-group button { flex: 1; width: 100%; justify-content: center; }
        .info-list { grid-template-columns: 1fr; }
        .info-item { grid-column: span 1 !important; }
    }
</style>

<div class="detail-container">
    <!-- BAR NAVIGASI ATAS & AKSI -->
    <div class="detail-header-bar">
        <a href="{{ route('admin.masyarakat') }}" class="btn-back">
            &larr; Kembali ke Data Masyarakat
        </a>

        <!-- TOMBOL AKSI: REKOMENDASI, EDIT & HAPUS -->
        <div class="action-buttons-group">
            <a href="{{ route('admin.rekomendasi.show', $masyarakat->id) }}" class="btn-action-reco">
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                Rekomendasi Program
            </a>

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
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="detail-grid">
        <!-- KARTU PROFIL RINGKAS (SISI KIRI) -->
        <div class="custom-card" style="text-align: center;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background-color: #12395B; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 2rem; margin: 0 auto 1rem auto; box-shadow: 0 4px 12px rgba(18, 57, 91, 0.2);">
                {{ strtoupper(substr($masyarakat->nama, 0, 1)) }}
            </div>
            
            <h2 style="font-size: 1.25rem; font-weight: 700; color: #1e293b; margin: 0 0 0.25rem 0;">{{ $masyarakat->nama }}</h2>
            <p style="font-size: 0.85rem; color: #64748b; margin: 0 0 1rem 0;">NIK: {{ $masyarakat->nik }}</p>
            
            <!-- BADGE STATUS VERIFIKASI -->
            <div style="margin-bottom: 0.75rem;">
                @if(($masyarakat->status_verifikasi ?? '') === 'Terverifikasi')
                    <span class="badge-success">Sudah Terverifikasi</span>
                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 0.4rem;">
                        Tgl Verifikasi: {{ \Carbon\Carbon::parse($masyarakat->tanggal_verifikasi ?? $masyarakat->updated_at)->format('d/m/Y') }}
                    </div>
                @else
                    <span class="badge-danger">Belum Terverifikasi</span>
                @endif
            </div>

            <!-- TAMPILAN INFORMASI DESIL -->
            <div style="margin-bottom: 0.75rem;">
                @if(!empty($masyarakat->desil))
                    <span class="badge-info">Desil {{ $masyarakat->desil }}</span>
                @else
                    <span class="badge-neutral">Desil Belum Diisi</span>
                @endif
            </div>

            <!-- BADGE STATUS PEKERJAAN -->
            <span class="badge-info">{{ $masyarakat->status_pekerjaan }}</span>

            <div style="margin-top: 1.5rem; padding-top: 1.25rem; border-top: 1px solid #e2e8f0; text-align: left;">
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

        <!-- DETAIL DATA LENGKAP (SISI KANAN) -->
        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
            
            <!-- INFORMASI PRIBADI & ALAMAT -->
            <div class="custom-card">
                <div class="section-title">Informasi Pribadi & Domisili</div>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Jenis Kelamin</span>
                        <span class="info-value">{{ $masyarakat->jenis_kelamin }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Tanggal Lahir</span>
                        <span class="info-value">
                            {{ $masyarakat->tanggal_lahir ? \Carbon\Carbon::parse($masyarakat->tanggal_lahir)->format('d F Y') : '-' }}
                        </span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Alamat Lengkap</span>
                        <span class="info-value">{{ $masyarakat->alamat }}</span>
                    </div>
                </div>
            </div>

            <!-- KONDISI EKONOMI & DTKS / BANTUAN -->
            <div class="custom-card">
                <div class="section-title">Kondisi Sosial & Ekonomi</div>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Status DTKS / P3KE</span>
                        <span class="info-value">{{ $masyarakat->status_dtks ?: '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Pendapatan Bulanan</span>
                        <span class="info-value">{{ $masyarakat->pendapatan_bulanan ?: '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jumlah Tanggungan</span>
                        <span class="info-value">{{ $masyarakat->jumlah_tanggungan ?? 0 }} Orang</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Status Kepemilikan Rumah</span>
                        <span class="info-value">{{ $masyarakat->status_rumah ?: '-' }}</span>
                    </div>

                    <!-- BANTUAN SOSIAL DITERIMA -->
                    <div class="info-item full-width">
                        <span class="info-label" style="margin-bottom: 0.4rem;">Bantuan Sosial yang Diterima</span>
                        <div>
                            @php
                                $bantuanList = is_array($masyarakat->bantuan) 
                                    ? $masyarakat->bantuan 
                                    : array_filter(explode(',', $masyarakat->bantuan ?? ''));
                            @endphp

                            @forelse ($bantuanList as $bantuan)
                                <span class="tag-pill-success">{{ trim($bantuan) }}</span>
                            @empty
                                <span style="font-size: 0.85rem; color: #64748b; font-style: italic;">Tidak menerima bantuan sosial</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- PENDIDIKAN, KEAHLIAN & SERTIFIKASI -->
            <div class="custom-card">
                <div class="section-title">Pendidikan, Keahlian & Minat</div>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Pendidikan Terakhir</span>
                        <span class="info-value">{{ $masyarakat->pendidikan_terakhir }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Jurusan / Program Studi</span>
                        <span class="info-value">{{ $masyarakat->jurusan ?: '-' }}</span>
                    </div>

                    <!-- KEAHLIAN -->
                    <div class="info-item full-width">
                        <span class="info-label" style="margin-bottom: 0.4rem;">Keahlian yang Dimiliki</span>
                        <div>
                            @php
                                $keahlianList = is_array($masyarakat->keahlian) 
                                    ? $masyarakat->keahlian 
                                    : array_filter(explode(',', $masyarakat->keahlian ?? ''));
                            @endphp

                            @forelse ($keahlianList as $skill)
                                <span class="tag-pill">{{ trim($skill) }}</span>
                            @empty
                                <span style="font-size: 0.85rem; color: #64748b; font-style: italic;">Tidak ada keahlian khusus yang dicantumkan</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- SERTIFIKAT -->
                    <div class="info-item full-width">
                        <span class="info-label" style="margin-bottom: 0.4rem;">Sertifikat yang Dimiliki</span>
                        <div>
                            @php
                                $sertifikatList = is_array($masyarakat->sertifikat) 
                                    ? $masyarakat->sertifikat 
                                    : array_filter(explode(',', $masyarakat->sertifikat ?? ''));
                            @endphp

                            @forelse ($sertifikatList as $sertifikat)
                                <span class="tag-pill-success">📜 {{ trim($sertifikat) }}</span>
                            @empty
                                <span style="font-size: 0.85rem; color: #64748b; font-style: italic;">Belum memiliki sertifikat</span>
                            @endforelse
                        </div>
                    </div>

                    <!-- MINAT PELATIHAN -->
                    <div class="info-item full-width">
                        <span class="info-label" style="margin-bottom: 0.4rem;">Minat Pelatihan</span>
                        <div>
                            @php
                                $minatList = is_array($masyarakat->minat_pelatihan) 
                                    ? $masyarakat->minat_pelatihan 
                                    : array_filter(explode(',', $masyarakat->minat_pelatihan ?? ''));
                            @endphp

                            @forelse ($minatList as $minat)
                                <span class="tag-pill">{{ trim($minat) }}</span>
                            @empty
                                <span style="font-size: 0.85rem; color: #64748b; font-style: italic;">Belum diisi</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIWAYAT KERJA & KEBUTUHAN -->
            <div class="custom-card">
                <div class="section-title">Pengalaman Kerja & Rencana Pekerjaan</div>
                <div class="info-list">
                    <div class="info-item">
                        <span class="info-label">Pengalaman Terakhir</span>
                        <span class="info-value">{{ $masyarakat->pengalaman_terakhir ?: '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lama Pengalaman</span>
                        <span class="info-value">{{ $masyarakat->lama_pengalaman ?: '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Lama Menganggur</span>
                        <span class="info-value">{{ $masyarakat->lama_menganggur ?: '-' }}</span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Alasan Tidak Bekerja</span>
                        <span class="info-value">{{ $masyarakat->alasan_tidak_bekerja ?: '-' }}</span>
                    </div>
                    <div class="info-item full-width">
                        <span class="info-label">Tipe Pekerjaan / Penempatan Dicari</span>
                        <span class="info-value">{{ $masyarakat->tipe_pekerjaan_dicari ?: '-' }}</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- FORM DISIMPAN SECARA HIDDEN UNTUK EKSEKUSI VERIFIKASI -->
<form id="verifyFormSubmit" action="{{ route('admin.masyarakat.verify', $masyarakat->id) }}" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>

<!-- MODAL ALERT PERINGATAN KONFIRMASI VERIFIKASI -->
<div class="modal-backdrop" id="verifyModal">
    <div class="modal-card">
        <div class="modal-icon-warning">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h3 class="modal-title">Konfirmasi Verifikasi Data</h3>
        <p class="modal-desc">
            Apakah Anda yakin ingin memverifikasi data atas nama <strong>{{ $masyarakat->nama }}</strong> (NIK: {{ $masyarakat->nik }})?
            <br><br>
            Setelah diverifikasi, status data akan berubah menjadi <strong>Terverifikasi</strong>.
        </p>
        <div class="modal-actions">
            <button type="button" class="btn-modal-cancel" onclick="closeVerifyModal()">Batal</button>
            <button type="button" class="btn-action-verify" onclick="submitVerifyForm()">Verifikasi</button>
        </div>
    </div>
</div>

<!-- SCRIPT UNTUK MODAL POPUP KONFIRMASI -->
<script>
    function openVerifyModal() {
        document.getElementById('verifyModal').style.display = 'flex';
    }

    function closeVerifyModal() {
        document.getElementById('verifyModal').style.display = 'none';
    }

    function submitVerifyForm() {
        document.getElementById('verifyFormSubmit').submit();
    }

    // Menutup modal jika user mengeklik di luar kotak modal
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('verifyModal');
        if (event.target === modal) {
            closeVerifyModal();
        }
    });
</script>
@endsection