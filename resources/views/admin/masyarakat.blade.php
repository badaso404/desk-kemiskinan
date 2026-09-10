@extends('layouts.admin')

@section('title', 'Data Masyarakat')

@section('content')
<style>
    .page-head-flex { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .btn-primary { background-color: #1d4ed8; color: #ffffff; padding: 0.6rem 1.2rem; border-radius: 8px; text-decoration: none; font-weight: 500; display: inline-flex; align-items: center; gap: 0.5rem; }
    .btn-secondary { background-color: #f1f5f9; color: #1e293b; border: 1px solid #cbd5e1; padding: 0.55rem 1rem; border-radius: 8px; cursor: pointer; font-weight: 500; }
    .btn-secondary:hover { background-color: #e2e8f0; }
    .btn-reset { color: #b91c1c; text-decoration: none; font-size: 0.875rem; padding: 0.55rem 0.75rem; border-radius: 8px; display: inline-flex; align-items: center; }
    .btn-reset:hover { background-color: #fef2f2; }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .alert-error { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; }
    .card-footer { padding: 1rem 1.25rem; border-top: 1px solid #e2e8f0; }
    .tag-item { background: #f1f5f9; color: #334155; padding: 2px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 500; }
    .btn-icon { background: transparent; border: none; padding: 6px; cursor: pointer; border-radius: 6px; display: inline-flex; align-items: center; justify-content: center; }
    .btn-icon:hover { background: #f1f5f9; }
    .card-filter { margin-bottom: 1.5rem; padding: 1.25rem; background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); }
    .filter-grid { display: grid; grid-template-columns: 2fr 1fr 1fr auto; gap: 1rem; align-items: center; }
    @media (max-width: 992px) { .filter-grid { grid-template-columns: 1fr; } }
    .form-control { width: 100%; padding: 0.6rem 0.85rem; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 0.875rem; outline: none; box-sizing: border-box; background-color: #fff; }
    .form-control:focus { border-color: #1d4ed8; box-shadow: 0 0 0 3px rgba(29, 78, 216, 0.1); }
</style>

<div class="page-head page-head-flex">
    <div>
        <h1>Data Masyarakat</h1>
        <p>Kelola data warga pencari kerja, status pekerjaan, keahlian, dan wilayah.</p>
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

<section class="stat-grid">
    <div class="stat-box"><div class="stat-box-head"><span>Total Masyarakat</span></div><strong>{{ number_format($ringkasan['total_masyarakat'] ?? 0) }}</strong></div>
    <div class="stat-box"><div class="stat-box-head"><span>Membutuhkan Pekerjaan</span></div><strong>{{ number_format($ringkasan['butuh_pekerjaan'] ?? 0) }}</strong></div>
    <div class="stat-box"><div class="stat-box-head"><span>Sudah Bekerja</span></div><strong>{{ number_format($ringkasan['sudah_bekerja'] ?? 0) }}</strong></div>
    <div class="stat-box"><div class="stat-box-head"><span>Minat Pelatihan</span></div><strong>{{ number_format($ringkasan['dalam_pelatihan'] ?? 0) }}</strong></div>
</section>

<article class="card card-filter">
    <form action="{{ route('admin.masyarakat') }}" method="GET">
        <div class="filter-grid">
            <div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIK, atau keahlian..." class="form-control">
            </div>
            <div>
                <select name="wilayah" class="form-control">
                    <option value="">-- Semua Wilayah --</option>
                    @foreach ($wilayahList as $wil)
                        <option value="{{ $wil }}" {{ request('wilayah') == $wil ? 'selected' : '' }}>{{ $wil }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="status" class="form-control">
                    <option value="">-- Semua Status --</option>
                    <option value="Belum / Tidak Bekerja" {{ request('status') == 'Belum / Tidak Bekerja' ? 'selected' : '' }}>Belum / Tidak Bekerja</option>
                    <option value="Pekerja Lepas / Serabutan" {{ request('status') == 'Pekerja Lepas / Serabutan' ? 'selected' : '' }}>Pekerja Lepas / Serabutan</option>
                    <option value="Terkena PHK" {{ request('status') == 'Terkena PHK' ? 'selected' : '' }}>Terkena PHK</option>
                </select>
            </div>
            <div style="display: flex; gap: 0.5rem; align-items: center;">
                <button type="submit" class="btn-secondary">Filter</button>
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
                    <th>Keahlian</th>
                    <th>Status Pekerjaan</th>
                    <th class="text-center" width="100">Aksi</th>
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
                        <td>
                            @foreach (explode(',', $warga->keahlian) as $skill)
                                <span class="tag-item">{{ trim($skill) }}</span>
                            @endforeach
                        </td>
                        <td><span class="badge">{{ $warga->status_pekerjaan }}</span></td>
                        <td>
                            <div style="display: flex; gap: 8px; justify-content: center;">
                                <a href="{{ route('admin.masyarakat.edit', $warga->id) }}" class="btn-icon" title="Ubah Data">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#d97706" stroke-width="1.8" width="18" height="18"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                </a>
                                <form action="{{ route('admin.masyarakat.destroy', $warga->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data {{ $warga->nama }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon" title="Hapus Data">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="1.8" width="18" height="18"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                    </button>
                                </form>
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