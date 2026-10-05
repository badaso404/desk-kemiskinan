@extends('layouts.admin')

@section('title', 'Data Masyarakat')

<link rel="stylesheet" href="{{ asset('css/auto-skeleton.css') }}">
<script src="{{ asset('js/auto-skeleton.js') }}" defer></script>
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
        border: none;
        cursor: pointer;
        font-family: inherit;
        font-size: 0.875rem;
        transition: background-color 0.2s ease;
    }
    .btn-primary:hover { 
        background-color: #0d2a43;
        color: #ffffff; 
    }
    .btn-primary:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    /* TOMBOL IMPORT (SECONDARY OUTLINE) */
    .btn-import {
        background-color: #ffffff;
        color: #12395B;
        border: 1px solid #12395B;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        font-family: inherit;
        font-size: 0.875rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: background-color 0.2s ease, color 0.2s ease;
    }
    .btn-import:hover {
        background-color: #ebf3fa;
        color: #12395B;
    }

    .head-actions {
        display: flex;
        gap: 0.6rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .btn-secondary { 
        background-color: #f1f5f9; 
        color: #1e293b; 
        border: 1px solid #cbd5e1; 
        padding: 0.55rem 1rem; 
        border-radius: 8px; 
        cursor: pointer; 
        font-weight: 500; 
        display: inline-flex; 
        justify-content: center; 
        align-items: center;
        font-family: inherit;
        font-size: 0.875rem;
    }
    .btn-secondary:hover { background-color: #e2e8f0; }

    .btn-reset { 
        color: #b91c1c; 
        text-decoration: none; 
        font-size: 0.875rem; 
        padding: 0.55rem 0.75rem; 
        border-radius: 8px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center; 
    }
    .btn-reset:hover { background-color: #fef2f2; }

    /* ================= ALERT ================= */
    .alert-success,
    .alert-error,
    .alert-warning {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        padding: 1rem 1.1rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        line-height: 1.5;
    }
    .alert-success svg,
    .alert-error svg,
    .alert-warning svg {
        flex-shrink: 0;
        margin-top: 1px;
    }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; }
    .alert-error   { background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; }
    .alert-warning { background: #fffbeb; border: 1px solid #fde047; color: #854d0e; }

    .card-footer { padding: 1rem 1.25rem; border-top: 1px solid #e2e8f0; }

    .btn-icon { 
        background: transparent; 
        border: none; 
        padding: 6px; 
        cursor: pointer; 
        border-radius: 6px; 
        display: inline-flex; 
        align-items: center; 
        justify-content: center;
        transition: background .15s ease;
    }
    .btn-icon:hover { background: #ebf3fa; }

    /* ================= BADGE STATUS VERIFIKASI ================= */
    .badge-status { 
        display: inline-flex; 
        align-items: center; 
        gap: 0.35rem; 
        padding: 4px 10px; 
        border-radius: 9999px; 
        font-size: 0.78rem; 
        font-weight: 600; 
        white-space: nowrap;
    }
    .badge-verified { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
    .badge-pending  { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }

    /* ================= BADGE STATUS PEKERJAAN ================= */
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 0.78rem;
        font-weight: 600;
        background: #ebf3fa;
        color: #12395B;
        border: 1px solid #d6e4f0;
        white-space: nowrap;
        line-height: 1.4;
    }

    /* ================= STAT GRID ================= */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    /* ================= FILTER ================= */
    .card-filter { 
        margin-bottom: 1.5rem; 
        padding: 1.25rem; 
        background: #fff; 
        border-radius: 12px; 
        box-shadow: 0 2px 8px rgba(0,0,0,0.04); 
    }
    .filter-grid { 
        display: grid; 
        grid-template-columns: 2fr 1fr 1fr auto; 
        gap: 1rem; 
        align-items: center; 
    }
    .form-control { 
        width: 100%; 
        padding: 0.6rem 0.85rem; 
        border: 1px solid #e2e8f0; 
        border-radius: 8px; 
        font-size: 0.875rem; 
        outline: none; 
        box-sizing: border-box; 
        background-color: #fff;
        font-family: inherit;
        transition: border-color .15s ease, box-shadow .15s ease;
    }
    .form-control:focus { 
        border-color: #12395B; 
        box-shadow: 0 0 0 3px rgba(18, 57, 91, 0.15); 
    }

    /* ================= TABLE ================= */
    .table-scroll { 
        width: 100%; 
        overflow-x: auto; 
        -webkit-overflow-scrolling: touch; 
    }
    .data-table { width: 100%; min-width: 650px; }
    .text-muted { color: #64748b; }
    .text-center { text-align: center; }

    /* ================= PAGINATION ================= */
    .pagination-wrap {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }
    .pagination-info {
        font-size: .8rem;
        color: #64748b;
        margin: 0;
    }
    .pagination-info strong {
        color: #0f172a;
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }
    .pagination {
        display: flex;
        align-items: center;
        gap: .25rem;
        list-style: none;
        margin: 0;
        padding: 0;
        flex-wrap: wrap;
    }
    .pagination-item { display: inline-flex; }
    .pagination-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: .35rem;
        min-width: 34px;
        height: 34px;
        padding: 0 .65rem;
        border-radius: 6px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        color: #334155;
        font-size: .82rem;
        font-weight: 500;
        text-decoration: none;
        transition: background .15s ease, border-color .15s ease, color .15s ease;
        font-variant-numeric: tabular-nums;
    }
    .pagination-link:hover {
        background: #ebf3fa;
        border-color: #b9d3eb;
        color: #12395B;
    }
    .pagination-link svg {
        width: 14px;
        height: 14px;
        flex-shrink: 0;
    }
    .pagination-item.is-active .pagination-link {
        background: #12395B;
        border-color: #12395B;
        color: #ffffff;
        font-weight: 600;
        cursor: default;
    }
    .pagination-item.is-disabled .pagination-link {
        background: #f8fafc;
        border-color: #f1f5f9;
        color: #94a3b8;
        cursor: not-allowed;
    }
    .pagination-ellipsis {
        border: none;
        background: transparent;
        color: #94a3b8;
        cursor: default;
        padding: 0 .35rem;
        min-width: auto;
    }
    .pagination-ellipsis:hover {
        background: transparent;
        border: none;
        color: #94a3b8;
    }

    /* ================= MODAL IMPORT ================= */
    .modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.55);
        backdrop-filter: blur(2px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 1rem;
        animation: fadeIn .15s ease;
    }
    .modal-overlay.is-open { display: flex; }

    @keyframes fadeIn {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(8px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .modal-box {
        background: #fff;
        border-radius: 14px;
        width: 100%;
        max-width: 520px;
        max-height: calc(100vh - 2rem);
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-shadow: 0 24px 48px -12px rgba(15, 23, 42, 0.35);
        animation: slideUp .2s ease;
    }

    .modal-head {
        padding: 1.15rem 1.5rem;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }
    .modal-head h2 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #12395B;
        margin: 0 0 .25rem 0;
    }
    .modal-head p {
        font-size: .8rem;
        color: #64748b;
        margin: 0;
        line-height: 1.45;
    }
    .modal-close {
        background: transparent;
        border: none;
        padding: 6px;
        border-radius: 6px;
        cursor: pointer;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: background .15s ease, color .15s ease;
        flex-shrink: 0;
    }
    .modal-close:hover { background: #f1f5f9; color: #0f172a; }

    .modal-body {
        padding: 1.5rem;
        overflow-y: auto;
        flex: 1;
    }
    .modal-foot {
        padding: 1rem 1.5rem;
        border-top: 1px solid #f1f5f9;
        display: flex;
        justify-content: flex-end;
        gap: .6rem;
        background: #fafafa;
    }

    /* Download template card */
    .template-card {
        display: flex;
        align-items: center;
        gap: .85rem;
        padding: .85rem 1rem;
        background: #ebf3fa;
        border: 1px solid #d6e4f0;
        border-radius: 10px;
        margin-bottom: 1.25rem;
    }
    .template-card-icon {
        width: 38px;
        height: 38px;
        border-radius: 8px;
        background: #ffffff;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .template-card-text { flex: 1; min-width: 0; }
    .template-card-title {
        font-size: .85rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: .15rem;
    }
    .template-card-desc {
        font-size: .75rem;
        color: #64748b;
        line-height: 1.35;
    }
    .template-download {
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        padding: .45rem .85rem;
        background: #ffffff;
        color: #12395B;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: .78rem;
        font-weight: 600;
        text-decoration: none;
        transition: background .15s ease;
        flex-shrink: 0;
        white-space: nowrap;
    }
    .template-download:hover { background: #f8fafc; }

    /* Drop zone */
    .drop-zone {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        text-align: center;
        padding: 2rem 1.5rem;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #fafafa;
        cursor: pointer;
        transition: border-color .15s ease, background .15s ease;
    }
    .drop-zone:hover,
    .drop-zone.is-dragover {
        border-color: #12395B;
        background: #ebf3fa;
    }
    .drop-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
    }
    .drop-zone-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #ebf3fa;
        color: #12395B;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: .85rem;
    }
    .drop-zone-title {
        font-size: .9rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: .25rem;
    }
    .drop-zone-hint {
        font-size: .78rem;
        color: #64748b;
        line-height: 1.4;
    }
    .drop-zone-hint strong { color: #12395B; }

    /* File preview */
    .file-preview {
        display: none;
        align-items: center;
        gap: .75rem;
        padding: .75rem 1rem;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        margin-top: .85rem;
    }
    .file-preview.is-visible { display: flex; }
    .file-preview-icon {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #dcfce7;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .file-preview-info { flex: 1; min-width: 0; }
    .file-preview-name {
        font-size: .82rem;
        font-weight: 600;
        color: #0f172a;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .file-preview-size { font-size: .72rem; color: #64748b; }
    .file-preview-remove {
        background: transparent;
        border: none;
        padding: 5px;
        border-radius: 6px;
        cursor: pointer;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .file-preview-remove:hover { background: #fee2e2; color: #991b1b; }

    /* Info format */
    .format-info {
        margin-top: 1rem;
        padding: .9rem 1.1rem;
        background: #fffbeb;
        border: 1px solid #fde047;
        border-radius: 8px;
        font-size: .75rem;
        color: #854d0e;
        line-height: 1.55;
    }
    .format-info strong { color: #713f12; }
    .format-info code {
        display: inline-block;
        background: #fff;
        padding: 2px 6px;
        border-radius: 4px;
        font-size: .72rem;
        color: #12395B;
        font-family: ui-monospace, SFMono-Regular, Menlo, monospace;
        border: 1px solid #fde047;
    }
    .format-info ul {
        margin: .35rem 0 0 1.1rem;
        padding: 0;
    }
    .format-info-columns {
        margin-top: .5rem;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: .4rem .75rem;
    }

    /* ================= RESPONSIVE ================= */
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
        .head-actions { flex-direction: column; width: 100%; }
        .head-actions .btn-primary,
        .head-actions .btn-import { width: 100%; }

        .stat-grid { grid-template-columns: 1fr; }

        .modal-body { padding: 1.25rem; }
        .modal-foot { padding: .9rem 1.25rem; flex-direction: column-reverse; }
        .modal-foot .btn-primary,
        .modal-foot .btn-secondary { width: 100%; }

        .pagination-wrap { justify-content: center; }
        .pagination-info { width: 100%; text-align: center; }
        .pagination-link span:not(.pagination-ellipsis) { display: none; }
        .pagination-link { min-width: 34px; padding: 0 .5rem; }
    }

    @media (max-width: 480px) {
        .format-info-columns { grid-template-columns: 1fr !important; }
    }
</style>

{{-- ================= HEADER ================= --}}
<div class="page-head page-head-flex">
    <div>
        <h1>Data Masyarakat</h1>
        <p>Kelola data warga pencari kerja, status pekerjaan, status verifikasi, dan wilayah.</p>
    </div>
    <div class="head-actions">
        <button type="button" class="btn-import" data-open-import>
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0L8 8m4-4l4 4"/>
            </svg>
            <span>Import Excel</span>
        </button>

        <a href="{{ route('admin.masyarakat.create') }}" class="btn-primary">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Tambah Masyarakat</span>
        </a>
    </div>
</div>

{{-- ================= FLASH MESSAGES ================= --}}
@if (session('success'))
    <div class="alert-success" role="status">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if (session('error'))
    <div class="alert-error" role="alert">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

@if (session('import_warning'))
    <div class="alert-warning" role="alert">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M5.07 19h13.86a2 2 0 001.74-3L13.74 4a2 2 0 00-3.48 0L3.34 16a2 2 0 001.73 3z"/>
        </svg>
        <span>{!! session('import_warning') !!}</span>
    </div>
@endif

{{-- ================= STATISTIK ================= --}}
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

{{-- ================= FILTER ================= --}}
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

{{-- ================= TABEL ================= --}}

<article class="card" data-skeleton-on-load>
    
    <div class="card-head"><h2>Daftar Masyarakat</h2></div>
    <div class="table-scroll">
        <table class="data-table">
            <thead>
                <tr>
                    <th width="50">No</th>
                    <th>Nama & NIK</th>
                    <th>Kontak</th>
                    <th>Wilayah</th>
                    <th>Status Verifikasi</th>
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
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 2rem; color: #64748b;">
                            Belum ada data masyarakat yang tersimpan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ================= PAGINATION (INLINE) ================= --}}
    @if ($masyarakat->hasPages())
        <div class="card-footer">
            <nav class="pagination-wrap" role="navigation" aria-label="Navigasi halaman">

                {{-- Info --}}
                <p class="pagination-info">
                    Menampilkan
                    <strong>{{ $masyarakat->firstItem() }}</strong>–<strong>{{ $masyarakat->lastItem() }}</strong>
                    dari <strong>{{ $masyarakat->total() }}</strong> data
                </p>

                {{-- Tombol navigasi --}}
                <ul class="pagination">

                    {{-- Tombol "Sebelumnya" --}}
                    @if ($masyarakat->onFirstPage())
                        <li class="pagination-item is-disabled">
                            <span class="pagination-link" aria-disabled="true">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span>Sebelumnya</span>
                            </span>
                        </li>
                    @else
                        <li class="pagination-item">
                            <a href="{{ $masyarakat->previousPageUrl() }}" class="pagination-link" rel="prev">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                                </svg>
                                <span>Sebelumnya</span>
                            </a>
                        </li>
                    @endif

                    {{-- Logika window halaman --}}
                    @php
                        $currentPage = $masyarakat->currentPage();
                        $lastPage    = $masyarakat->lastPage();
                        $window      = 2;

                        $start = max(1, $currentPage - $window);
                        $end   = min($lastPage, $currentPage + $window);

                        $showFirstEllipsis = $start > 2;
                        $showLastEllipsis  = $end < $lastPage - 1;
                    @endphp

                    {{-- Halaman 1 --}}
                    @if ($start > 1)
                        <li class="pagination-item {{ $currentPage == 1 ? 'is-active' : '' }}">
                            @if ($currentPage == 1)
                                <span class="pagination-link" aria-current="page">1</span>
                            @else
                                <a href="{{ $masyarakat->url(1) }}" class="pagination-link">1</a>
                            @endif
                        </li>
                        @if ($showFirstEllipsis)
                            <li class="pagination-item is-disabled">
                                <span class="pagination-link pagination-ellipsis">…</span>
                            </li>
                        @endif
                    @endif

                    {{-- Halaman di sekitar current --}}
                    @for ($page = $start; $page <= $end; $page++)
                        <li class="pagination-item {{ $currentPage == $page ? 'is-active' : '' }}">
                            @if ($currentPage == $page)
                                <span class="pagination-link" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $masyarakat->url($page) }}" class="pagination-link">{{ $page }}</a>
                            @endif
                        </li>
                    @endfor

                    {{-- Halaman terakhir --}}
                    @if ($end < $lastPage)
                        @if ($showLastEllipsis)
                            <li class="pagination-item is-disabled">
                                <span class="pagination-link pagination-ellipsis">…</span>
                            </li>
                        @endif
                        <li class="pagination-item {{ $currentPage == $lastPage ? 'is-active' : '' }}">
                            @if ($currentPage == $lastPage)
                                <span class="pagination-link" aria-current="page">{{ $lastPage }}</span>
                            @else
                                <a href="{{ $masyarakat->url($lastPage) }}" class="pagination-link">{{ $lastPage }}</a>
                            @endif
                        </li>
                    @endif

                    {{-- Tombol "Berikutnya" --}}
                    @if ($masyarakat->hasMorePages())
                        <li class="pagination-item">
                            <a href="{{ $masyarakat->nextPageUrl() }}" class="pagination-link" rel="next">
                                <span>Berikutnya</span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </li>
                    @else
                        <li class="pagination-item is-disabled">
                            <span class="pagination-link" aria-disabled="true">
                                <span>Berikutnya</span>
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                                </svg>
                            </span>
                        </li>
                    @endif

                </ul>
            </nav>
        </div>
    @endif
</article>

{{-- ================= MODAL IMPORT EXCEL ================= --}}
<div class="modal-overlay" id="importModal" role="dialog" aria-modal="true" aria-labelledby="importModalTitle">
    <div class="modal-box">

        <div class="modal-head">
            <div>
                <h2 id="importModalTitle">Import Data dari Excel</h2>
                <p>Unggah file Excel untuk menambahkan data masyarakat secara massal.</p>
            </div>
            <button type="button" class="modal-close" data-close-import aria-label="Tutup">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <form action="{{ route('admin.masyarakat.import') }}" method="POST" enctype="multipart/form-data" id="importForm">
            @csrf
            <div class="modal-body">

                {{-- Download template --}}
                <div class="template-card">
                    <div class="template-card-icon">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="template-card-text">
                        <div class="template-card-title">Belum punya format?</div>
                        <div class="template-card-desc">Unduh template Excel terlebih dahulu</div>
                    </div>
                    <a href="{{ route('admin.masyarakat.template') }}" class="template-download">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0L8 8m4-4l4 4"/>
                        </svg>
                        Unduh
                    </a>
                </div>

                {{-- Drop zone --}}
                <label class="drop-zone" id="dropZone">
                    <input type="file" name="file" id="fileInput" accept=".xlsx,.xls,.csv" required>
                    <div class="drop-zone-icon">
                        <svg width="22" height="22" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                        </svg>
                    </div>
                    <div class="drop-zone-title">Klik atau tarik file ke sini</div>
                    <div class="drop-zone-hint">
                        Format <strong>.xlsx</strong>, <strong>.xls</strong>, atau <strong>.csv</strong> · Maks 5 MB
                    </div>
                </label>

                {{-- File preview --}}
                <div class="file-preview" id="filePreview">
                    <div class="file-preview-icon">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div class="file-preview-info">
                        <div class="file-preview-name" id="fileName">-</div>
                        <div class="file-preview-size" id="fileSize">-</div>
                    </div>
                    <button type="button" class="file-preview-remove" id="fileRemove" aria-label="Hapus file">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                {{-- Info format --}}
                <div class="format-info">
                    <strong>Kolom yang diharapkan (11 kolom):</strong>
                    <div class="format-info-columns">
                        <code>nama</code>
                        <code>nik</code>
                        <code>jenis_kelamin</code>
                        <code>tanggal_lahir</code>
                        <code>telepon</code>
                        <code>kecamatan</code>
                        <code>kelurahan</code>
                        <code>alamat</code>
                        <code>pendidikan_terakhir</code>
                        <code>status_pekerjaan</code>
                        <code>keahlian_minat</code>
                        <code style="opacity:.5;">—</code>
                    </div>
                    <div style="margin-top:.65rem;">
                        <strong>Ketentuan:</strong>
                        <ul>
                            <li>NIK harus <strong>16 digit</strong> dan belum terdaftar.</li>
                            <li>Jenis kelamin: <strong>Laki-laki</strong> / <strong>Perempuan</strong>.</li>
                            <li>Tanggal lahir format <strong>YYYY-MM-DD</strong> (contoh: <code>1999-01-01</code>).</li>
                            <li>Nomor telepon format <code>08xxxxxxxxx</code>.</li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="modal-foot">
                <button type="button" class="btn-secondary" data-close-import>Batal</button>
                <button type="submit" class="btn-primary" id="importSubmit" disabled>
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    <span data-submit-label>Import Sekarang</span>
                </button>
            </div>
        </form>

    </div>
</div>

<script>
(function () {
    var modal       = document.getElementById('importModal');
    var openBtn     = document.querySelector('[data-open-import]');
    var closeBtns   = document.querySelectorAll('[data-close-import]');
    var dropZone    = document.getElementById('dropZone');
    var fileInput   = document.getElementById('fileInput');
    var filePreview = document.getElementById('filePreview');
    var fileName    = document.getElementById('fileName');
    var fileSize    = document.getElementById('fileSize');
    var fileRemove  = document.getElementById('fileRemove');
    var submitBtn   = document.getElementById('importSubmit');
    var form        = document.getElementById('importForm');

    function openModal() {
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
    }
    function closeModal() {
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
        resetFile();
    }
    function resetFile() {
        fileInput.value = '';
        filePreview.classList.remove('is-visible');
        submitBtn.disabled = true;
    }

    openBtn.addEventListener('click', openModal);
    closeBtns.forEach(function (b) { b.addEventListener('click', closeModal); });

    modal.addEventListener('click', function (e) {
        if (e.target === modal) closeModal();
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
    });

    /* Drag & drop */
    ['dragenter', 'dragover'].forEach(function (ev) {
        dropZone.addEventListener(ev, function (e) {
            e.preventDefault();
            dropZone.classList.add('is-dragover');
        });
    });
    ['dragleave', 'drop'].forEach(function (ev) {
        dropZone.addEventListener(ev, function (e) {
            e.preventDefault();
            dropZone.classList.remove('is-dragover');
        });
    });
    dropZone.addEventListener('drop', function (e) {
        if (e.dataTransfer.files.length) {
            fileInput.files = e.dataTransfer.files;
            handleFile();
        }
    });

    fileInput.addEventListener('change', handleFile);

    function handleFile() {
        var f = fileInput.files[0];
        if (!f) { resetFile(); return; }

        fileName.textContent = f.name;
        fileSize.textContent = (f.size / 1024).toFixed(0) + ' KB';
        filePreview.classList.add('is-visible');
        submitBtn.disabled = false;
    }

    fileRemove.addEventListener('click', function (e) {
        e.preventDefault();
        resetFile();
    });

    /* Submit — loading state */
    form.addEventListener('submit', function () {
        if (submitBtn.disabled) return;
        submitBtn.disabled = true;
        var label = submitBtn.querySelector('[data-submit-label]');
        if (label) label.textContent = 'Mengimpor...';
    });

    /* AUTO-OPEN MODAL SAAT ERROR */
    @if (session('error') || $errors->any())
        openModal();
    @endif
})();
</script>

@endsection