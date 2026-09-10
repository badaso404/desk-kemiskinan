@extends('layouts.admin')

@section('title', 'Rekomendasi Program')

@section('content')
<div class="page-head">
    <h1>Rekomendasi Program</h1>
    <p>Usulan pencocokan warga dengan program pelatihan, seminar, dan bimbingan teknis yang sesuai kriterianya.</p>
</div>

<div class="chip-strip">
    <span class="chip"><strong>{{ $usulan->count() }}</strong> Usulan</span>
    <span class="chip"><strong>{{ $jumlahProgram }}</strong> Program aktif</span>
</div>

<form method="GET" class="card filter-card">
    <div class="form-grid">
        <div class="field field-wide">
            <label for="cari">Cari Warga</label>
            <input type="text" id="cari" name="cari" value="{{ $cari }}" placeholder="Nama atau NIK">
        </div>
        <div class="field">
            <label for="kecamatan">Kecamatan</label>
            <select id="kecamatan" name="kecamatan">
                <option value="">Semua Kecamatan</option>
                @foreach ($daftarKecamatan as $nama)
                    <option value="{{ $nama }}" @selected($kecamatan === $nama)>{{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="field">
            <label for="jenis">Jenis Kegiatan</label>
            <select id="jenis" name="jenis">
                <option value="">Semua Jenis</option>
                @foreach (['Pelatihan', 'Seminar', 'Bimbingan Teknis', 'Workshop'] as $pilihan)
                    <option value="{{ $pilihan }}" @selected($jenis === $pilihan)>{{ $pilihan }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn-primary">Terapkan</button>
        <a href="{{ route('admin.rekomendasi.index') }}" class="btn-ghost">Reset</a>
    </div>
</form>

<section class="card">
    <div class="card-head">
        <h2>Usulan Pencocokan</h2>
    </div>

    @if ($usulan->isEmpty())
        <p class="empty-state">
            Belum ada pasangan yang cocok. Pastikan data warga sudah terisi keahlian atau minat pelatihannya,
            dan sudah ada program dengan kriteria yang sesuai di menu Pemberdayaan.
        </p>
    @else
        <div class="table-scroll">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Warga</th>
                        <th>Kecamatan</th>
                        <th>Program Paling Cocok</th>
                        <th>Penyelenggara</th>
                        <th>Kriteria Cocok</th>
                        <th>Skor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($usulan as $baris)
                        @php $program = $baris['program']; @endphp
                        <tr>
                            <td class="cell-nama">
                                {{ $baris['warga']->nama }}
                                <small class="cell-sub">{{ $baris['warga']->nik }}</small>
                            </td>
                            <td>{{ $baris['warga']->kecamatan }}</td>
                            <td>
                                {{ $program->nama }}
                                <small class="cell-sub">{{ $program->jenis }} &middot; {{ $program->lokasi }}</small>
                            </td>
                            <td>
                                @if ($program->mitra)
                                    <span class="badge badge-{{ strtolower($program->mitra->jenis) }}">{{ $program->mitra->jenis }}</span>
                                @endif
                                <small class="cell-sub">{{ $program->mitra?->nama ?? $program->penyelenggara }}</small>
                            </td>
                            <td>
                                <div class="tag-row">
                                    @foreach ($baris['kriteria_cocok'] as $kriteria)
                                        <span class="tag">{{ $kriteria }}</span>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="skor">
                                    <span>{{ $baris['skor'] }}%</span>
                                    <div class="mini-track">
                                        <div class="mini-fill" style="width: {{ $baris['skor'] }}%"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="cell-aksi">
                                <a href="{{ route('admin.rekomendasi.show', $baris['warga']) }}" class="btn-link">Detail</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</section>
@endsection
