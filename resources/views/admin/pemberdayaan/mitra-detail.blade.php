@extends('layouts.admin')

@section('title', $mitra->nama)

@section('content')
<a href="{{ route('admin.pemberdayaan') }}" class="link-back">&larr; Kembali ke Pemberdayaan</a>

<div class="page-head page-head-row">
    <div>
        <span class="badge badge-{{ strtolower($mitra->jenis) }}">{{ $mitra->jenis }}</span>
        <h1>{{ $mitra->nama }}</h1>
        <p>{{ $mitra->bidang ?: 'Bidang belum diisi' }}</p>
    </div>
    <div class="cell-aksi">
        <a href="{{ route('admin.mitra.edit', $mitra) }}" class="btn-icon" title="Ubah Penyelenggara" aria-label="Ubah penyelenggara {{ $mitra->nama }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
            </svg>
        </a>
        <form action="{{ route('admin.mitra.destroy', $mitra) }}" method="POST"
              onsubmit="return confirm('Hapus {{ $mitra->nama }}? Program yang diselenggarakannya tidak ikut terhapus, tapi kehilangan penyelenggara.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-icon is-danger" title="Hapus Penyelenggara" aria-label="Hapus penyelenggara {{ $mitra->nama }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true">
                    <path d="M3 6h18"/>
                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
            </button>
        </form>
    </div>
</div>

@include('admin.partials.notifikasi')

<div class="grid-side">
    <aside class="card">
        <h2>Informasi Penyelenggara</h2>
        <dl class="detail-facts">
            <div><dt>Narahubung</dt><dd>{{ $mitra->narahubung ?: '—' }}</dd></div>
            <div><dt>Telepon</dt><dd>{{ $mitra->telepon ?: '—' }}</dd></div>
            <div><dt>Alamat</dt><dd>{{ $mitra->alamat ?: '—' }}</dd></div>
            <div><dt>Program aktif</dt><dd>{{ $mitra->program->whereIn('status', ['Pendaftaran', 'Berjalan'])->count() }}</dd></div>
            <div><dt>Kursi tersedia</dt><dd>{{ $mitra->sisa_kuota }}</dd></div>
        </dl>
    </aside>

    <section class="card">
        <div class="card-head">
            <h2>Program yang Diselenggarakan</h2>
            <a href="{{ route('admin.program.create', ['mitra' => $mitra->id]) }}" class="btn-primary">+ Tambah Program</a>
        </div>

        @if ($mitra->program->isEmpty())
            <p class="empty-state">
                Belum ada program dari penyelenggara ini. Tambahkan pelatihan, seminar, atau bimbingan teknis.
            </p>
        @else
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Program</th>
                            <th>Jenis</th>
                            <th>Jadwal</th>
                            <th>Peserta</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mitra->program as $program)
                            <tr>
                                <td class="cell-nama">
                                    {{ $program->nama }}
                                    <small class="cell-sub">{{ $program->lokasi }}</small>
                                </td>
                                <td>{{ $program->jenis }}</td>
                                <td>{{ $program->tanggal_mulai->format('d M') }} – {{ $program->tanggal_selesai->format('d M Y') }}</td>
                                <td>{{ $program->peserta }}/{{ $program->kuota }}</td>
                                <td><span class="badge badge-{{ strtolower($program->status) }}">{{ $program->status }}</span></td>
                                <td class="cell-aksi">
                                    <a href="{{ route('admin.program.show', $program) }}" class="btn-icon" title="Lihat Detail" aria-label="Lihat detail {{ $program->nama }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true">
                                            <path d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"/>
                                            <circle cx="12" cy="12" r="2.5"/>
                                        </svg>
                                    </a>
                                    <a href="{{ route('admin.program.edit', $program) }}" class="btn-icon" title="Ubah Program" aria-label="Ubah program {{ $program->nama }}">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" width="18" height="18" aria-hidden="true">
                                            <path d="M12 20h9"/>
                                            <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
</div>
@endsection
