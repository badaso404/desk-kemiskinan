@extends('layouts.admin')

@section('title', 'Tambah Data Masyarakat')

@section('content')
<style>
    .form-wrapper { width: 100%; margin-bottom: 3rem; }
    .form-header-title { font-size: clamp(1.5rem, 2.5vw, 2.25rem); font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
    .form-header-subtitle { color: #64748b; font-size: clamp(0.875rem, 1.2vw, 1rem); margin-bottom: 2rem; }
    .form-container { background: #ffffff; border-radius: 20px; padding: clamp(1.25rem, 3vw, 2.5rem); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); width: 100%; box-sizing: border-box; }
    
    /* STEPPER */
    .stepper-wrapper { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; width: 100%; gap: 0.5rem; }
    .step-item { display: flex; flex-direction: column; align-items: center; flex: 1; text-align: center; }
    .step-number { width: 44px; height: 44px; border-radius: 50%; background-color: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1rem; margin-bottom: 0.6rem; transition: all 0.3s ease; }
    .step-label { font-size: 0.825rem; font-weight: 600; color: #94a3b8; }
    .step-item.active .step-number { background-color: #12395B; color: #ffffff; box-shadow: 0 0 0 5px rgba(18, 57, 91, 0.15); }
    .step-item.active .step-label { color: #12395B; font-weight: 700; }
    .step-item.completed .step-number { background-color: #059669; color: #ffffff; }

    /* FORM PANEL */
    .form-step { display: none; animation: fadeIn 0.3s ease-in-out; }
    .form-step-active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    .section-title { font-size: 1.15rem; font-weight: 700; color: #12395B; display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9; }
    
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem 2rem; width: 100%; }
    .form-group-full { grid-column: span 2; }
    .form-label { display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
    .form-input, .form-select, .form-textarea { width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; background-color: #f8fafc; color: #1e293b; font-size: 0.95rem; outline: none; box-sizing: border-box; transition: all 0.2s ease; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { background-color: #ffffff; border-color: #12395B; box-shadow: 0 0 0 4px rgba(18, 57, 91, 0.1); }
    .is-invalid { border-color: #ef4444 !important; background-color: #fef2f2 !important; }
    .radio-flex { display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: center; margin-top: 0.5rem; }
    .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 0.5rem; }
    .custom-option { display: flex; align-items: center; gap: 0.6rem; cursor: pointer; font-size: 0.925rem; color: #334155; }
    .custom-option input { width: 18px; height: 18px; accent-color: #12395B; }

    /* REVIEW & SIMPAN (STEP 5 STYLING) */
    .review-card { background: #f8fafc; border-radius: 14px; border: 1px solid #e2e8f0; padding: 1.5rem; margin-bottom: 2rem; }
    .review-row { display: flex; justify-content: space-between; align-items: center; padding: 0.85rem 0; border-bottom: 1px solid #e2e8f0; font-size: 0.925rem; }
    .review-row:last-child { border-bottom: none; }
    .review-label { color: #64748b; font-weight: 500; }
    .review-value { color: #0f172a; font-weight: 700; text-align: right; max-width: 65%; word-break: break-word; }
    
    .review-submit-buttons { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; margin-top: 1.5rem; }
    .btn-submit-verify { background-color: #12395B; color: #ffffff; padding: 1rem; border-radius: 12px; font-weight: 700; font-size: 0.975rem; border: none; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 12px rgba(18, 57, 91, 0.2); }
    .btn-submit-verify:hover { background-color: #0d2a43; transform: translateY(-1px); }
    .btn-submit-later { background-color: #ffffff; color: #1e293b; border: 1.5px solid #cbd5e1; padding: 1rem; border-radius: 12px; font-weight: 700; font-size: 0.975rem; cursor: pointer; transition: all 0.2s ease; }
    .btn-submit-later:hover { background-color: #f1f5f9; border-color: #94a3b8; }

    /* ACTIONS NAV */
    .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; }
    .btn-step { padding: 0.85rem 2rem; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease; }
    .btn-prev { background-color: #f1f5f9; color: #64748b; }
    .btn-prev:hover { color: #1e293b; background-color: #e2e8f0; }
    .btn-next { background-color: #12395B; color: #ffffff; }
    .btn-next:hover { background-color: #0d2a43; }
    .btn-disabled { opacity: 0.5; cursor: not-allowed; }

    @media (max-width: 868px) { 
        .form-grid { grid-template-columns: 1fr; } 
        .form-group-full { grid-column: span 1; }
        .review-submit-buttons { grid-template-columns: 1fr; gap: 0.8rem; }
        .stepper-wrapper { overflow-x: auto; padding-bottom: 0.5rem; }
    }
</style>

<div class="form-wrapper">
    <div>
        <h1 class="form-header-title">Input Data Masyarakat</h1>
        <p class="form-header-subtitle">Tambahkan data warga baru ke dalam sistem untuk evaluasi program kesejahteraan.</p>
    </div>

    @if ($errors->any())
        <div style="background: #fef2f2; border: 1px solid #fca5a5; color: #991b1b; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem;">
            <strong>Terjadi kesalahan:</strong>
            <ul style="margin-top: 0.5rem; padding-left: 1.25rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-container">
        <!-- STEPPER HEADERS (5 STEPS) -->
        <div class="stepper-wrapper">
            <div class="step-item active" id="step-node-1"><div class="step-number">1</div><div class="step-label">Identitas</div></div>
            <div class="step-item" id="step-node-2"><div class="step-number">2</div><div class="step-label">Pekerjaan</div></div>
            <div class="step-item" id="step-node-3"><div class="step-number">3</div><div class="step-label">Ekonomi</div></div>
            <div class="step-item" id="step-node-4"><div class="step-number">4</div><div class="step-label">Kemampuan</div></div>
            <div class="step-item" id="step-node-5"><div class="step-number">5</div><div class="step-label">Review</div></div>
        </div>

        <form id="multiStepForm" action="{{ route('admin.masyarakat.store') }}" method="POST">
            @csrf
            
            <!-- INPUT HIDDEN STATUS VERIFIKASI -->
            <input type="hidden" name="status_verifikasi" id="status_verifikasi_input" value="Pending">

            <!-- STEP 1: IDENTITAS -->
            <div class="form-step form-step-active" id="step-1">
                <div class="section-title">Data Identitas Pribadi</div>
                <div class="form-grid">
                    <div>
                        <label class="form-label">Nomor Induk Kependudukan (NIK) *</label>
                        <input type="text" name="nik" class="form-input" placeholder="Masukkan 16 digit NIK" maxlength="16" value="{{ old('nik') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Nama Lengkap Sesuai KTP *</label>
                        <input type="text" name="nama" class="form-input" placeholder="Contoh: Budi Santoso" value="{{ old('nama') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Jenis Kelamin *</label>
                        <div class="radio-flex">
                            <label class="custom-option"><input type="radio" name="jenis_kelamin" value="Laki-laki" {{ old('jenis_kelamin', 'Laki-laki') == 'Laki-laki' ? 'checked' : '' }}> Laki-laki</label>
                            <label class="custom-option"><input type="radio" name="jenis_kelamin" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}> Perempuan</label>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" class="form-input" value="{{ old('tanggal_lahir') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Nomor Handphone (Aktif) *</label>
                        <input type="text" name="telepon" class="form-input" placeholder="081234567890" value="{{ old('telepon') }}" required>
                    </div>
                    <div>
                        <label class="form-label">Kecamatan *</label>
                        <select name="kecamatan" id="kecamatanSelect" class="form-select" onchange="updateKelurahanOptions()" required>
                            <option value="">Pilih Kecamatan</option>
                            <option value="Cengkareng" {{ old('kecamatan') == 'Cengkareng' ? 'selected' : '' }}>Cengkareng</option>
                            <option value="Grogol Petamburan" {{ old('kecamatan') == 'Grogol Petamburan' ? 'selected' : '' }}>Grogol Petamburan</option>
                            <option value="Kalideres" {{ old('kecamatan') == 'Kalideres' ? 'selected' : '' }}>Kalideres</option>
                            <option value="Kebon Jeruk" {{ old('kecamatan') == 'Kebon Jeruk' ? 'selected' : '' }}>Kebon Jeruk</option>
                            <option value="Kembangan" {{ old('kecamatan') == 'Kembangan' ? 'selected' : '' }}>Kembangan</option>
                            <option value="Palmerah" {{ old('kecamatan') == 'Palmerah' ? 'selected' : '' }}>Palmerah</option>
                            <option value="Taman Sari" {{ old('kecamatan') == 'Taman Sari' ? 'selected' : '' }}>Taman Sari</option>
                            <option value="Tambora" {{ old('kecamatan') == 'Tambora' ? 'selected' : '' }}>Tambora</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kelurahan / Desa *</label>
                        <select name="kelurahan" id="kelurahanSelect" class="form-select" required>
                            <option value="">Pilih Kecamatan Terlebih Dahulu</option>
                        </select>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Alamat Domisili Lengkap *</label>
                        <textarea name="alamat" class="form-textarea" rows="3" placeholder="Nama jalan, RT/RW, nomor rumah..." required>{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- STEP 2: PEKERJAAN -->
            <div class="form-step" id="step-2">
                <div class="section-title">Kondisi Pekerjaan</div>
                <div class="form-grid">
                    <div>
                        <label class="form-label">Status Pekerjaan Saat Ini *</label>
                        <select name="status_pekerjaan" class="form-select" required>
                            <option value="">Pilih Status Pekerjaan</option>
                            <option value="Belum / Tidak Bekerja" {{ old('status_pekerjaan') == 'Belum / Tidak Bekerja' ? 'selected' : '' }}>Belum / Tidak Bekerja</option>
                            <option value="Pekerja Lepas / Serabutan" {{ old('status_pekerjaan') == 'Pekerja Lepas / Serabutan' ? 'selected' : '' }}>Pekerja Lepas / Serabutan</option>
                            <option value="Terkena PHK" {{ old('status_pekerjaan') == 'Terkena PHK' ? 'selected' : '' }}>Terkena PHK</option>
                            <option value="Pekerja Sektor Informal" {{ old('status_pekerjaan') == 'Pekerja Sektor Informal' ? 'selected' : '' }}>Pekerja Sektor Informal</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Lama Menganggur / Mencari Kerja</label>
                        <select name="lama_menganggur" class="form-select">
                            <option value="">Pilih Durasi</option>
                            <option value="< 3 Bulan" {{ old('lama_menganggur') == '< 3 Bulan' ? 'selected' : '' }}>< 3 Bulan</option>
                            <option value="3 - 6 Bulan" {{ old('lama_menganggur') == '3 - 6 Bulan' ? 'selected' : '' }}>3 – 6 Bulan</option>
                            <option value="6 - 12 Bulan" {{ old('lama_menganggur') == '6 - 12 Bulan' ? 'selected' : '' }}>6 – 12 Bulan</option>
                            <option value="> 1 Tahun" {{ old('lama_menganggur') == '> 1 Tahun' ? 'selected' : '' }}>> 1 Tahun</option>
                        </select>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Alasan Utama Tidak Bekerja</label>
                        <select name="alasan_tidak_bekerja" class="form-select">
                            <option value="">Pilih Alasan Utama</option>
                            <option value="Pengurangan Tenaga Kerja / PHK" {{ old('alasan_tidak_bekerja') == 'Pengurangan Tenaga Kerja / PHK' ? 'selected' : '' }}>Pengurangan Tenaga Kerja / PHK</option>
                            <option value="Usaha Bangkrut" {{ old('alasan_tidak_bekerja') == 'Usaha Bangkrut' ? 'selected' : '' }}>Usaha Bangkrut</option>
                            <option value="Baru Lulus Sekolah / Kuliah" {{ old('alasan_tidak_bekerja') == 'Baru Lulus Sekolah / Kuliah' ? 'selected' : '' }}>Baru Lulus Sekolah / Kuliah</option>
                            <option value="Mengurus Keluarga" {{ old('alasan_tidak_bekerja') == 'Mengurus Keluarga' ? 'selected' : '' }}>Mengurus Keluarga</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Pengalaman Kerja Terakhir</label>
                        <input type="text" name="pengalaman_terakhir" class="form-input" placeholder="Contoh: Helper Gudang, Staf Admin" value="{{ old('pengalaman_terakhir') }}">
                    </div>
                    <div>
                        <label class="form-label">Lama Pengalaman Kerja</label>
                        <select name="lama_pengalaman" class="form-select">
                            <option value="">Pilih Durasi Pengalaman</option>
                            <option value="Belum Ada Pengalaman" {{ old('lama_pengalaman') == 'Belum Ada Pengalaman' ? 'selected' : '' }}>Belum Ada Pengalaman</option>
                            <option value="Kurang dari 1 Tahun" {{ old('lama_pengalaman') == 'Kurang dari 1 Tahun' ? 'selected' : '' }}>Kurang dari 1 Tahun</option>
                            <option value="1 - 3 Tahun" {{ old('lama_pengalaman') == '1 - 3 Tahun' ? 'selected' : '' }}>1 – 3 Tahun</option>
                            <option value="Lebih dari 3 Tahun" {{ old('lama_pengalaman') == 'Lebih dari 3 Tahun' ? 'selected' : '' }}>Lebih dari 3 Tahun</option>
                        </select>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Tipe Pekerjaan yang Dicari</label>
                        <div class="radio-flex">
                            <label class="custom-option"><input type="radio" name="tipe_pekerjaan_dicari" value="Full Time" {{ old('tipe_pekerjaan_dicari', 'Full Time') == 'Full Time' ? 'checked' : '' }}> Full Time</label>
                            <label class="custom-option"><input type="radio" name="tipe_pekerjaan_dicari" value="Harian / Part Time" {{ old('tipe_pekerjaan_dicari') == 'Harian / Part Time' ? 'checked' : '' }}> Harian / Part Time</label>
                            <label class="custom-option"><input type="radio" name="tipe_pekerjaan_dicari" value="Wirausaha / UMKM" {{ old('tipe_pekerjaan_dicari') == 'Wirausaha / UMKM' ? 'checked' : '' }}> Wirausaha / UMKM</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3: EKONOMI -->
            <div class="form-step" id="step-3">
                <div class="section-title">Kondisi Ekonomi</div>
                <div class="form-grid">
                    <div class="form-group-full">
                        <label class="form-label">Status Terdaftar Data Kemiskinan</label>
                        <div class="radio-flex">
                            <label class="custom-option"><input type="radio" name="status_dtks" value="Terdaftar DTKS" {{ old('status_dtks', 'Terdaftar DTKS') == 'Terdaftar DTKS' ? 'checked' : '' }}> Terdaftar DTKS</label>
                            <label class="custom-option"><input type="radio" name="status_dtks" value="Terdaftar P3KE" {{ old('status_dtks') == 'Terdaftar P3KE' ? 'checked' : '' }}> Terdaftar P3KE</label>
                            <label class="custom-option"><input type="radio" name="status_dtks" value="Belum Terdaftar" {{ old('status_dtks') == 'Belum Terdaftar' ? 'checked' : '' }}> Belum Terdaftar</label>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Rata-rata Pendapatan / Bulan</label>
                        <select name="pendapatan_bulanan" class="form-select">
                            <option value="">Pilih Kisaran Pendapatan</option>
                            <option value="Tidak Ada Pendapatan" {{ old('pendapatan_bulanan') == 'Tidak Ada Pendapatan' ? 'selected' : '' }}>Tidak Ada Pendapatan</option>
                            <option value="< Rp 1.000.000" {{ old('pendapatan_bulanan') == '< Rp 1.000.000' ? 'selected' : '' }}>< Rp 1.000.000</option>
                            <option value="Rp 1.000.000 - Rp 2.500.000" {{ old('pendapatan_bulanan') == 'Rp 1.000.000 - Rp 2.500.000' ? 'selected' : '' }}>Rp 1.000.000 – Rp 2.500.000</option>
                            <option value="> Rp 2.500.000" {{ old('pendapatan_bulanan') == '> Rp 2.500.000' ? 'selected' : '' }}>> Rp 2.500.000</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Jumlah Tanggungan Keluarga</label>
                        <input type="number" name="jumlah_tanggungan" class="form-input" placeholder="Contoh: 3" min="0" value="{{ old('jumlah_tanggungan', 0) }}">
                    </div>
                    <div>
                        <label class="form-label">Kepemilikan Tempat Tinggal</label>
                        <select name="status_rumah" class="form-select">
                            <option value="">Pilih Status Tempat Tinggal</option>
                            <option value="Milik Sendiri" {{ old('status_rumah') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                            <option value="Sewa / Kontrak" {{ old('status_rumah') == 'Sewa / Kontrak' ? 'selected' : '' }}>Sewa / Kontrak</option>
                            <option value="Menumpang Saudara" {{ old('status_rumah') == 'Menumpang Saudara' ? 'selected' : '' }}>Menumpang Saudara</option>
                        </select>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Bantuan Pemerintah yang Sedang Diterima</label>
                        <div class="checkbox-grid">
                            @php $bantuanOld = old('bantuan', []); @endphp
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="PKH" {{ in_array('PKH', $bantuanOld) ? 'checked' : '' }}> PKH</label>
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="BPNT" {{ in_array('BPNT', $bantuanOld) ? 'checked' : '' }}> BPNT</label>
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="KJP Plus" {{ in_array('KJP Plus', $bantuanOld) ? 'checked' : '' }}> KJP Plus</label>
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="Kartu Prakerja" {{ in_array('Kartu Prakerja', $bantuanOld) ? 'checked' : '' }}> Kartu Prakerja</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 4: KEMAMPUAN -->
            <div class="form-step" id="step-4">
                <div class="section-title">Pendidikan & Kemampuan</div>
                <div class="form-grid">
                    <div>
                        <label class="form-label">Pendidikan Terakhir *</label>
                        <select name="pendidikan_terakhir" class="form-select" required>
                            <option value="">Pilih Pendidikan Terakhir</option>
                            <option value="Tidak Tamat SD" {{ old('pendidikan_terakhir') == 'Tidak Tamat SD' ? 'selected' : '' }}>Tidak Tamat SD</option>
                            <option value="SD / Sederajat" {{ old('pendidikan_terakhir') == 'SD / Sederajat' ? 'selected' : '' }}>SD / Sederajat</option>
                            <option value="SMP / Sederajat" {{ old('pendidikan_terakhir') == 'SMP / Sederajat' ? 'selected' : '' }}>SMP / Sederajat</option>
                            <option value="SMA / SMK Sederajat" {{ old('pendidikan_terakhir') == 'SMA / SMK Sederajat' ? 'selected' : '' }}>SMA / SMK Sederajat</option>
                            <option value="Diploma (D3)" {{ old('pendidikan_terakhir') == 'Diploma (D3)' ? 'selected' : '' }}>Diploma (D3)</option>
                            <option value="Sarjana (S1)" {{ old('pendidikan_terakhir') == 'Sarjana (S1)' ? 'selected' : '' }}>Sarjana (S1)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Jurusan / Bidang Keahlian Sekolah</label>
                        <input type="text" name="jurusan" class="form-input" placeholder="Isi jika ada, contoh: Otomotif" value="{{ old('jurusan') }}">
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Keahlian Utama (Pisahkan dengan koma) *</label>
                        <input type="text" name="keahlian" class="form-input" placeholder="Contoh: Mengemudi, Las Listrik, Administrasi" value="{{ old('keahlian') }}" required>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Kepemilikan SIM / Sertifikat</label>
                        <div class="checkbox-grid">
                            @php $sertifikatOld = old('sertifikat', []); @endphp
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="SIM A" {{ in_array('SIM A', $sertifikatOld) ? 'checked' : '' }}> SIM A</label>
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="SIM B1/B2" {{ in_array('SIM B1/B2', $sertifikatOld) ? 'checked' : '' }}> SIM B1 / B2</label>
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="SIM C" {{ in_array('SIM C', $sertifikatOld) ? 'checked' : '' }}> SIM C</label>
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="Sertifikat BNSP" {{ in_array('Sertifikat BNSP', $sertifikatOld) ? 'checked' : '' }}> Sertifikat BNSP</label>
                        </div>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Minat Pelatihan Vokasi (Disnaker)</label>
                        <select name="minat_pelatihan" class="form-select">
                            <option value="">Pilih Jenis Pelatihan yang Diminati</option>
                            <option value="Teknik Otomotif / Perbaikan Motor" {{ old('minat_pelatihan') == 'Teknik Otomotif / Perbaikan Motor' ? 'selected' : '' }}>Teknik Otomotif / Perbaikan Motor</option>
                            <option value="Teknik Las & Manufaktur" {{ old('minat_pelatihan') == 'Teknik Las & Manufaktur' ? 'selected' : '' }}>Teknik Las & Manufaktur</option>
                            <option value="Tata Boga / Kuliner" {{ old('minat_pelatihan') == 'Tata Boga / Kuliner' ? 'selected' : '' }}>Tata Boga / Kuliner</option>
                            <option value="Tata Busana / Menjahit" {{ old('minat_pelatihan') == 'Tata Busana / Menjahit' ? 'selected' : '' }}>Tata Busana / Menjahit</option>
                            <option value="Komputer & Digital Marketing" {{ old('minat_pelatihan') == 'Komputer & Digital Marketing' ? 'selected' : '' }}>Komputer & Digital Marketing</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- STEP 5: REVIEW & SIMPAN -->
            <div class="form-step" id="step-5">
                <div class="section-title">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Review & Simpan
                </div>

                <div class="review-card">
                    <div class="review-row">
                        <span class="review-label">NIK</span>
                        <span class="review-value" id="rev-nik">-</span>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Nama</span>
                        <span class="review-value" id="rev-nama">-</span>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Kecamatan/Kelurahan</span>
                        <span class="review-value" id="rev-wilayah">-</span>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Kondisi Ekonomi & DTKS</span>
                        <span class="review-value" id="rev-ekonomi">-</span>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Pendidikan & Keahlian</span>
                        <span class="review-value" id="rev-keahlian">-</span>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Kebutuhan / Minat Pelatihan</span>
                        <span class="review-value" id="rev-minat">-</span>
                    </div>
                    <div class="review-row">
                        <span class="review-label">Bantuan Diterima</span>
                        <span class="review-value" id="rev-bantuan">-</span>
                    </div>
                </div>

                <!-- DUA TOMBOL SIMPAN UTAMA -->
                <div class="review-submit-buttons">
                    <button type="button" class="btn-submit-verify" onclick="submitWithStatus('Terverifikasi')">
                        Simpan dan Verifikasi
                    </button>
                    <button type="button" class="btn-submit-later" onclick="submitWithStatus('Pending')">
                        Simpan & Verifikasi Nanti
                    </button>
                </div>
            </div>

            <!-- TOMBOL NAVIGASI BOTTOM -->
            <div class="form-actions">
                <button type="button" class="btn-step btn-prev btn-disabled" id="prevBtn" onclick="changeStep(-1)" disabled>
                    &larr; Sebelumnya
                </button>
                <button type="button" class="btn-step btn-next" id="nextBtn" onclick="handleNext()">
                    <span>Lanjut</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // DATA KELURAHAN BERDASARKAN KECAMATAN DI JAKARTA BARAT
    const kelurahanData = {
        "Cengkareng": ["Cengkareng Barat", "Cengkareng Timur", "Duri Kosambi", "Kapuk", "Kedaung Kali Angke", "Rawa Buaya"],
        "Grogol Petamburan": ["Grogol", "Jelambar", "Jelambar Baru", "Tanjung Duren Selatan", "Tanjung Duren Utara", "Tomang", "Wijaya Kusuma"],
        "Kalideres": ["Kalideres", "Kamal", "Pegadungan", "Semanan", "Tegal Alur"],
        "Kebon Jeruk": ["Duri Kepa", "Kebon Jeruk", "Kedoya Selatan", "Kedoya Utara", "Kelapa Dua", "Sukabumi Selatan", "Sukabumi Utara"],
        "Kembangan": ["Joglo", "Kembangan Selatan", "Kembangan Utara", "Meruya Selatan", "Meruya Utara", "Srengseng"],
        "Palmerah": ["Jatipulo", "Kemanggisan", "Kota Bambu Selatan", "Kota Bambu Utara", "Palmerah", "Slipi"],
        "Taman Sari": ["Glodok", "Keagungan", "Krukut", "Mangga Besar", "Maphar", "Pinangsia", "Taman Sari", "Tangki"],
        "Tambora": ["Angke", "Duri Selatan", "Duri Utara", "Jembatan Besi", "Jembatan Lima", "Kali Anyar", "Krendang", "Pekojan", "Roa Malaka", "Tambora", "Tanah Sereal"]
    };

    function updateKelurahanOptions(selectedKelurahan = '') {
        const kecamatanSelect = document.getElementById('kecamatanSelect');
        const kelurahanSelect = document.getElementById('kelurahanSelect');
        const selectedKecamatan = kecamatanSelect.value;

        kelurahanSelect.innerHTML = '';

        if (!selectedKecamatan || !kelurahanData[selectedKecamatan]) {
            const defaultOpt = document.createElement('option');
            defaultOpt.value = '';
            defaultOpt.innerText = 'Pilih Kecamatan Terlebih Dahulu';
            kelurahanSelect.appendChild(defaultOpt);
            return;
        }

        const defaultOpt = document.createElement('option');
        defaultOpt.value = '';
        defaultOpt.innerText = 'Pilih Kelurahan';
        kelurahanSelect.appendChild(defaultOpt);

        kelurahanData[selectedKecamatan].forEach(kel => {
            const opt = document.createElement('option');
            opt.value = kel;
            opt.innerText = kel;
            if (selectedKelurahan && selectedKelurahan === kel) {
                opt.selected = true;
            }
            kelurahanSelect.appendChild(opt);
        });
    }

    // LOGIKA STEPPER & VALIDASI
    let currentStep = 1;
    const totalSteps = 5;

    function validateCurrentStep() {
        const currentPanel = document.getElementById(`step-${currentStep}`);
        const inputs = currentPanel.querySelectorAll('input[required], select[required], textarea[required]');
        let isValid = true;

        currentPanel.querySelectorAll('.form-input, .form-select, .form-textarea').forEach(el => {
            el.classList.remove('is-invalid');
        });

        inputs.forEach(input => {
            if (!input.value.trim()) {
                isValid = false;
                input.classList.add('is-invalid');
            }
        });

        if (!isValid) {
            alert('Harap isi semua kolom wajib di langkah ini sebelum melanjutkan.');
            return false;
        }

        if (currentStep === 1) {
            const nikInput = currentPanel.querySelector('input[name="nik"]');
            if (!/^\d{16}$/.test(nikInput.value.trim())) {
                nikInput.classList.add('is-invalid');
                alert('NIK harus berupa angka dan berjumlah tepat 16 digit!');
                return false;
            }

            const telpInput = currentPanel.querySelector('input[name="telepon"]');
            const telpVal = telpInput.value.trim().replace(/[\s\-]/g, '');
            if (!/^(\+62|62|0)8[1-9][0-9]{6,11}$/.test(telpVal)) {
                telpInput.classList.add('is-invalid');
                alert('Format Nomor Handphone tidak valid (contoh: 081234567890).');
                return false;
            }
        }

        return true;
    }

    function populateReviewData() {
        const form = document.getElementById('multiStepForm');

        // NIK & Nama
        document.getElementById('rev-nik').innerText = form.querySelector('input[name="nik"]').value || '-';
        document.getElementById('rev-nama').innerText = form.querySelector('input[name="nama"]').value || '-';

        // Wilayah
        const kec = form.querySelector('select[name="kecamatan"]').value;
        const kel = form.querySelector('select[name="kelurahan"]').value;
        document.getElementById('rev-wilayah').innerText = (kec && kel) ? `${kec} / ${kel}` : '-';

        // Ekonomi & DTKS
        const dtks = form.querySelector('input[name="status_dtks"]:checked')?.value || '-';
        const pendapatan = form.querySelector('select[name="pendapatan_bulanan"]').value;
        document.getElementById('rev-ekonomi').innerText = pendapatan ? `${dtks} (${pendapatan})` : dtks;

        // Pendidikan & Keahlian
        const pend = form.querySelector('select[name="pendidikan_terakhir"]').value || '-';
        const keahlian = form.querySelector('input[name="keahlian"]').value || '-';
        document.getElementById('rev-keahlian').innerText = `${pend} — ${keahlian}`;

        // Minat Pelatihan
        document.getElementById('rev-minat').innerText = form.querySelector('select[name="minat_pelatihan"]').value || 'Tidak Ada';

        // Bantuan
        const checkedBantuan = Array.from(form.querySelectorAll('input[name="bantuan[]"]:checked')).map(cb => cb.value);
        document.getElementById('rev-bantuan').innerText = checkedBantuan.length > 0 ? checkedBantuan.join(', ') : 'Tidak Ada';
    }

    function handleNext() {
        if (!validateCurrentStep()) return;

        if (currentStep < totalSteps) {
            changeStep(1);
        }
    }

    function changeStep(stepDirection) {
        const nextStep = currentStep + stepDirection;
        if (nextStep < 1 || nextStep > totalSteps) return;

        document.getElementById(`step-${currentStep}`).classList.remove('form-step-active');
        document.getElementById(`step-node-${currentStep}`).classList.remove('active');

        if (stepDirection > 0) {
            document.getElementById(`step-node-${currentStep}`).classList.add('completed');
        } else {
            document.getElementById(`step-node-${currentStep}`).classList.remove('completed');
        }

        currentStep = nextStep;
        document.getElementById(`step-${currentStep}`).classList.add('form-step-active');
        document.getElementById(`step-node-${currentStep}`).classList.add('active');

        // ISI DATA REVIEW PADA STEP 5
        if (currentStep === 5) {
            populateReviewData();
        }

        // CONTROL NAV BUTTONS
        const prevBtn = document.getElementById('prevBtn');
        const nextBtn = document.getElementById('nextBtn');

        if (currentStep === 1) {
            prevBtn.disabled = true;
            prevBtn.classList.add('btn-disabled');
        } else {
            prevBtn.disabled = false;
            prevBtn.classList.remove('btn-disabled');
        }

        if (currentStep === totalSteps) {
            nextBtn.style.display = 'none';
        } else {
            nextBtn.style.display = 'inline-flex';
            nextBtn.querySelector('span').innerText = 'Lanjut';
        }
    }

    function submitWithStatus(statusValue) {
        document.getElementById('status_verifikasi_input').value = statusValue;
        document.getElementById('multiStepForm').submit();
    }

    // INISIALISASI DROPDOWN KELURAHAN SAAT MUAT HALAMAN
    document.addEventListener('DOMContentLoaded', function () {
        const oldKelurahan = "{{ old('kelurahan') }}";
        if (document.getElementById('kecamatanSelect').value) {
            updateKelurahanOptions(oldKelurahan);
        }
    });
</script>
@endsection