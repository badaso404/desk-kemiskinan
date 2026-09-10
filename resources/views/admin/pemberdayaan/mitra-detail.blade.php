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
        <a href="{{ route('admin.mitra.edit', $mitra) }}" class="btn-ghost">Ubah</a>
        <form action="{{ route('admin.mitra.destroy', $mitra) }}" method="POST"
              onsubmit="return confirm('Hapus {{ $mitra->nama }}? Program yang diselenggarakannya tidak ikut terhapus, tapi kehilangan penyelenggara.')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-ghost is-danger">Hapus</button>
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
                                    <a href="{{ route('admin.program.edit', $program) }}" class="btn-link">Ubah</a>
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
