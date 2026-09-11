@extends('layouts.admin')

@section('title', 'Rekomendasi untuk '.$warga->nama)

@section('content')

<!-- Notifikasi Pesan Error (Misal jika kandidat sudah pernah dimasukkan ke program ini) -->
@if(session('error'))
    <div style="margin-bottom: 1.5rem; background-color: #fef2f2; border: 1px solid #fecaca; color: #b91c1c; padding: 1rem; border-radius: 0.5rem; display: flex; align-items: center; gap: 0.75rem;">
        <svg style="width: 20px; height: 20px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span style="font-size: 14px; font-weight: 500;">{{ session('error') }}</span>
    </div>
@endif

<a href="{{ route('admin.rekomendasi.index') }}" class="link-back">&larr; Kembali ke Rekomendasi</a>

<div class="page-head">
    <h1>{{ $warga->nama }}</h1>
    <p>Seluruh program yang cocok dengan keahlian dan minat warga ini, diurutkan dari skor tertinggi.</p>
</div>

<div class="grid-side">
    <aside class="card">
        <h2>Profil Warga</h2>
        <dl class="detail-facts">
            <div><dt>NIK</dt><dd>{{ $warga->nik }}</dd></div>
            <div><dt>Kecamatan</dt><dd>{{ $warga->kecamatan }}</dd></div>
            <div><dt>Kelurahan</dt><dd>{{ $warga->kelurahan }}</dd></div>
            <div><dt>Pendidikan</dt><dd>{{ $warga->pendidikan_terakhir }}</dd></div>
            <div><dt>Status Pekerjaan</dt><dd>{{ $warga->status_pekerjaan }}</dd></div>
            <div>
                <dt>Keahlian &amp; Minat</dt>
                <dd>
                    <div class="tag-row">
                        @forelse ($minatWarga as $minat)
                            <span class="tag">{{ $minat }}</span>
                        @empty
                            <span class="cell-sub">Belum diisi</span>
                        @endforelse
                    </div>
                </dd>
            </div>
        </dl>
    </aside>

    <section class="card">
        <div class="card-head">
            <h2>Program yang Cocok ({{ $kecocokan->count() }})</h2>
        </div>

        @if ($kecocokan->isEmpty())
            <p class="empty-state">
                Tidak ada program yang cocok dengan warga ini. Periksa apakah keahlian dan minat
                pelatihannya sudah terisi di Data Masyarakat, atau tambahkan program baru
                dengan kriteria yang sesuai di menu Pemberdayaan.
            </p>
        @else
            <div class="match-list">
                @foreach ($kecocokan as $item)
                    @php $program = $item['program']; @endphp
                    <article class="match-item">
                        <div class="match-head">
                            <div>
                                <h3>{{ $program->nama }}</h3>
                                <p class="cell-sub">
                                    @if ($program->mitra)
                                        <span class="badge badge-{{ strtolower($program->mitra->jenis) }}">{{ $program->mitra->jenis }}</span>
                                    @endif
                                    {{ $program->mitra?->nama ?? $program->penyelenggara }} &middot; {{ $program->lokasi }}
                                </p>
                            </div>
                            <div class="skor skor-besar">
                                <span>{{ $item['skor'] }}%</span>
                                <div class="mini-track">
                                    <div class="mini-fill" style="width: {{ $item['skor'] }}%"></div>
                                </div>
                            </div>
                        </div>

                        <div class="match-body">
                            <div>
                                <span class="match-label">Kriteria cocok</span>
                                <div class="tag-row">
                                    @foreach ($item['kriteria_cocok'] as $kriteria)
                                        <span class="tag">{{ $kriteria }}</span>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <span class="match-label">Jadwal</span>
                                <strong>{{ $program->tanggal_mulai->format('d M') }} – {{ $program->tanggal_selesai->format('d M Y') }}</strong>
                            </div>
                            <div>
                                <span class="match-label">Sisa kursi</span>
                                <strong>{{ $program->sisa_kuota }} dari {{ $program->kuota }}</strong>
                            </div>
                            <div>
                                <span class="match-label">Status</span>
                                <span class="badge badge-{{ strtolower($program->status) }}">{{ $program->status }}</span>
                            </div>
                        </div>

                        <!-- =========== TOMBOL PENEMPATAN LANGSUNG =========== -->
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #eaeaea; display: flex; justify-content: flex-end;">
                            <form action="{{ route('penempatan.store') }}" method="POST">
                                @csrf
                                <!-- Data yang dikirim otomatis di balik layar -->
                                <input type="hidden" name="masyarakat_id" value="{{ $warga->id }}">
                                <input type="hidden" name="program_id" value="{{ $program->id }}">
                                <input type="hidden" name="status" value="Seleksi"> 
                                <input type="hidden" name="tanggal_penempatan" value="{{ now()->format('Y-m-d') }}">

                                <button type="submit" 
                                       style="background-color: #086b50; color: white; padding: 0.5rem 1.25rem; border-radius: 9999px; font-size: 14px; font-weight: 500; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 0.5rem; transition: 0.2s ease;"
                                       onmouseover="this.style.backgroundColor='#06503c'" 
                                       onmouseout="this.style.backgroundColor='#086b50'"
                                       onclick="return confirm('Tempatkan {{ $warga->nama }} ke program {{ $program->nama }} secara langsung?')">
                                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                    Tempatkan Langsung
                                </button>
                            </form>
                        </div>
                        <!-- =================================================== -->

                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection