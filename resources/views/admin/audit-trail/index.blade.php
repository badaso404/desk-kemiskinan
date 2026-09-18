@extends('layouts.admin')

@section('title', 'Audit Trail')

@section('content')
<style>
    .audit-shell {
        padding: 8px 4px 0;
    }

    .audit-header {
        display: flex;
        align-items: center;
        gap: 14px;
        margin: 0 0 18px;
    }

    .audit-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: linear-gradient(180deg, #2a3444, #1f2937);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.12);
    }

    .audit-header h1 {
        margin: 0;
        font-size: 2rem;
        line-height: 1.1;
        font-weight: 700;
        color: #1f2937;
    }

    .audit-subtitle {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .audit-toolbar {
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1px solid #dfe7f1;
        border-radius: 14px;
        background: rgba(255,255,255,0.65);
        padding: 12px 16px;
        margin-bottom: 22px;
        box-shadow: 0 3px 10px rgba(15, 23, 42, 0.02);
    }

    .audit-search {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        min-height: 42px;
        color: #64748b;
    }

    .audit-search input {
        flex: 1;
        border: none;
        outline: none;
        background: transparent;
        color: #1f2937;
        font-size: 1rem;
    }

    .audit-search input::placeholder {
        color: #94a3b8;
    }

    .audit-dropdown {
        position: relative;
        min-width: 190px;
    }

    .audit-dropdown-toggle {
        width: 100%;
        min-height: 42px;
        border: 1px solid #dfe7f1;
        background: #fff;
        border-radius: 12px;
        padding: 0 12px 0 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        font-size: 0.98rem;
        color: #1f2937;
        cursor: pointer;
    }

    .audit-dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        width: 100%;
        background: #fff;
        border: 1px solid #dfe7f1;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(15, 23, 42, 0.08);
        padding: 8px 0;
        display: none;
        z-index: 20;
        max-height: 280px;
        overflow-y: auto;
    }

    .audit-dropdown.show .audit-dropdown-menu {
        display: block;
    }

    .audit-option {
        width: 100%;
        border: none;
        background: transparent;
        text-align: left;
        padding: 8px 14px;
        font-size: 0.96rem;
        color: #1f2937;
        cursor: pointer;
    }

    .audit-option:hover,
    .audit-option.is-active {
        background: #eef4ff;
        color: #1d4ed8;
    }

    .audit-list {
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        background: rgba(255,255,255,0.55);
        overflow: hidden;
    }

    .audit-item {
        display: flex;
        align-items: flex-start;
        gap: 16px;
        padding: 18px 18px 16px;
        border-bottom: 1px solid #e5e7eb;
        background: rgba(255,255,255,0.2);
    }

    .audit-item:last-child {
        border-bottom: none;
    }

    .audit-avatar {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #edf2f7;
        border: 1px solid #dfe6ee;
        color: #1f2937;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.08);
    }

    .audit-avatar svg {
        width: 17px;
        height: 17px;
        stroke-width: 1.8;
    }

    .audit-content {
        flex: 1;
        min-width: 0;
    }

    .audit-line {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 4px;
    }

    .audit-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 26px;
        padding: 0 10px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 700;
        border: 1px solid transparent;
        white-space: nowrap;
    }

    .badge-login, .badge-logout {
        background: #dbeafe;
        color: #1d4ed8;
        border-color: #93c5fd;
    }

    .badge-create_masyarakat,
    .badge-create_program,
    .badge-create_mitra,
    .badge-create_penempatan,
    .badge-create_case,
    .badge-input_desil,
    .badge-program_matching,
    .badge-recommendation,
    .badge-decision,
    .badge-status_change,
    .badge-permission_change,
    .badge-delete_masyarakat,
    .badge-delete_program,
    .badge-delete_mitra,
    .badge-delete_penempatan {
        background: #fef3c7;
        color: #92400e;
        border-color: #fcd34d;
    }

    .badge-update_masyarakat,
    .badge-update_reporter,
    .badge-update_desil,
    .badge-update_program,
    .badge-update_mitra,
    .badge-update_penempatan {
        background: #dbeafe;
        color: #1d4ed8;
        border-color: #93c5fd;
    }

    .audit-action {
        font-size: 1.07rem;
        line-height: 1.35;
        color: #1f2937;
        font-weight: 600;
        word-break: break-word;
    }

    .audit-meta {
        margin-top: 2px;
        color: #64748b;
        font-size: 0.9rem;
    }

    .audit-extra {
        margin-top: 8px;
        color: #475569;
        font-size: 0.92rem;
        font-weight: 600;
    }

    .audit-empty {
        padding: 28px 18px;
        color: #64748b;
        text-align: center;
    }

    .audit-pagination {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        padding-top: 12px;
        border-top: 1px solid #e5e7eb;
    }

    .audit-pagination-summary {
        color: #374151;
        font-size: 1.05rem;
        font-weight: 500;
    }

    .audit-pagination-links {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-left: auto;
    }

    .audit-page-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 34px;
        height: 34px;
        border-radius: 50%;
        border: 1px solid #dfe7f1;
        color: #374151;
        background: #fff;
        text-decoration: none;
        font-size: 0.96rem;
        font-weight: 600;
        line-height: 1;
        transition: all 0.2s ease;
    }

    .audit-page-btn:hover {
        border-color: #c9d4e2;
        background: #f8fafc;
    }

    .audit-page-btn.active {
        background: #0d5bd7;
        color: #fff;
        border-color: #0d5bd7;
        box-shadow: 0 2px 6px rgba(13, 91, 215, 0.18);
    }

    .audit-page-btn.disabled {
        color: #a1acb8;
        background: #fff;
        border-color: #dfe7f1;
        pointer-events: none;
    }

    .audit-page-btn.ellipsis {
        width: auto;
        border: none;
        background: transparent;
        border-radius: 0;
        color: #64748b;
        pointer-events: none;
        font-size: 1.3rem;
        margin: 0 2px;
    }

    @media (max-width: 720px) {
        .audit-toolbar {
            flex-direction: column;
            align-items: stretch;
        }

        .audit-dropdown {
            width: 100%;
        }
    }
