@extends('layouts.admin')

@section('title', 'Pemberdayaan')

@section('content')
@php $tab = request('tab') === 'program' ? 'program' : 'mitra'; @endphp

<div class="page-head">
    <h1>Pemberdayaan</h1>
    <p>Kelola penyelenggara program (UKPD &amp; CSR) dan susun program pelatihan, seminar, serta bimbingan teknis untuk warga.</p>
</div>

@include('admin.partials.notifikasi')

<div class="chip-strip">
    <span class="chip"><strong>{{ $ringkasan['ukpd'] }}</strong> Penyelenggara UKPD</span>
    <span class="chip"><strong>{{ $ringkasan['csr'] }}</strong> Penyelenggara CSR</span>
    <span class="chip"><strong>{{ $ringkasan['program_aktif'] }}</strong> Program aktif</span>
    <span class="chip"><strong>{{ $ringkasan['kursi'] }}</strong> Kursi tersedia</span>
</div>

<div class="tabs">
    <a href="{{ route('admin.pemberdayaan') }}" class="tab {{ $tab === 'mitra' ? 'is-active' : '' }}">
        Penyelenggara ({{ $mitra->count() }})
    </a>
    <a href="{{ route('admin.pemberdayaan', ['tab' => 'program']) }}" class="tab {{ $tab === 'program' ? 'is-active' : '' }}">
        Program ({{ $program->count() }})
    </a>
</div>

@if ($tab === 'mitra')
    <section class="card">
        <div class="card-head">
            <h2>Penyelenggara Program</h2>
            <a href="{{ route('admin.mitra.create') }}" class="btn-primary">+ Tambah Penyelenggara</a>
        </div>

        @if ($mitra->isEmpty())
            <p class="empty-state">Belum ada penyelenggara terdaftar. Tambahkan UKPD atau perusahaan CSR terlebih dahulu.</p>
        @else
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Penyelenggara</th>
                            <th>Jenis</th>
                            <th>Bidang</th>
                            <th>Program</th>
                            <th>Kursi Tersedia</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($mitra as $item)
                            <tr>
                                <td class="cell-nama">{{ $item->nama }}</td>
                                <td><span class="badge badge-{{ strtolower($item->jenis) }}">{{ $item->jenis }}</span></td>
                                <td>{{ $item->bidang ?: '—' }}</td>
                                <td>{{ $item->program->whereIn('status', ['Pendaftaran', 'Berjalan'])->count() }} aktif</td>
                                <td>{{ $item->sisa_kuota }}</td>
                                <td class="cell-aksi">
                                    <a href="{{ route('admin.mitra.show', $item) }}" class="btn-link">Kelola</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@else
    <section class="card">
        <div class="card-head">
            <h2>Program Pemberdayaan</h2>
            <a href="{{ route('admin.program.create') }}" class="btn-primary">+ Tambah Program</a>
        </div>

        @if ($program->isEmpty())
            <p class="empty-state">Belum ada program. Tambahkan pelatihan atau bimbingan teknis untuk warga.</p>
        @else
            <div class="table-scroll">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Program</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Penyelenggara</th>
                            <th>Jadwal</th>
                            <th>Peserta</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($program as $item)
                            <tr>
                                <td class="cell-nama">
                                    {{ $item->nama }}
                                    <small class="cell-sub">Kriteria: {{ $item->kriteria }}</small>
                                </td>
                                <td>{{ $item->jenis }}</td>
                                <td>{{ $item->kategori }}</td>
                                <td>{{ $item->mitra?->nama ?? $item->penyelenggara }}</td>
                                <td>{{ $item->tanggal_mulai->format('d M') }} – {{ $item->tanggal_selesai->format('d M Y') }}</td>
                                <td>
                                    <div class="mini-meter" title="{{ $item->peserta }} dari {{ $item->kuota }} kursi">
                                        <span>{{ $item->peserta }}/{{ $item->kuota }}</span>
                                        <div class="mini-track">
                                            <div class="mini-fill" style="width: {{ $item->persen_terisi }}%"></div>
                                        </div>
                                    </div>
                                </td>
                                <td><span class="badge badge-{{ strtolower($item->status) }}">{{ $item->status }}</span></td>
                                <td class="cell-aksi">
                                    <a href="{{ route('admin.program.edit', $item) }}" class="btn-link" title="Ubah Data">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="#212121" stroke-width="1.8" width="18" height="18"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.program.destroy', $item) }}" method="POST"
                                          onsubmit="return confirm('Hapus program {{ $item->nama }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn-link is-danger" title="Hapus Data">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="#b91c1c" stroke-width="1.8" width="18" height="18"><path d="M3 6h18"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endif
@endsection
