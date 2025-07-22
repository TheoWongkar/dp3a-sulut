<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    {{-- Metadata --}}
    <meta name="description"
        content="Website Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DP3A), Sulawesi Utara. Dirancang untuk sistem informasi pelaporan kekerasan terhadap anak.">
    <meta name="keywords" content="Elapor DP3A Sulut, sistem pelaporan online, layanan perlindungan anak">
    <meta name="author" content="DP3A Sulawesi Utara">

    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/application-logo.svg') }}" type="image/x-icon">

    {{-- Judul Halaman --}}
    <title>DP3A Sulawesi Utara</title>

    {{-- Framework Frontend --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script Tambahan --}}
    @stack('scripts')

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- Default CSS --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div class="flex flex-col min-h-screen">
        {{-- Navigasi --}}
        @include('components.layouts.partials.guest-navigation')

        {{-- Layout Utama --}}
        <main class="flex-1 bg-gray-100">
            {{-- Header --}}
            @include('components.layouts.partials.guest-header', ['title' => $title ?? null])

            {{ $slot }}
        </main>

        {{-- Footer --}}
        @include('components.layouts.partials.guest-footer')
    </div>

</body>

</html>
