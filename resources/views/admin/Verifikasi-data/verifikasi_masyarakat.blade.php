@extends('layouts.admin')

@section('title', 'Verifikasi Data Masyarakat')

@section('content')
<style>
    .verify-container { width: 100%; margin: 0 auto; box-sizing: border-box; }
    
    .page-header { margin-bottom: 1.5rem; }
    .page-title { font-size: 1.5rem; font-weight: 700; color: #12395B; margin: 0 0 0.25rem 0; }
    .page-subtitle { font-size: 0.875rem; color: #64748b; margin: 0; }

    /* STATS CARDS */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
        margin-bottom: 1.5rem;
    }
    .stat-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.25rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.02);
    }
    .stat-label { font-size: 0.8rem; font-weight: 600; color: #64748b; margin-bottom: 0.5rem; }
    .stat-value { font-size: 1.75rem; font-weight: 700; color: #12395B; }

    /* LAYOUT DUA KOLOM */
    .verify-grid {
        display: grid;
        grid-template-columns: 360px 1fr;
        gap: 1.5rem;
        align-items: start;
    }

    .custom-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 4px 20px -2px rgba(0,0,0,0.03);
        padding: 1.5rem;
        box-sizing: border-box;
    }

    .card-title {
        font-size: 1rem;
        font-weight: 700;
        color: #12395B;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #ebf3fa;
    }

    /* SEARCH & LIST ITEM */
    .search-input {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.85rem;
        outline: none;
        box-sizing: border-box;
        margin-bottom: 1rem;
    }
    .search-input:focus { border-color: #12395B; }

    .citizen-list {
        display: flex;
        flex-direction: column;
        gap: 0.6rem;
        max-height: 600px;
        overflow-y: auto;
    }

    .citizen-item {
        padding: 0.85rem 1rem;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        display: block;
    }
    .citizen-item:hover { background-color: #f8fafc; border-color: #cbd5e1; }
    .citizen-item.active {
        background-color: #ebf3fa;
        border-color: #12395B;
    }

    .citizen-item-name { font-size: 0.9rem; font-weight: 700; color: #0f172a; margin-bottom: 0.2rem; }
    .citizen-item-nik { font-size: 0.78rem; color: #64748b; }

    .badge-status { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 9999px; font-size: 0.725rem; font-weight: 700; margin-top: 0.4rem; }
    .badge-pending { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }
    .badge-verified { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }

    /* DETAIL DATA DISPLAY */
    .info-section {
        background-color: #f8fafc;
        border-radius: 12px;
        padding: 1.25rem;
        margin-bottom: 1.5rem;
        border: 1px solid #f1f5f9;
    }
    .info-section-title {
        font-size: 0.85rem;
        font-weight: 700;
        color: #12395B;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 0.85rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 0.85rem 1.25rem;
    }
    .info-item { display: flex; flex-direction: column; }
    .info-label { font-size: 0.75rem; color: #64748b; font-weight: 600; margin-bottom: 0.15rem; }
    .info-value { font-size: 0.875rem; color: #1e293b; font-weight: 600; }

    /* FORM INPUTS */
    .form-group { margin-bottom: 1.25rem; }
    .form-label { display: block; font-size: 0.8rem; font-weight: 700; color: #334155; margin-bottom: 0.4rem; }
    .form-control {
        width: 100%;
        padding: 0.65rem 0.85rem;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 0.875rem;
        color: #1e293b;
        box-sizing: border-box;
        outline: none;
    }
    .form-control:focus { border-color: #12395B; }
    .form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1rem; }

    /* BUTTONS */
    .btn-submit {
        background-color: #12395B;
        color: #ffffff;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-size: 0.875rem;
        font-weight: 700;
        border: none;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .btn-submit:hover { background-color: #0d273f; }

    @media (max-width: 1024px) {
        .verify-grid { grid-template-columns: 1fr; }
        .stats-grid { grid-template-columns: 1fr; }
        .info-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="verify-container">
    
    <!-- PAGE HEADER -->
    <div class="page-header">
        <h1 class="page-title">Verifikasi Data Masyarakat</h1>
        <p class="page-subtitle">Tinjau informasi detail dan lakukan verifikasi data masyarakat yang baru terdaftar.</p>
    </div>

    <!-- CARDS SUMMARY -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-label">Total Registered Data</div>
            <div class="stat-value">{{ $ringkasan['total_masyarakat'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Belum Terverifikasi</div>
            <div class="stat-value" style="color: #d97706;">{{ $ringkasan['belum_verifikasi'] ?? 0 }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sudah Terverifikasi</div>
            <div class="stat-value" style="color: #059669;">{{ $ringkasan['terverifikasi'] ?? 0 }}</div>
        </div>
    </div>

    <!-- LAYOUT UTAMA 2 KOLOM -->
    <div class="verify-grid">
        
        <!-- KOLOM KIRI: LIST MASYARAKAT BELUM DIVERIFIKASI -->
        <div class="custom-card">
            <div class="card-title" style="display: flex; justify-content: space-between; align-items: center;">
                <span>Belum Diverifikasi</span>
                <span class="badge-status badge-pending">{{ $masyarakatList->count() }} Data</span>
            </div>
            
            <input type="text" id="searchCitizen" class="search-input" placeholder="Cari nama atau NIK..." onkeyup="filterCitizens()">

            <div class="citizen-list" id="citizenListContainer">
                @forelse ($masyarakatList as $index => $item)
                    @php
                        $isSelected = isset($selectedMasyarakat) && ($selectedMasyarakat->id == $item->id);
                    @endphp
                    <a href="{{ route('admin.Verifikasi-data.verifikasi_masyarakat', ['id' => $item->id]) }}" 
                        class="citizen-item citizen-card-item {{ $isSelected ? 'active' : '' }}"
                        data-search="{{ strtolower($item->nama . ' ' . $item->nik) }}">
                            <div class="citizen-item-name">{{ $item->nama }}</div>
                            <div class="citizen-item-nik">NIK: {{ $item->nik }}</div>
                            <!-- badge & kecamatan -->
                    </a>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 2.5rem 0; font-size: 0.85rem;">
                        Semua data masyarakat telah terverifikasi!
                    </div>
                @endforelse
            </div>
        </div>

        <!-- KOLOM KANAN: DETAIL DATA MASYARAKAT & FORM VERIFIKASI -->
        <div class="custom-card">
            @if(isset($selectedMasyarakat))
                <div class="card-title" style="display: flex; justify-content: space-between; align-items: center;">
                    <span>Detail Informasi: {{ $selectedMasyarakat->nama }}</span>
                    <span style="font-size: 0.825rem; color: #64748b;">NIK: {{ $selectedMasyarakat->nik }}</span>
                </div>

                <!-- SECTION 1: INFORMASI DATA MASYARAKAT -->
                <div class="info-section">
                    <div class="info-section-title">
                        Data Pribadi & Kontak
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Nama Lengkap</span>
                            <span class="info-value">{{ $selectedMasyarakat->nama }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jenis Kelamin / Tanggal Lahir</span>
                            <span class="info-value">{{ $selectedMasyarakat->jenis_kelamin }} ({{ \Carbon\Carbon::parse($selectedMasyarakat->tanggal_lahir)->format('d/m/Y') }})</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. Telepon / WhatsApp</span>
                            <span class="info-value">{{ $selectedMasyarakat->telepon }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Wilayah (Kecamatan / Kelurahan)</span>
                            <span class="info-value">{{ $selectedMasyarakat->kecamatan }}, {{ $selectedMasyarakat->kelurahan }}</span>
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <span class="info-label">Alamat Lengkap</span>
                            <span class="info-value">{{ $selectedMasyarakat->alamat }}</span>
                        </div>
                    </div>
                </div>

                <div class="info-section">
                    <div class="info-section-title">
                        Pekerjaan, Pendidikan & Keahlian
                    </div>
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">Status Pekerjaan</span>
                            <span class="info-value">{{ $selectedMasyarakat->status_pekerjaan }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Pendidikan Terakhir</span>
                            <span class="info-value">{{ $selectedMasyarakat->pendidikan_terakhir }} {{ $selectedMasyarakat->jurusan ? '('.$selectedMasyarakat->jurusan.')' : '' }}</span>
                        </div>
                        <div class="info-item" style="grid-column: span 2;">
                            <span class="info-label">Keahlian utama</span>
                            <span class="info-value">{{ $selectedMasyarakat->keahlian }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status DTKS</span>
                            <span class="info-value">{{ $selectedMasyarakat->status_dtks ?? '-' }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jumlah Tanggungan</span>
                            <span class="info-value">{{ $selectedMasyarakat->jumlah_tanggungan ?? 0 }} Orang</span>
                        </div>
                    </div>
                </div>

                <!-- SECTION 2: FORM VERIFIKASI DATA -->
                <form action="{{ route('admin.Verifikasi-data.verifikasi_masyarakat.update', $selectedMasyarakat->id) }}" method="POST" style="margin-top: 1.5rem;">
                    @csrf
                    @method('PUT')

                    <div class="card-title" style="font-size: 0.9rem; border-bottom: none; margin-bottom: 0.5rem; padding-bottom: 0;">
                        Formulir Verifikasi Status Data
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Tanggal Verifikasi <span style="color: #ef4444;">*</span></label>
                            <input type="date" name="tanggal_verifikasi" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Status Verifikasi <span style="color: #ef4444;">*</span></label>
                            <select name="status_verifikasi" class="form-control" required>
                                <option value="Pending" {{ ($selectedMasyarakat->status_verifikasi ?? '') === 'Pending' ? 'selected' : '' }}>Pending / Belum Terverifikasi</option>
                                <option value="Terverifikasi" {{ ($selectedMasyarakat->status_verifikasi ?? '') === 'Terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Catatan Verifikasi</label>
                        <textarea name="catatan_verifikasi" rows="3" class="form-control" placeholder="Tambahkan catatan verifikasi data masyarakat (contoh: Dokumen NIK dan domisili valid)..."></textarea>
                    </div>

                    <div style="display: flex; gap: 0.75rem; align-items: center; margin-top: 1.5rem; pt-1rem; border-top: 1px solid #f1f5f9;">
                        <button type="submit" class="btn-submit">
                            Simpan Hasil Verifikasi
                        </button>
                    </div>
                </form>
            @else
                <div style="text-align: center; color: #94a3b8; padding: 4rem 0;">
                    <p style="font-size: 0.9rem;">Pilih data warga di sebelah kiri untuk melihat detail dan melakukan verifikasi.</p>
                </div>
            @endif
        </div>

    </div>
</div>

<script>
    function filterCitizens() {
        const query = document.getElementById('searchCitizen').value.toLowerCase();
        const items = document.querySelectorAll('.citizen-card-item');

        items.forEach(item => {
            const searchText = item.getAttribute('data-search');
            if (searchText.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection