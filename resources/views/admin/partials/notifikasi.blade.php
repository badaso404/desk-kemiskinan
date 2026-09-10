@if (session('sukses'))
    <div class="alert alert-sukses">{{ session('sukses') }}</div>
@endif

@if ($errors->any())
    <div class="alert alert-galat">
        <strong>Periksa kembali isian berikut:</strong>
        <ul>
            @foreach ($errors->all() as $pesan)
                <li>{{ $pesan }}</li>
            @endforeach
        </ul>
    </div>
@endif
