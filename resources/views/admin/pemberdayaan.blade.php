@extends('layouts.admin')

@section('title', 'Direktori Penerima Manfaat')

<!-- PANGGIL CSS TERPISAH -->
<link rel="stylesheet" href="{{ asset('css/pemberdayaan.css') }}">

@section('content')
<div class="page-head">
    <h1>Direktori Penerima Manfaat</h1>
    <p>Kelola dan pantau profil individu untuk mencocokkan potensi mereka dengan peluang pemberdayaan yang tersedia.</p>
</div>

<!-- SEARCH -->
<div class="search-container">
    <span class="search-icon">🔍</span>
    <input type="text" id="searchInput" placeholder="Cari Nama atau NIK...">
</div>

<!-- FILTERS -->
<div class="filter-container">
    <span>⚙️ Filter:</span>
    <select class="filter-select" id="filterKecamatan">
        <option value="">Semua Kecamatan</option>
        <option value="Cengkareng">Cengkareng</option>
        <option value="Grogol Petamburan">Grogol Petamburan</option>
        <option value="Kalideres">Kalideres</option>
        <option value="Kebon Jeruk">Kebon Jeruk</option>
        <option value="Kembangan">Kembangan</option>
        <option value="Palmerah">Palmerah</option>
        <option value="Taman Sari">Taman Sari</option>
        <option value="Tambora">Tambora</option>
    </select>
    <select class="filter-select" id="filterKeahlian">
        <option value="">Semua Keahlian</option>
        <option value="Driver">Driver</option>
        <option value="Security">Security</option>
        <option value="Administrasi">Administrasi</option>
        <option value="Mekanik">Mekanik</option>
    </select>
    <button type="button" class="btn-clear" id="btnClear">Clear</button>
</div>

<!-- CARDS LIST -->
<div class="cards-grid" id="cardsGrid">
    @php
        $penerimaList = [
            [
                'initial' => 'AS',
                'nama' => 'Andi Saputra',
                'nik' => '3171234567890101',
                'kecamatan' => 'Cengkareng',
                'lokasi' => 'Cengkareng, Jakarta Barat',
                'keahlian' => ['Driver', 'Mekanik Dasar'],
                'status' => 'Aktif'
            ],
            [
                'initial' => 'BD',
                'nama' => 'Budi Darmawan',
                'nik' => '3171234567890102',
                'kecamatan' => 'Kebon Jeruk',
                'lokasi' => 'Kebon Jeruk, Jakarta Barat',
                'keahlian' => ['Security', 'Bela Diri'],
                'status' => 'Aktif'
            ],
            [
                'initial' => 'CS',
                'nama' => 'Citra Sari',
                'nik' => '3171234567890103',
                'kecamatan' => 'Kembangan',
                'lokasi' => 'Kembangan, Jakarta Barat',
                'keahlian' => ['Administrasi', 'Komputer Dasar'],
                'status' => 'Diproses'
            ],
        ];
    @endphp

    @foreach($penerimaList as $item)
        <div class="card-beneficiary" 
             data-kecamatan="{{ $item['kecamatan'] }}" 
             data-keahlian="{{ implode(',', $item['keahlian']) }}"
             data-nama="{{ strtolower($item['nama']) }}"
             data-nik="{{ $item['nik'] }}">
            <div>
                <div class="card-head-beneficiary">
                    <div class="user-info">
                        <div class="avatar">{{ $item['initial'] }}</div>
                        <div class="user-details">
                            <h3>{{ $item['nama'] }}</h3>
                            <div class="nik-text">{{ $item['nik'] }}</div>
                            <div class="location-text">📍 {{ $item['lokasi'] }}</div>
                        </div>
                    </div>
                    <span class="badge-status {{ strtolower($item['status']) }}">{{ $item['status'] }}</span>
                </div>

                <div class="skills-section">
                    <div class="skills-title">Keahlian / Minat:</div>
                    <div class="skills-tags">
                        @foreach($item['keahlian'] as $tag)
                            <span class="tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <a href="#" class="btn-recommendation">
                    Lihat Rekomendasi →
                </a>
            </div>
        </div>
    @endforeach
</div>

<!-- SCRIPT FILTER & SEARCH INTERAKTIF -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const filterKecamatan = document.getElementById('filterKecamatan');
    const filterKeahlian = document.getElementById('filterKeahlian');
    const searchInput = document.getElementById('searchInput');
    const btnClear = document.getElementById('btnClear');
    const cards = document.querySelectorAll('.card-beneficiary');

    function filterData() {
        const selectedKecamatan = filterKecamatan.value.toLowerCase();
        const selectedKeahlian = filterKeahlian.value.toLowerCase();
        const searchText = searchInput.value.toLowerCase().trim();

        cards.forEach(card => {
            const cardKecamatan = card.getAttribute('data-kecamatan').toLowerCase();
            const cardKeahlian = card.getAttribute('data-keahlian').toLowerCase();
            const cardNama = card.getAttribute('data-nama');
            const cardNik = card.getAttribute('data-nik');

            // Cek Kecamatan
            const matchKecamatan = !selectedKecamatan || cardKecamatan === selectedKecamatan;
            
            // Cek Keahlian (mengandung keahlian yang dipilih)
            const matchKeahlian = !selectedKeahlian || cardKeahlian.includes(selectedKeahlian);
            
            // Cek Input Pencarian Nama / NIK
            const matchSearch = !searchText || cardNama.includes(searchText) || cardNik.includes(searchText);

            // Tampilkan kartu jika memenuhi semua kriteria filter
            if (matchKecamatan && matchKeahlian && matchSearch) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Event Listeners
    filterKecamatan.addEventListener('change', filterData);
    filterKeahlian.addEventListener('change', filterData);
    searchInput.addEventListener('input', filterData);

    // Tombol Clear Filter
    btnClear.addEventListener('click', function () {
        filterKecamatan.value = '';
        filterKeahlian.value = '';
        searchInput.value = '';
        filterData();
    });
});
</script>
@endsection