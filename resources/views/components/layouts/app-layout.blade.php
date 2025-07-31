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
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta property="og:title" content="DP3A - {{ $title }}">
    <meta property="og:description"
        content="Website Dinas Pemberdayaan Perempuan dan Perlindungan Anak (DP3A) Sulawesi Utara.">
    <meta property="og:image" content="{{ asset('img/hero-image.webp') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta name="robots" content="noindex, nofollow">


    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{ asset('img/application-logo.svg') }}" type="image/x-icon">

    {{-- Judul Halaman --}}
    <title>DP3A - {{ $title }}</title>

    {{-- Google Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    {{-- Framework Frontend --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Script Tambahan --}}
    @stack('scripts')

    {{-- Default CSS --}}
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans antialiased">

    <div x-data="{ sidebarOpen: false }" class="relative h-screen flex overflow-hidden" x-cloak>

        {{-- Navigasi --}}
        @include('components.layouts.partials.app-navigation')

        {{-- Layout Utama --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            {{-- Header --}}
            @include('components.layouts.partials.app-header')

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto p-5 bg-gray-100">
                {{ $slot }}
            </main>
        </div>
    </div>

</body>

</html>
