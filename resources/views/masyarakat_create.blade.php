@extends('layouts.admin')

@section('title', 'Tambah Data Masyarakat')

@section('content')
<style>
    .form-wrapper { width: 100%; margin-bottom: 3rem; }
    .form-header-title { font-size: clamp(1.5rem, 2.5vw, 2.25rem); font-weight: 700; color: #0f172a; margin-bottom: 0.5rem; }
    .form-header-subtitle { color: #64748b; font-size: clamp(0.875rem, 1.2vw, 1rem); margin-bottom: 2rem; }
    .form-container { background: #ffffff; border-radius: 20px; padding: clamp(1.25rem, 3vw, 2.5rem); box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03); width: 100%; box-sizing: border-box; }
    .stepper-wrapper { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 2.5rem; width: 100%; gap: 0.5rem; }
    .step-item { display: flex; flex-direction: column; align-items: center; flex: 1; text-align: center; }
    .step-number { width: 48px; height: 48px; border-radius: 50%; background-color: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 1.1rem; margin-bottom: 0.6rem; transition: all 0.3s ease; }
    .step-label { font-size: 0.875rem; font-weight: 600; color: #94a3b8; }
    .step-item.active .step-number { background-color: #047857; color: #ffffff; box-shadow: 0 0 0 5px rgba(4, 120, 87, 0.15); }
    .step-item.active .step-label { color: #047857; font-weight: 700; }
    .step-item.completed .step-number { background-color: #059669; color: #ffffff; }
    .form-step { display: none; animation: fadeIn 0.3s ease-in-out; }
    .form-step-active { display: block; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(6px); } to { opacity: 1; transform: translateY(0); } }
    .section-title { font-size: 1.25rem; font-weight: 700; color: #0f172a; display: flex; align-items: center; gap: 0.75rem; margin-bottom: 2rem; padding-bottom: 0.75rem; border-bottom: 1px solid #f1f5f9; }
    .form-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 1.5rem 2rem; width: 100%; }
    .form-group-full { grid-column: span 2; }
    .form-label { display: block; font-size: 0.9rem; font-weight: 600; color: #334155; margin-bottom: 0.5rem; }
    .form-input, .form-select, .form-textarea { width: 100%; padding: 0.85rem 1.1rem; border-radius: 12px; border: 1.5px solid #e2e8f0; background-color: #f8fafc; color: #1e293b; font-size: 0.95rem; outline: none; box-sizing: border-box; transition: all 0.2s ease; }
    .form-input:focus, .form-select:focus, .form-textarea:focus { background-color: #ffffff; border-color: #047857; box-shadow: 0 0 0 4px rgba(4, 120, 87, 0.1); }
    .is-invalid { border-color: #ef4444 !important; background-color: #fef2f2 !important; }
    .radio-flex { display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: center; margin-top: 0.5rem; }
    .checkbox-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; margin-top: 0.5rem; }
    .custom-option { display: flex; align-items: center; gap: 0.6rem; cursor: pointer; font-size: 0.925rem; color: #334155; }
    .custom-option input { width: 18px; height: 18px; accent-color: #047857; }
    .form-actions { display: flex; justify-content: space-between; align-items: center; margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid #f1f5f9; }
    .btn-step { padding: 0.85rem 2rem; border-radius: 12px; font-weight: 600; font-size: 0.95rem; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.2s ease; }
    .btn-prev { background-color: #f1f5f9; color: #64748b; }
    .btn-next { background-color: #047857; color: #ffffff; }
    .btn-disabled { opacity: 0.5; cursor: not-allowed; }
    @media (max-width: 868px) { .form-grid { grid-template-columns: 1fr; } .form-group-full { grid-column: span 1; } }
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
        <div class="stepper-wrapper">
            <div class="step-item active" id="step-node-1"><div class="step-number">1</div><div class="step-label">Identitas</div></div>
            <div class="step-item" id="step-node-2"><div class="step-number">2</div><div class="step-label">Kondisi Pekerjaan</div></div>
            <div class="step-item" id="step-node-3"><div class="step-number">3</div><div class="step-label">Kondisi Ekonomi</div></div>
            <div class="step-item" id="step-node-4"><div class="step-number">4</div><div class="step-label">Pendidikan & Kemampuan</div></div>
        </div>

        <form id="multiStepForm" action="{{ route('admin.masyarakat.store') }}" method="POST">
            @csrf

            <!-- STEP 1 -->
            <div class="form-step form-step-active" id="step-1">
                <div class="section-title">Data Identitas Pribadi</div>
                <div class="form-grid">
                    <div>
                        <label class="form-label">Nomor Induk Kependudukan (NIK) *</label>
                        <input type="text" name="nik" class="form-input" placeholder="Masukkan 16 digit NIK" maxlength="16" required>
                    </div>
                    <div>
                        <label class="form-label">Nama Lengkap Sesuai KTP *</label>
                        <input type="text" name="nama" class="form-input" placeholder="Contoh: Budi Santoso" required>
                    </div>
                    <div>
                        <label class="form-label">Jenis Kelamin *</label>
                        <div class="radio-flex">
                            <label class="custom-option"><input type="radio" name="jenis_kelamin" value="Laki-laki" checked> Laki-laki</label>
                            <label class="custom-option"><input type="radio" name="jenis_kelamin" value="Perempuan"> Perempuan</label>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Tanggal Lahir *</label>
                        <input type="date" name="tanggal_lahir" class="form-input" required>
                    </div>
                    <div>
                        <label class="form-label">Nomor Handphone (Aktif) *</label>
                        <input type="text" name="telepon" class="form-input" placeholder="081234567890" required>
                    </div>
                    <div>
                        <label class="form-label">Kecamatan *</label>
                        <select name="kecamatan" class="form-select" required>
                            <option value="">Pilih Kecamatan</option>
                            <option value="Cengkareng">Cengkareng</option>
                            <option value="Grogol Petamburan">Grogol Petamburan</option>
                            <option value="Kalideres">Kalideres</option>
                            <option value="Kebon Jeruk">Kebon Jeruk</option>
                            <option value="Kembangan">Kembangan</option>
                            <option value="Palmerah">Palmerah</option>
                            <option value="Taman Sari">Taman Sari</option>
                            <option value="Tambora">Tambora</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Kelurahan / Desa *</label>
                        <input type="text" name="kelurahan" class="form-input" placeholder="Masukkan nama kelurahan" required>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Alamat Domisili Lengkap *</label>
                        <textarea name="alamat" class="form-textarea" rows="3" placeholder="Nama jalan, RT/RW, nomor rumah..." required></textarea>
                    </div>
                </div>
            </div>

            <!-- STEP 2 -->
            <div class="form-step" id="step-2">
                <div class="section-title">Kondisi Pekerjaan</div>
                <div class="form-grid">
                    <div>
                        <label class="form-label">Status Pekerjaan Saat Ini *</label>
                        <select name="status_pekerjaan" class="form-select" required>
                            <option value="">Pilih Status Pekerjaan</option>
                            <option value="Belum / Tidak Bekerja">Belum / Tidak Bekerja</option>
                            <option value="Pekerja Lepas / Serabutan">Pekerja Lepas / Serabutan</option>
                            <option value="Terkena PHK">Terkena PHK</option>
                            <option value="Pekerja Sektor Informal">Pekerja Sektor Informal</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Lama Menganggur / Mencari Kerja</label>
                        <select name="lama_menganggur" class="form-select">
                            <option value="">Pilih Durasi</option>
                            <option value="< 3 Bulan">< 3 Bulan</option>
                            <option value="3 - 6 Bulan">3 – 6 Bulan</option>
                            <option value="6 - 12 Bulan">6 – 12 Bulan</option>
                            <option value="> 1 Tahun">> 1 Tahun</option>
                        </select>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Alasan Utama Tidak Bekerja</label>
                        <select name="alasan_tidak_bekerja" class="form-select">
                            <option value="">Pilih Alasan Utama</option>
                            <option value="Pengurangan Tenaga Kerja / PHK">Pengurangan Tenaga Kerja / PHK</option>
                            <option value="Usaha Bangkrut">Usaha Bangkrut</option>
                            <option value="Baru Lulus Sekolah / Kuliah">Baru Lulus Sekolah / Kuliah</option>
                            <option value="Mengurus Keluarga">Mengurus Keluarga</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Pengalaman Kerja Terakhir</label>
                        <input type="text" name="pengalaman_terakhir" class="form-input" placeholder="Contoh: Helper Gudang, Staf Admin">
                    </div>
                    <div>
                        <label class="form-label">Lama Pengalaman Kerja</label>
                        <select name="lama_pengalaman" class="form-select">
                            <option value="">Pilih Durasi Pengalaman</option>
                            <option value="Belum Ada Pengalaman">Belum Ada Pengalaman</option>
                            <option value="Kurang dari 1 Tahun">Kurang dari 1 Tahun</option>
                            <option value="1 - 3 Tahun">1 – 3 Tahun</option>
                            <option value="Lebih dari 3 Tahun">Lebih dari 3 Tahun</option>
                        </select>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Tipe Pekerjaan yang Dicari</label>
                        <div class="radio-flex">
                            <label class="custom-option"><input type="radio" name="tipe_pekerjaan_dicari" value="Full Time" checked> Full Time</label>
                            <label class="custom-option"><input type="radio" name="tipe_pekerjaan_dicari" value="Harian / Part Time"> Harian / Part Time</label>
                            <label class="custom-option"><input type="radio" name="tipe_pekerjaan_dicari" value="Wirausaha / UMKM"> Wirausaha / UMKM</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 3 -->
            <div class="form-step" id="step-3">
                <div class="section-title">Kondisi Ekonomi</div>
                <div class="form-grid">
                    <div class="form-group-full">
                        <label class="form-label">Status Terdaftar Data Kemiskinan</label>
                        <div class="radio-flex">
                            <label class="custom-option"><input type="radio" name="status_dtks" value="Terdaftar DTKS" checked> Terdaftar DTKS</label>
                            <label class="custom-option"><input type="radio" name="status_dtks" value="Terdaftar P3KE"> Terdaftar P3KE</label>
                            <label class="custom-option"><input type="radio" name="status_dtks" value="Belum Terdaftar"> Belum Terdaftar</label>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Rata-rata Pendapatan / Bulan</label>
                        <select name="pendapatan_bulanan" class="form-select">
                            <option value="">Pilih Kisaran Pendapatan</option>
                            <option value="Tidak Ada Pendapatan">Tidak Ada Pendapatan</option>
                            <option value="< Rp 1.000.000">< Rp 1.000.000</option>
                            <option value="Rp 1.000.000 - Rp 2.500.000">Rp 1.000.000 – Rp 2.500.000</option>
                            <option value="> Rp 2.500.000">> Rp 2.500.000</option>
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
                            <option value="Milik Sendiri">Milik Sendiri</option>
                            <option value="Sewa / Kontrak">Sewa / Kontrak</option>
                            <option value="Menumpang Saudara">Menumpang Saudara</option>
                        </select>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Bantuan Pemerintah yang Sedang Diterima</label>
                        <div class="checkbox-grid">
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="PKH"> PKH</label>
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="BPNT"> BPNT</label>
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="KJP Plus"> KJP Plus</label>
                            <label class="custom-option"><input type="checkbox" name="bantuan[]" value="Kartu Prakerja"> Kartu Prakerja</label>
                        </div>
                    </div>
                </div>
            </div>

            <!-- STEP 4 -->
            <div class="form-step" id="step-4">
                <div class="section-title">Pendidikan & Kemampuan</div>
                <div class="form-grid">
                    <div>
                        <label class="form-label">Pendidikan Terakhir *</label>
                        <select name="pendidikan_terakhir" class="form-select" required>
                            <option value="">Pilih Pendidikan Terakhir</option>
                            <option value="Tidak Tamat SD">Tidak Tamat SD</option>
                            <option value="SD / Sederajat">SD / Sederajat</option>
                            <option value="SMP / Sederajat">SMP / Sederajat</option>
                            <option value="SMA / SMK Sederajat">SMA / SMK Sederajat</option>
                            <option value="Diploma (D3)">Diploma (D3)</option>
                            <option value="Sarjana (S1)">Sarjana (S1)</option>
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Jurusan / Bidang Keahlian Sekolah</label>
                        <input type="text" name="jurusan" class="form-input" placeholder="Isi jika ada, contoh: Otomotif">
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Keahlian Utama (Pisahkan dengan koma) *</label>
                        <input type="text" name="keahlian" class="form-input" placeholder="Contoh: Mengemudi, Las Listrik, Administrasi" required>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Kepemilikan SIM / Sertifikat</label>
                        <div class="checkbox-grid">
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="SIM A"> SIM A</label>
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="SIM B1/B2"> SIM B1 / B2</label>
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="SIM C"> SIM C</label>
                            <label class="custom-option"><input type="checkbox" name="sertifikat[]" value="Sertifikat BNSP"> Sertifikat BNSP</label>
                        </div>
                    </div>
                    <div class="form-group-full">
                        <label class="form-label">Minat Pelatihan Vokasi (Disnaker)</label>
                        <select name="minat_pelatihan" class="form-select">
                            <option value="">Pilih Jenis Pelatihan yang Diminati</option>
                            <option value="Teknik Otomotif / Perbaikan Motor">Teknik Otomotif / Perbaikan Motor</option>
                            <option value="Teknik Las & Manufaktur">Teknik Las & Manufaktur</option>
                            <option value="Tata Boga / Kuliner">Tata Boga / Kuliner</option>
                            <option value="Tata Busana / Menjahit">Tata Busana / Menjahit</option>
                            <option value="Komputer & Digital Marketing">Komputer & Digital Marketing</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn-step btn-prev btn-disabled" id="prevBtn" onclick="changeStep(-1)" disabled>Kembali</button>
                <button type="button" class="btn-step btn-next" id="nextBtn" onclick="handleNext()">
                    <span>Lanjut</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 4;

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

    function handleNext() {
        if (!validateCurrentStep()) return;

        if (currentStep === totalSteps) {
            document.getElementById('multiStepForm').submit();
        } else {
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
            nextBtn.querySelector('span').innerText = 'Simpan Data';
        } else {
            nextBtn.querySelector('span').innerText = 'Lanjut';
        }
    }
</script>
@endsection