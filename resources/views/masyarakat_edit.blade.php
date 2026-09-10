@extends('layouts.admin')

@section('title', 'Edit Data Masyarakat')

@section('content')
<style>
    .form-wrapper { width: 100%; margin-bottom: 3rem; }
    .form-header-title { font-size: 1.8rem; font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
    .form-header-subtitle { color: #64748b; font-size: 0.95rem; margin-bottom: 2rem; }
    .form-container { background: #ffffff; border-radius: 20px; padding: 2rem; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); }
    .section-title { font-size: 1.2rem; font-weight: 700; color: #0f172a; margin-top: 1.5rem; margin-bottom: 1.5rem; padding-bottom: 0.5rem; border-bottom: 2px solid #f1f5f9; display: flex; align-items: center; gap: 0.5rem; }
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
    .form-group-full { grid-column: span 2; }
    .form-label { display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
    .form-input, .form-select, .form-textarea { width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; background-color: #f8fafc; color: #1e293b; font-size: 0.95rem; outline: none; box-sizing: border-box; transition: all 0.2s ease; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { border-color: #047857; background-color: #fff; box-shadow: 0 0 0 4px rgba(4, 120, 87, 0.1); }
    .radio-flex { display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: center; margin-top: 0.5rem; }
    .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 0.5rem; }
    .custom-option { display: flex; align-items: center; gap: 0.6rem; cursor: pointer; font-size: 0.925rem; color: #334155; }
    .custom-option input { width: 18px; height: 18px; accent-color: #047857; }
    .btn-submit { background-color: #047857; color: #fff; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 600; border: none; cursor: pointer; transition: background 0.2s; }
    .btn-submit:hover { background-color: #065f46; }
    .btn-cancel { background-color: #f1f5f9; color: #475569; padding: 0.85rem 2rem; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-block; transition: background 0.2s; }
    .btn-cancel:hover { background-color: #e2e8f0; }

    @media (max-width: 868px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-group-full { grid-column: span 1; }
    }
</style>

@php
    // Helper untuk konversi array JSON ke PHP Array agar checkbox dapat dibaca
    $bantuanSelected = is_array($masyarakat->bantuan) ? $masyarakat->bantuan : (json_decode($masyarakat->bantuan, true) ?? []);
    $sertifikatSelected = is_array($masyarakat->sertifikat) ? $masyarakat->sertifikat : (json_decode($masyarakat->sertifikat, true) ?? []);
@endphp

<div class="form-wrapper">
    <div>
        <h1 class="form-header-title">Edit Data Masyarakat</h1>
        <p class="form-header-subtitle">Perbarui informasi data warga: <strong>{{ $masyarakat->nama }}</strong> (NIK: {{ $masyarakat->nik }})</p>
    </div>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
            <strong>Terjadi kesalahan saat menyimpan:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <form action="{{ route('admin.masyarakat.update', $masyarakat->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- ==================== BAGIAN 1: IDENTITAS ==================== -->
            <div class="section-title">1. Data Identitas Pribadi</div>
            <div class="form-grid">
                <div>
                    <label class="form-label">Nomor Induk Kependudukan (NIK) *</label>
                    <input type="text" name="nik" class="form-input" value="{{ old('nik', $masyarakat->nik) }}" maxlength="16" required>
                </div>
                <div>
                    <label class="form-label">Nama Lengkap Sesuai KTP *</label>
                    <input type="text" name="nama" class="form-input" value="{{ old('nama', $masyarakat->nama) }}" required>
                </div>
                <div>
                    <label class="form-label">Jenis Kelamin *</label>
                    <div class="radio-flex">
                        <label class="custom-option">
                            <input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', $masyarakat->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}> Laki-laki
                        </label>
                        <label class="custom-option">
                            <input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin', $masyarakat->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}> Perempuan
                        </label>
                    </div>
                </div>
                <div>
                    <label class="form-label">Tanggal Lahir *</label>
                    <input type="date" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir', $masyarakat->tanggal_lahir ? $masyarakat->tanggal_lahir->format('Y-m-d') : '') }}" required>
                </div>
                <div>
                    <label class="form-label">Nomor Handphone (Aktif) *</label>
                    <input type="text" name="telepon" class="form-input" value="{{ old('telepon', $masyarakat->telepon) }}" required>
                </div>
                <div>
                    <label class="form-label">Kecamatan *</label>
                    <select name="kecamatan" class="form-select" required>
                        <option value="">Pilih Kecamatan</option>
                        @foreach(['Cengkareng', 'Grogol Petamburan', 'Kalideres', 'Kebon Jeruk', 'Kembangan', 'Palmerah', 'Taman Sari', 'Tambora'] as $kec)
                            <option value="{{ $kec }}" {{ old('kecamatan', $masyarakat->kecamatan) == $kec ? 'selected' : '' }}>{{ $kec }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Kelurahan / Desa *</label>
                    <input type="text" name="kelurahan" class="form-input" value="{{ old('kelurahan', $masyarakat->kelurahan) }}" required>
                </div>
                <div class="form-group-full">
                    <label class="form-label">Alamat Domisili Lengkap *</label>
                    <textarea name="alamat" class="form-textarea" rows="3" required>{{ old('alamat', $masyarakat->alamat) }}</textarea>
                </div>
            </div>

            <!-- ==================== BAGIAN 2: KONDISI PEKERJAAN ==================== -->
            <div class="section-title">2. Kondisi Pekerjaan</div>
            <div class="form-grid">
                <div>
                    <label class="form-label">Status Pekerjaan Saat Ini *</label>
                    <select name="status_pekerjaan" class="form-select" required>
                        <option value="">Pilih Status Pekerjaan</option>
                        @foreach(['Belum / Tidak Bekerja', 'Pekerja Lepas / Serabutan', 'Terkena PHK', 'Pekerja Sektor Informal'] as $st)
                            <option value="{{ $st }}" {{ old('status_pekerjaan', $masyarakat->status_pekerjaan) == $st ? 'selected' : '' }}>{{ $st }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Lama Menganggur / Mencari Kerja</label>
                    <select name="lama_menganggur" class="form-select">
                        <option value="">Pilih Durasi</option>
                        @foreach(['< 3 Bulan', '3 - 6 Bulan', '6 - 12 Bulan', '> 1 Tahun'] as $durasi)
                            <option value="{{ $durasi }}" {{ old('lama_menganggur', $masyarakat->lama_menganggur) == $durasi ? 'selected' : '' }}>{{ $durasi }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group-full">
                    <label class="form-label">Alasan Utama Tidak Bekerja</label>
                    <select name="alasan_tidak_bekerja" class="form-select">
                        <option value="">Pilih Alasan Utama</option>
                        @foreach(['Pengurangan Tenaga Kerja / PHK', 'Usaha Bangkrut', 'Baru Lulus Sekolah / Kuliah', 'Mengurus Keluarga', 'Keterbatasan Fisik / Kesehatan'] as $alasan)
                            <option value="{{ $alasan }}" {{ old('alasan_tidak_bekerja', $masyarakat->alasan_tidak_bekerja) == $alasan ? 'selected' : '' }}>{{ $alasan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Pengalaman Kerja Terakhir</label>
                    <input type="text" name="pengalaman_terakhir" class="form-input" value="{{ old('pengalaman_terakhir', $masyarakat->pengalaman_terakhir) }}" placeholder="Contoh: Helper Gudang, Staf Admin">
                </div>
                <div>
                    <label class="form-label">Lama Pengalaman Kerja</label>
                    <select name="lama_pengalaman" class="form-select">
                        <option value="">Pilih Durasi Pengalaman</option>
                        @foreach(['Belum Ada Pengalaman', 'Kurang dari 1 Tahun', '1 - 3 Tahun', 'Lebih dari 3 Tahun'] as $exp)
                            <option value="{{ $exp }}" {{ old('lama_pengalaman', $masyarakat->lama_pengalaman) == $exp ? 'selected' : '' }}>{{ $exp }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group-full">
                    <label class="form-label">Tipe Pekerjaan yang Dicari</label>
                    <div class="radio-flex">
                        @foreach(['Full Time', 'Harian / Part Time', 'Wirausaha / UMKM'] as $tipe)
                            <label class="custom-option">
                                <input type="radio" name="tipe_pekerjaan_dicari" value="{{ $tipe }}" {{ old('tipe_pekerjaan_dicari', $masyarakat->tipe_pekerjaan_dicari) == $tipe ? 'checked' : '' }}> {{ $tipe }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ==================== BAGIAN 3: KONDISI EKONOMI ==================== -->
            <div class="section-title">3. Kondisi Ekonomi</div>
            <div class="form-grid">
                <div class="form-group-full">
                    <label class="form-label">Status Terdaftar Data Kemiskinan</label>
                    <div class="radio-flex">
                        @foreach(['Terdaftar DTKS', 'Terdaftar P3KE', 'Belum Terdaftar'] as $dtks)
                            <label class="custom-option">
                                <input type="radio" name="status_dtks" value="{{ $dtks }}" {{ old('status_dtks', $masyarakat->status_dtks) == $dtks ? 'checked' : '' }}> {{ $dtks }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div>
                    <label class="form-label">Rata-rata Pendapatan / Bulan</label>
                    <select name="pendapatan_bulanan" class="form-select">
                        <option value="">Pilih Kisaran Pendapatan</option>
                        @foreach(['Tidak Ada Pendapatan', '< Rp 1.000.000', 'Rp 1.000.000 - Rp 2.500.000', '> Rp 2.500.000'] as $gaji)
                            <option value="{{ $gaji }}" {{ old('pendapatan_bulanan', $masyarakat->pendapatan_bulanan) == $gaji ? 'selected' : '' }}>{{ $gaji }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Jumlah Tanggungan Keluarga</label>
                    <input type="number" name="jumlah_tanggungan" class="form-input" value="{{ old('jumlah_tanggungan', $masyarakat->jumlah_tanggungan ?? 0) }}" min="0">
                </div>
                <div>
                    <label class="form-label">Kepemilikan Tempat Tinggal</label>
                    <select name="status_rumah" class="form-select">
                        <option value="">Pilih Status Tempat Tinggal</option>
                        @foreach(['Milik Sendiri', 'Sewa / Kontrak', 'Menumpang Saudara'] as $rumah)
                            <option value="{{ $rumah }}" {{ old('status_rumah', $masyarakat->status_rumah) == $rumah ? 'selected' : '' }}>{{ $rumah }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group-full">
                    <label class="form-label">Bantuan Pemerintah yang Sedang Diterima</label>
                    <div class="checkbox-grid">
                        @foreach(['PKH', 'BPNT', 'KJP Plus', 'Kartu Prakerja'] as $bnt)
                            <label class="custom-option">
                                <input type="checkbox" name="bantuan[]" value="{{ $bnt }}" {{ in_array($bnt, old('bantuan', $bantuanSelected)) ? 'checked' : '' }}> {{ $bnt }}
                            </label>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- ==================== BAGIAN 4: PENDIDIKAN & KEMAMPUAN ==================== -->
            <div class="section-title">4. Pendidikan & Kemampuan</div>
            <div class="form-grid">
                <div>
                    <label class="form-label">Pendidikan Terakhir *</label>
                    <select name="pendidikan_terakhir" class="form-select" required>
                        <option value="">Pilih Pendidikan Terakhir</option>
                        @foreach(['Tidak Tamat SD', 'SD / Sederajat', 'SMP / Sederajat', 'SMA / SMK Sederajat', 'Diploma (D3)', 'Sarjana (S1)'] as $pd)
                            <option value="{{ $pd }}" {{ old('pendidikan_terakhir', $masyarakat->pendidikan_terakhir) == $pd ? 'selected' : '' }}>{{ $pd }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Jurusan / Bidang Keahlian Sekolah</label>
                    <input type="text" name="jurusan" class="form-input" value="{{ old('jurusan', $masyarakat->jurusan) }}" placeholder="Isi jika ada, contoh: Otomotif">
                </div>
                <div class="form-group-full">
                    <label class="form-label">Keahlian Utama (Pisahkan dengan koma) *</label>
                    <input type="text" name="keahlian" class="form-input" value="{{ old('keahlian', $masyarakat->keahlian) }}" placeholder="Contoh: Mengemudi, Las Listrik, Administrasi" required>
                </div>
                <div class="form-group-full">
                    <label class="form-label">Kepemilikan SIM / Sertifikat</label>
                    <div class="checkbox-grid">
                        @foreach(['SIM A', 'SIM B1/B2', 'SIM C', 'Sertifikat BNSP'] as $sert)
                            <label class="custom-option">
                                <input type="checkbox" name="sertifikat[]" value="{{ $sert }}" {{ in_array($sert, old('sertifikat', $sertifikatSelected)) ? 'checked' : '' }}> {{ $sert }}
                            </label>
                        @endforeach
                    </div>
                </div>
                <div class="form-group-full">
                    <label class="form-label">Minat Pelatihan Vokasi (Disnaker)</label>
                    <select name="minat_pelatihan" class="form-select">
                        <option value="">Pilih Jenis Pelatihan yang Diminati</option>
                        @foreach(['Teknik Otomotif / Perbaikan Motor', 'Teknik Las & Manufaktur', 'Tata Boga / Kuliner', 'Tata Busana / Menjahit', 'Komputer & Digital Marketing'] as $lat)
                            <option value="{{ $lat }}" {{ old('minat_pelatihan', $masyarakat->minat_pelatihan) == $lat ? 'selected' : '' }}>{{ $lat }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- FOOTER AKSI -->
            <div style="display: flex; gap: 1rem; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9;">
                <button type="submit" class="btn-submit">Simpan Perubahan</button>
                <a href="{{ route('admin.masyarakat') }}" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection