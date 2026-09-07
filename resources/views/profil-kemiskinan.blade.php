@extends('layouts.app')

@section('title', 'Profil Kemiskinan - Pemberdayaan Masyarakat')

@section('content')
<!-- HERO SECTION -->
<section class="hero-beranda">
    <div class="hero-text">
        <h1>Profil Kemiskinan<br>Kota Jakarta Barat</h1>
        <p>Gambaran umum kondisi sosial ekonomi warga sebagai dasar penyusunan program pemberdayaan dan penempatan kerja.</p>
    </div>
    <div class="hero-image-placeholder">
        <p>Grafik / Peta Sebaran</p>
    </div>
</section>

<!-- STATS SECTION -->
<section class="stats-section">
    <div class="stat-card">
        <h3>1.245</h3>
        <p>Warga Terdata</p>
    </div>
    <div class="stat-card">
        <h3>328</h3>
        <p>Membutuhkan Pekerjaan</p>
    </div>
    <div class="stat-card">
        <h3>75</h3>
        <p>Kebutuhan Mitra Kerja</p>
    </div>
</section>

<!-- TAHAPAN PENANGANAN -->
<section class="steps-section">
    <h2>Tahapan Penanganan</h2>
    <div class="steps-grid">
        <div class="step-item"><span>1</span><p>Pendataan Warga</p></div>
        <div class="step-item"><span>2</span><p>Verifikasi Kelurahan</p></div>
        <div class="step-item"><span>3</span><p>Rekomendasi Pekerjaan</p></div>
        <div class="step-item"><span>4</span><p>Penempatan Kerja</p></div>
    </div>
</section>
@endsection
