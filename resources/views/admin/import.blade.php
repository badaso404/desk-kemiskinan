@extends('layouts.admin')

@section('title', 'Import Data Masyarakat')

@section('content')
<style>
    .import-wrapper {
        max-width: 720px;
        margin: 0 auto;
    }
    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        color: #64748b;
        font-size: .82rem;
        font-weight: 500;
        text-decoration: none;
        margin-bottom: 1.25rem;
    }
    .btn-back:hover { color: #12395B; }

    .page-header {
        margin-bottom: 1.5rem;
        padding-bottom: 1.25rem;
        border-bottom: 1px solid #e5e7eb;
    }
    .page-header h1 {
        font-size: 1.4rem;
        font-weight: 700;
        color: #12395B;
        margin: 0 0 .3rem 0;
    }
    .page-header p {
        font-size: .85rem;
        color: #64748b;
        margin: 0;
    }

    .import-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }

    .import-section {
        padding: 1.5rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .import-section:last-child { border-bottom: none; }

    .section-label {
        display: flex;
        align-items: center;
        gap: .55rem;
        font-size: .85rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
    }
    .section-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: #ebf3fa;
        color: #12395B;
        border-radius: 50%;
        font-size: .72rem;
        font-weight: 700;
        flex-shrink: 0;
    }

    /* Download template row */
    .template-row {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: .9rem 1.1rem;
        background: #f8fafc;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }
    .template-row-icon {
        width: 40px;
        height: 40px;
        border-radius: 8px;
        background: #dcfce7;
        color: #16a34a;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .template-row-text { flex: 1; min-width: 0; }
    .template-row-title {
        font-size: .85rem;
        font-weight: 600;
        color: #0f172a;
        margin-bottom: .15rem;
    }
    .template-row-desc {
        font-size: .75rem;
        color: #64748b;
    }
    .btn-download {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        padding: .5rem .9rem;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        font-size: .8rem;
        font-weight: 600;
        color: #12395B;
        text-decoration: none;
        transition: background .15s ease;
        white-space: nowrap;
    }
    .btn-download:hover { background: #f1f5f9; }

    /* Upload form */
    .drop-zone {
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2.25rem 1.5rem;
        border: 2px dashed #cbd5e1;
        border-radius: 12px;
        background: #fafafa;
        text-align: center;
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
        margin-bottom: .3rem;
    }
    .drop-zone-hint {
        font-size: .78rem;
        color: #64748b;
    }
    .drop-zone-hint strong { color: #12395B; }

    .file-preview {
        display: none;
        align-items: center;
        gap: .75rem;
        padding: .8rem 1rem;
        margin-top: .85rem;
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
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
        padding: 6px;
        border-radius: 6px;
        cursor: pointer;
        color: #64748b;
        display: inline-flex;
    }
    .file-preview-remove:hover { background: #fee2e2; color: #991b1b; }

    /* Alert */
    .alert {
        display: flex;
        align-items: flex-start;
        gap: .6rem;
        padding: .85rem 1rem;
        border-radius: 8px;
        font-size: .82rem;
        margin-bottom: 1.25rem;
        line-height: 1.5;
    }
    .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
    .alert-success { background: #dcfce7; border: 1px solid #86efac; color: #166534; }

    /* Info box */
    .info-box {
        padding: .9rem 1.1rem;
        background: #fffbeb;
        border: 1px solid #fde047;
        border-radius: 8px;
        font-size: .78rem;
        color: #854d0e;
        line-height: 1.6;
    }
    .info-box strong { color: #713f12; }
    .info-box code {
        background: #fff;
        padding: 1px 6px;
        border-radius: 4px;
        font-size: .72rem;
        color: #12395B;
        font-family: ui-monospace, monospace;
        border: 1px solid #fde047;
    }

    /* Actions */
    .import-actions {
        padding: 1.25rem 1.5rem;
        background: #fafafa;
        display: flex;
        justify-content: flex-end;
        gap: .6rem;
    }
    .btn-cancel {
        padding: .65rem 1.25rem;
        background: #fff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        color: #334155;
        font-size: .875rem;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
    }
    .btn-cancel:hover { background: #f1f5f9; color: #334155; }

    .btn-submit {
        padding: .65rem 1.4rem;
        background: #12395B;
        border: none;
        border-radius: 8px;
        color: #fff;
        font-family: inherit;
        font-size: .875rem;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        transition: background .15s ease;
    }
    .btn-submit:hover { background: #0d2a43; }
    .btn-submit:disabled { opacity: .55; cursor: not-allowed; }

    @media (max-width: 640px) {
        .template-row { flex-wrap: wrap; }
        .template-row .btn-download { width: 100%; justify-content: center; }
        .import-actions { flex-direction: column-reverse; }
        .btn-cancel, .btn-submit { width: 100%; justify-content: center; }
    }
</style>

<div class="import-wrapper">

    <a href="{{ route('admin.masyarakat') }}" class="btn-back">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Kembali ke Data Masyarakat
    </a>

    <div class="page-header">
        <h1>Import Data Masyarakat</h1>
        <p>Unggah file Excel berisi data warga untuk ditambahkan secara massal ke sistem.</p>
    </div>

    @if (session('error'))
        <div class="alert alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-error">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>{{ $errors->first() }}</span>
        </div>
    @endif

    <div class="import-card">

        <!-- STEP 1: Download template -->
        <div class="import-section">
            <div class="section-label">
                <span class="section-badge">1</span>
                Unduh Template
            </div>

            <div class="template-row">
                <div class="template-row-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <div class="template-row-text">
                    <div class="template-row-title">Template Excel (.xlsx)</div>
                    <div class="template-row-desc">Format kolom sudah disiapkan — cukup isi datanya.</div>
                </div>
                <a href="{{ route('admin.masyarakat.template') }}" class="btn-download">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1M12 12V4m0 0L8 8m4-4l4 4"/>
                    </svg>
                    Unduh
                </a>
            </div>
        </div>

        <!-- STEP 2: Upload -->
        <div class="import-section">
            <div class="section-label">
                <span class="section-badge">2</span>
                Unggah File yang Sudah Diisi
            </div>

            <form action="{{ route('admin.masyarakat.import') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="importForm">

                @csrf

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

        </div>

        <!-- STEP 3: Info format -->
        <div class="import-section">
            <div class="section-label">
                <span class="section-badge">3</span>
                Ketentuan Format
            </div>

            <div class="info-box">
                <strong>Kolom yang diharapkan (baris pertama sebagai header):</strong><br>
                <code>nama</code> · <code>nik</code> · <code>telepon</code> · <code>kecamatan</code> ·
                <code>kelurahan</code> · <code>pendidikan_terakhir</code> · <code>status_pekerjaan</code> ·
                <code>keahlian_minat</code>
                <br><br>
                <strong>Ketentuan:</strong>
                <ul style="margin:.4rem 0 0 1.1rem; padding:0;">
                    <li>Kolom <strong>nama</strong>, <strong>nik</strong>, <strong>kecamatan</strong>, dan <strong>status_pekerjaan</strong> wajib diisi.</li>
                    <li>NIK harus <strong>16 digit</strong> dan belum terdaftar di sistem.</li>
                    <li>Baris yang tidak valid akan <strong>dilewati</strong>, baris lain tetap diproses.</li>
                </ul>
            </div>
        </div>

        <!-- Actions -->
        <div class="import-actions">
            <a href="{{ route('admin.masyarakat') }}" class="btn-cancel">Batal</a>
            <button type="submit" class="btn-submit" id="submitBtn" disabled>
                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                </svg>
                <span id="submitLabel">Import Sekarang</span>
            </button>
        </div>

            </form>

    </div>

</div>

<script>
(function () {
    var dropZone    = document.getElementById('dropZone');
    var fileInput   = document.getElementById('fileInput');
    var filePreview = document.getElementById('filePreview');
    var fileName    = document.getElementById('fileName');
    var fileSize    = document.getElementById('fileSize');
    var fileRemove  = document.getElementById('fileRemove');
    var submitBtn   = document.getElementById('submitBtn');
    var submitLabel = document.getElementById('submitLabel');
    var form        = document.getElementById('importForm');

    function resetFile() {
        fileInput.value = '';
        filePreview.classList.remove('is-visible');
        submitBtn.disabled = true;
    }

    function handleFile() {
        var f = fileInput.files[0];
        if (!f) { resetFile(); return; }
        fileName.textContent = f.name;
        fileSize.textContent = (f.size / 1024).toFixed(0) + ' KB';
        filePreview.classList.add('is-visible');
        submitBtn.disabled = false;
    }

    fileInput.addEventListener('change', handleFile);

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

    fileRemove.addEventListener('click', function (e) {
        e.preventDefault();
        resetFile();
    });

    form.addEventListener('submit', function () {
        if (submitBtn.disabled) return;
        submitBtn.disabled = true;
        submitLabel.textContent = 'Mengimpor...';
    });
})();
</script>
@endsection