@extends('layouts.admin')

@section('title', 'Data Masyarakat')

@section('content')
<style>
    .page-head-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; gap: 1rem; flex-wrap: wrap; }
    .btn-primary { 
        background-color: #12395B; 
        color: #ffffff; 
        padding: 0.6rem 1.2rem; 
        border-radius: 8px; 
        text-decoration: none; 
        font-weight: 500; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center;
        gap: 0.5rem; 
        transition: background-color 0.2s ease, transform 0.1s ease;
    }
    .btn-primary:hover { 
        background-color: #0d2a43;
        color: #ffffff; 
    }
    .btn-secondary { background-color: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 0.55rem 1rem; border-radius: 8px; cursor: pointer; font-weight: 500; display: inline-flex; justify-content: center; align-items: center; }
    .btn-secondary:hover { background-color: #e2e8f0; }
    .btn-reset { color: #b91c1c; text-decoration: none; font-size: 0.875rem; padding: 0.55rem 0.75rem; border-radius: 8px; display: inline-flex; align-items: center; justify-content: center; }
    .btn-reset:hover { background-color: #fef2f2; }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .alert-error { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .card-footer { padding: 1rem 1.25rem; border-top: 1px solid #e2e8f0; }
    .btn-icon { background: transparent; border: none; padding: 6px; cursor: pointer; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; }
    .btn-icon:hover { background: #ebf3fa; }

    /* BADGE STATUS VERIFIKASI */
    .badge-status { display: inline-flex; align-items: center; gap: 0.35rem; padding: 4px 10px; border-radius: 9999px; font-size: 0.78rem; font-weight: 600; }
    .badge-verified { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .badge-pending { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }

    /* STAT GRID RESPONSIVE */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .card-filter { margin-bottom: 1.5rem; padding: 1.25rem; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .filter-grid { display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: center; }
    .form-control { width: 100%; padding: 0.6rem 0.85rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; outline: none; box-sizing: border-box; background-color: #fff; }
    .form-control:focus { border-color: #12395B; box-shadow: 0 0 0 3px rgba(18, 57, 91, 0.15); }

    .table-scroll { width: 100%; overflow-x: auto; -webkit-overflow-scrolling: touch; }
    .data-table { width: 100%; min-width: 650px; }

    /* BREAKPOINTS MEDIA QUERIES */
    @media (max-width: 1024px) {
        .stat-grid { grid-template-columns: repeat(2, 1fr); }
    }

    @media (max-width: 768px) {
        .filter-grid { grid-template-columns: 1fr; }
        .filter-action-group { width: 100%; display: flex; gap: 0.5rem; }
        .filter-action-group button, .filter-action-group a { flex: 1; text-align: center; }
    }

    @media (max-width: 640px) {
        .page-head-flex { flex-direction: column; align-items: stretch; }
        .btn-primary { width: 100%; }
        .stat-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="page-head page-head-flex">
    <div>
        <h1>Data Masyarakat</h1>
        <p>Kelola data warga pencari kerja, status pekerjaan, status verifikasi, dan wilayah.</p>
    </div>
    <div>
        <a href="{{ route('admin.masyarakat.create') }}" class="btn-primary">
            <span>+ Tambah Masyarakat</span>
        </a>
    </div>
</div>

@if (session('success'))
    <div class="alert-success">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert-error">{{ session('error') }}</div>
@endif

<!-- CARD STATISTIK DIUBAH SANGAT PRESISI -->
<section class="stat-grid">
    <div class="stat-box">
        <div class="stat-box-head"><span>Total Masyarakat</span></div>
        <strong>{{ number_format($ringkasan['total_masyarakat'] ?? 0) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head"><span>Sudah Bekerja</span></div>
        <strong>{{ number_format($ringkasan['sudah_bekerja'] ?? 0) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head"><span>Belum Diverifikasi</span></div>
        <strong>{{ number_format($ringkasan['belum_verifikasi'] ?? $ringkasan['pending_verifikasi'] ?? 0) }}</strong>
    </div>
    <div class="stat-box">
        <div class="stat-box-head"><span>Terverifikasi</span></div>
        <strong>{{ number_format($ringkasan['terverifikasi'] ?? 0) }}</strong>
    </div>
</section>

<article class="card card-filter">
    <form action="{{ route('admin.masyarakat') }}" method="GET">
        <div class="filter-grid">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, atau keahlian..." class="form-control">
            </div>
            <div>
                <select name="wilayah" class="form-control">
                    <option value="">Semua Wilayah</option>
                    @foreach ($wilayahList as $wil)
                        <option value="{{ $wil }}" {{ request('wilayah') == $wil ? 'selected' : '' }}>{{ $wil }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="form-control">
                    <option value="">Semua Status</option>
                    <option value="Belum / Tidak Bekerja" {{ request('status') == 'Belum / Tidak Bekerja' ? 'selected' : '' }}>Belum / Tidak Bekerja</option>
                    <option value="Pekerja Lepas / Serabutan" {{ request('status') == 'Pekerja Lepas / Serabutan' ? 'selected' : '' }}>Pekerja Lepas / Serabutan</option>
                    <option value="Terkena PHK" {{ request('status') == 'Terkena PHK' ? 'selected' : '' }}>Terkena PHK</option>
                </select>
            </div>
            <div class="filter-action-group">
                <button type="submit" class="btn-secondary">Cari</button>
                @if(request()->anyFilled(['search', 'wilayah', 'status']))
                    <a href="{{ route('admin.masyarakat') }}" class="btn-reset">Reset</a>
                @endif
            </div>
        </div>
    </form>
</article>

<article class="card">
    <div class="card-head"><h2>Daftar Masyarakat</h2></div>
    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama & NIK</th>
                    <th>Kontak</th>
                    <th>Wilayah</th>
                    <th>Status Verifikasi</th> <!-- DIUBAH DARI KEAHLIAN -->
                    <th>Status Pekerjaan</th>
                    <th class="text-center" width="70">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($masyarakat as $index => $warga)
                    <tr>
                        <td>{{ $masyarakat->firstItem() + $index }}</td>
                        <td>
                            <strong>{{ $warga->nama }}</strong>
                            <small class="text-muted" style="display:block;">NIK: {{ $warga->nik }}</small>
                        </td>
                        <td>{{ $warga->telepon }}</td>
                        <td>{{ $warga->kecamatan }}</td>
                        
                        <!-- KOLOM STATUS VERIFIKASI -->
                        <td>
                            @if(($warga->status_verifikasi ?? '') === 'Terverifikasi')
                                <span class="badge-status badge-verified">Sudah Terverifikasi</span>
                            @else
                                <span class="badge-status badge-pending">Belum Terverifikasi</span>
                            @endif
                        </td>
                        
                        <td><span class="badge">{{ $warga->status_pekerjaan }}</span></td>
                        <td>
                            <div style="display: flex; gap: 6px; justify-content: center;">
                                <a href="{{ route('admin.masyarakat.show', $warga->id) }}" class="btn-icon" title="Lihat Detail Lengkap">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#12395B" stroke-width="1.8" width="18" height="18">
                                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                        <circle cx="12" cy="12" r="3"/>
                                    </svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">Belum ada data masyarakat yang tersimpan.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($masyarakat->hasPages())
        <div class="card-footer">{{ $masyarakat->links() }}</div>
    @endif
</article>
@endsection