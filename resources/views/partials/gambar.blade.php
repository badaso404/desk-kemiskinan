{{--
    Menampilkan foto bila filenya ada di public/images, selain itu tampil placeholder.
    Cukup taruh file dengan nama yang sama di public/images untuk mengganti placeholder.
--}}
@if (file_exists(public_path('images/'.$file)))
    <img src="{{ asset('images/'.$file) }}" alt="{{ $label }}" class="{{ $class ?? '' }}">
@else
    <div class="media-placeholder {{ $class ?? '' }}">
        <span>{{ $label }}</span>
    </div>
@endif
