@extends('layouts.admin')

@php $baru = ! $program->exists; @endphp

@section('title', $baru ? 'Tambah Program' : 'Ubah Program')

@section('content')
<a href="{{ route('admin.pemberdayaan', ['tab' => 'program']) }}" class="link-back">&larr; Kembali ke Pemberdayaan</a>

<div class="page-head">
    <h1>{{ $baru ? 'Tambah Program' : 'Ubah Program' }}</h1>
    <p>Pelatihan, seminar, atau bimbingan teknis untuk meningkatkan keahlian warga.</p>
</div>

@include('admin.partials.notifikasi')

<form method="POST" action="{{ $baru ? route('admin.program.store') : route('admin.program.update', $program) }}" class="card form-card">
    @csrf
    @unless ($baru) @method('PUT') @endunless

    <div class="form-grid">
        <div class="field field-wide">
            <label for="nama">Nama Program</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $program->nama) }}"
                   placeholder="Contoh: Pelatihan Menjahit Tingkat Dasar" required>
        </div>

        <div class="field">
            <label for="jenis">Jenis Kegiatan</label>
            <select id="jenis" name="jenis" required>
                @foreach (['Pelatihan', 'Seminar', 'Bimbingan Teknis', 'Workshop'] as $pilihan)
                    <option value="{{ $pilihan }}" @selected(old('jenis', $program->jenis) === $pilihan)>{{ $pilihan }}</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="kategori">Kategori</label>
            <input type="text" id="kategori" name="kategori" value="{{ old('kategori', $program->kategori) }}"
                   placeholder="Contoh: Keterampilan" required>
        </div>

        <div class="field">
            <label for="mitra_id">Penyelenggara Mitra <span class="opsional">(opsional)</span></label>
            <select id="mitra_id" name="mitra_id">
                <option value="">— Diselenggarakan Pemkot sendiri —</option>
                @foreach ($daftarMitra as $item)
                    <option value="{{ $item->id }}" @selected((int) old('mitra_id', $program->mitra_id ?? request('mitra')) === $item->id)>
                        {{ $item->nama }} ({{ $item->jenis }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="penyelenggara">Penyelenggara</label>
            <input type="text" id="penyelenggara" name="penyelenggara" value="{{ old('penyelenggara', $program->penyelenggara) }}"
                   placeholder="Contoh: Pusat Pelatihan Kerja Daerah" required>
        </div>

        <div class="field">
            <label for="lokasi">Lokasi</label>
            <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi', $program->lokasi) }}"
                   placeholder="Contoh: PPKD Jakarta Barat" required>
        </div>

        <div class="field">
            <label for="tanggal_mulai">Tanggal Mulai</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                   value="{{ old('tanggal_mulai', $program->tanggal_mulai?->format('Y-m-d')) }}" required>
        </div>

        <div class="field">
            <label for="tanggal_selesai">Tanggal Selesai</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai"
                   value="{{ old('tanggal_selesai', $program->tanggal_selesai?->format('Y-m-d')) }}" required>
        </div>

        <div class="field">
            <label for="kuota">Kuota Peserta</label>
            <input type="number" id="kuota" name="kuota" value="{{ old('kuota', $program->kuota ?: 20) }}" min="1" required>
        </div>

        <div class="field">
            <label for="peserta">Peserta Terdaftar</label>
            <input type="number" id="peserta" name="peserta" value="{{ old('peserta', $program->peserta ?? 0) }}" min="0">
        </div>

        <div class="field">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                @foreach (['Pendaftaran', 'Berjalan', 'Selesai'] as $pilihan)
                    <option value="{{ $pilihan }}" @selected(old('status', $program->status) === $pilihan)>{{ $pilihan }}</option>
                @endforeach
            </select>
        </div>

        <div class="field field-wide">
            <label for="kriteria">Kriteria Peserta</label>
            <input type="text" id="kriteria" name="kriteria" value="{{ old('kriteria', $program->kriteria) }}"
                   placeholder="Pisahkan dengan koma, contoh: menjahit, keterampilan tangan" required>
            <small>Dicocokkan dengan keahlian dan minat pelatihan warga oleh modul Rekomendasi.</small>
        </div>

        <div class="field field-wide">
            <label for="keahlian_dihasilkan">Keahlian yang Dihasilkan <span class="opsional">(opsional)</span></label>
            <input type="text" id="keahlian_dihasilkan" name="keahlian_dihasilkan"
                   value="{{ old('keahlian_dihasilkan', $program->keahlian_dihasilkan) }}"
                   placeholder="Contoh: menjahit, pola dasar">
            <small>Keahlian ini ditambahkan ke profil warga setelah ia dinyatakan lulus.</small>
        </div>

        <div class="field field-wide">
            <label for="deskripsi">Deskripsi <span class="opsional">(opsional)</span></label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
                      placeholder="Ringkasan materi dan sasaran program">{{ old('deskripsi', $program->deskripsi) }}</textarea>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">{{ $baru ? 'Simpan Program' : 'Simpan Perubahan' }}</button>
        <a href="{{ route('admin.pemberdayaan', ['tab' => 'program']) }}" class="btn-ghost">Batal</a>
    </div>
</form>
@endsection
