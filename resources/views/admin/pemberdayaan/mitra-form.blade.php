@extends('layouts.admin')

@php $baru = ! $mitra->exists; @endphp

@section('title', $baru ? 'Tambah Penyelenggara' : 'Ubah Penyelenggara')

@section('content')
<a href="{{ route('admin.pemberdayaan') }}" class="link-back">&larr; Kembali ke Pemberdayaan</a>

<div class="page-head">
    <h1>{{ $baru ? 'Tambah Penyelenggara' : 'Ubah Penyelenggara' }}</h1>
    <p>Penyelenggara adalah UKPD (unit kerja pemerintah daerah) atau perusahaan CSR yang menyelenggarakan program untuk warga.</p>
</div>

@include('admin.partials.notifikasi')

<form method="POST" action="{{ $baru ? route('admin.mitra.store') : route('admin.mitra.update', $mitra) }}" class="card form-card">
    @csrf
    @unless ($baru) @method('PUT') @endunless

    <div class="form-grid">
        <div class="field field-wide">
            <label for="nama">Nama Penyelenggara</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama', $mitra->nama) }}"
                   placeholder="Contoh: Perumda Pasar Jaya" required>
        </div>

        <div class="field">
            <label for="jenis">Jenis</label>
            <select id="jenis" name="jenis" required>
                @foreach (['UKPD', 'CSR'] as $pilihan)
                    <option value="{{ $pilihan }}" @selected(old('jenis', $mitra->jenis) === $pilihan)>{{ $pilihan }}</option>
                @endforeach
            </select>
        </div>

        <div class="field">
            <label for="bidang">Bidang Usaha</label>
            <input type="text" id="bidang" name="bidang" value="{{ old('bidang', $mitra->bidang) }}"
                   placeholder="Contoh: Logistik">
        </div>

        <div class="field">
            <label for="narahubung">Narahubung</label>
            <input type="text" id="narahubung" name="narahubung" value="{{ old('narahubung', $mitra->narahubung) }}"
                   placeholder="Nama petugas yang bisa dihubungi">
        </div>

        <div class="field">
            <label for="telepon">Telepon</label>
            <input type="text" id="telepon" name="telepon" value="{{ old('telepon', $mitra->telepon) }}"
                   placeholder="021xxxxxxx">
        </div>

        <div class="field field-wide">
            <label for="alamat">Alamat</label>
            <textarea id="alamat" name="alamat" rows="3" placeholder="Alamat kantor mitra">{{ old('alamat', $mitra->alamat) }}</textarea>
        </div>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn-primary">{{ $baru ? 'Simpan Penyelenggara' : 'Simpan Perubahan' }}</button>
        <a href="{{ route('admin.pemberdayaan') }}" class="btn-ghost">Batal</a>
    </div>
</form>
@endsection
