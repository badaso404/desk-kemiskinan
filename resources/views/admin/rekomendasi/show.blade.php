@extends('layouts.admin')

@section('title', 'Rekomendasi untuk '.$warga->nama)

@section('content')
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
                    </article>
                @endforeach
            </div>
        @endif
    </section>
</div>
@endsection
