<!-- Bagian Title -->
@section('title')
    @isset($title)
        {{ $title }}
    @endisset
@endsection

<!-- Bagian Judul Halaman -->
@section('pageTitle')
    @isset($title)
        {{ Str::limit($title, 15) }}
    @endisset
@endsection