</style>
@php
    $selectedEvent = request('event', 'all');
    $selectedLabel = 'Semua Event';
    foreach ($eventOptions as $option) {
        if ($option['value'] === $selectedEvent) {
            $selectedLabel = $option['label'];
            break;
        }
    }
@endphp


<div class="audit-shell">
    <div class="audit-header">
        <div class="audit-icon" aria-hidden="true">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 8v4l3 3"/>
                <path d="M12 21a9 9 0 1 0 0-18 9 9 0 0 0 0 18z"/>
            </svg>
        </div>
        <div>
            <h1>Audit Trail</h1>
            <div class="audit-subtitle">Catatan semua aktivitas penting sistem</div>
        </div>
    </div>

    <form method="GET" action="{{ route('admin.audit-trail') }}" class="audit-toolbar" id="auditForm">
        <div class="audit-search">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <circle cx="11" cy="11" r="7"></circle>
                <path d="M20 20l-3.5-3.5"></path>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari aktivitas atau pengguna...">
        </div>

        <div class="audit-dropdown" id="auditDropdown">
            <button type="button" class="audit-dropdown-toggle" id="auditDropdownToggle" aria-haspopup="listbox" aria-expanded="false">
                <span id="auditDropdownLabel">{{ $selectedLabel }}</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <path d="M6 9l6 6 6-6"/>
                </svg>
            </button>
            <div class="audit-dropdown-menu" role="listbox" aria-label="Pilih event">
                @foreach ($eventOptions as $option)
                    <button
                        type="button"
                        class="audit-option {{ request('event', 'all') === $option['value'] ? 'is-active' : '' }}"
                        data-value="{{ $option['value'] }}"
                        data-label="{{ $option['label'] }}"
                    >
                        {{ $option['label'] }}
                    </button>
                @endforeach
            </div>
        </div>

        <input type="hidden" name="event" id="selectedEvent" value="{{ request('event', 'all') }}">
    </form>

    <div class="audit-list">
        @forelse ($auditTrails as $trail)
            <article class="audit-item">
                <div class="audit-avatar" aria-hidden="true">
                    @php
                        $iconMap = [
                            'login' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2"/><circle cx="9.5" cy="7" r="3.5"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                            'logout' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg>',
                            'create_masyarakat' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M12 18h.01"/><path d="M12 15h.01"/><path d="M10 12h4"/></svg>',
                            'update_masyarakat' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>',
                            'delete_masyarakat' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>',
                            'create_program' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 3v4"/><path d="M8 3v4"/><path d="M2 11h20"/><path d="M12 12v8"/><path d="M8 16h8"/></svg>',
                            'update_program' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>',
                            'delete_program' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>',
                            'create_mitra' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v13"/><path d="M9 20v-5h6v5"/><path d="M8 9h.01"/><path d="M16 9h.01"/><path d="M12 9v.01"/><path d="M12 5V3"/><path d="M9 5h6"/></svg>',
                            'update_mitra' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>',
                            'delete_mitra' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>',
                            'create_penempatan' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13S3 17 3 10a9 9 0 0 1 18 0Z"/><circle cx="12" cy="10" r="3"/><path d="M12 5v2"/><path d="M12 15v2"/><path d="M9 10h2"/><path d="M13 10h2"/></svg>',
                            'update_penempatan' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>',
                            'delete_penempatan' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>',
                            'create_case' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M12 11v6"/><path d="M9 14h6"/></svg>',
                            'update_reporter' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/><path d="M18 8l3 3"/><path d="M21 5l-3 3"/></svg>',
                            'input_desil' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H7a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M8 13h8"/><path d="M8 17h8"/></svg>',
                            'update_desil' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 1 1 3 3L7 19l-4 1 1-4 12.5-12.5Z"/></svg>',
                            'program_matching' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7H14.5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                            'recommendation' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2l1.7 5.3L19 9l-5.3 1.7L12 16l-1.7-5.3L5 9l5.3-1.7L12 2Z"/><path d="M19 15l.7 2.3L22 18l-2.3.7L19 21l-.7-2.3L16 18l2.3-.7L19 15Z"/></svg>',
                            'decision' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l4 4 10-10"/><path d="M20 4v6h-6"/></svg>',
                            'status_change' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5l7 7-7 7"/></svg>',
                            'permission_change' => '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 3l7 4v5c0 5-3.5 8.5-7 9-3.5-.5-7-4-7-9V7l7-4Z"/><path d="M9.5 12.5l1.6 1.6 3.4-4.1"/></svg>',
                        ];
                    @endphp
                    {!! $iconMap[$trail->action] ?? '<svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="8"/><path d="M12 8v4l2.5 2.5"/></svg>' !!}
                </div>

                <div class="audit-content">
                    <div class="audit-line">
                        <span class="audit-badge badge-{{ $trail->action }}">{{ $trail->action }}</span>
                        <div class="audit-action">{{ $trail->description }}</div>
                    </div>
                    <div class="audit-meta">Pengguna {{ $trail->user_name }} · {{ $trail->created_at->translatedFormat('d/m/Y, H:i') }}</div>
                    @if (!empty($trail->metadata))
                        <div class="audit-extra">
                            @foreach ($trail->metadata as $key => $value)
                                {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}
                                @if (! $loop->last)
                                    •
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="audit-empty">Belum ada aktivitas tercatat.</div>
        @endforelse
    </div>

    @php
        $currentPage = $auditTrails->currentPage();
        $lastPage = $auditTrails->lastPage();
        $pageLinks = [];

        if ($lastPage <= 5) {
            for ($page = 1; $page <= $lastPage; $page++) {
                $pageLinks[] = $page;
            }
        } else {
            $pageLinks = [1];

            if ($currentPage > 3) {
                $pageLinks[] = '...';
            }

            for ($page = max(2, $currentPage - 1); $page <= min($lastPage - 1, $currentPage + 1); $page++) {
                if (!in_array($page, $pageLinks, true)) {
                    $pageLinks[] = $page;
                }
            }

            if ($currentPage < $lastPage - 2) {
                $pageLinks[] = '...';
            }

            if (!in_array($lastPage, $pageLinks, true)) {
                $pageLinks[] = $lastPage;
            }
        }
    @endphp

    <div class="audit-pagination">
        <div class="audit-pagination-summary">
            Menampilkan {{ $auditTrails->firstItem() ?? 0 }}-{{ $auditTrails->lastItem() ?? 0 }} dari {{ $auditTrails->total() }} data
        </div>

        <div class="audit-pagination-links">
            @if ($auditTrails->onFirstPage())
                <span class="audit-page-btn disabled">‹</span>
            @else
                <a class="audit-page-btn" href="{{ $auditTrails->previousPageUrl() }}">‹</a>
            @endif

            @foreach ($pageLinks as $page)
                @if ($page === '...')
                    <span class="audit-page-btn ellipsis">…</span>
                @elseif ((int) $page === $currentPage)
                    <span class="audit-page-btn active">{{ $page }}</span>
                @else
                    <a class="audit-page-btn" href="{{ $auditTrails->url((int) $page) }}">{{ $page }}</a>
                @endif
            @endforeach

            @if ($auditTrails->hasMorePages())
                <a class="audit-page-btn" href="{{ $auditTrails->nextPageUrl() }}">›</a>
            @else
                <span class="audit-page-btn disabled">›</span>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('auditDropdown');
        const toggle = document.getElementById('auditDropdownToggle');
        const label = document.getElementById('auditDropdownLabel');
        const hiddenInput = document.getElementById('selectedEvent');
        const form = document.getElementById('auditForm');

        if (!dropdown || !toggle || !label || !hiddenInput || !form) return;

        const syncSelection = (value, text) => {
            hiddenInput.value = value;
            label.textContent = text;
            toggle.setAttribute('aria-expanded', 'false');
            dropdown.classList.remove('show');
            form.submit();
        };

        toggle.addEventListener('click', function () {
            const isOpen = dropdown.classList.contains('show');
            dropdown.classList.toggle('show', !isOpen);
            toggle.setAttribute('aria-expanded', String(!isOpen));
        });

        document.querySelectorAll('.audit-option').forEach(function (option) {
            option.addEventListener('click', function () {
                syncSelection(option.dataset.value, option.dataset.label);
            });
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('show');
                toggle.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
@endsection
