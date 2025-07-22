<header class="relative h-[80vh] md:h-screen w-full bg-cover bg-center"
    style="background-image: url('{{ asset('img/hero-image.webp') }}');">

    {{-- Overlay Gelap --}}
    <div class="absolute inset-0 bg-black/40"></div>

    {{-- Konten Hero --}}
    <div class="absolute inset-0 flex flex-col items-center justify-center text-center text-white px-4">
        @if (request()->routeIs('home'))
            <h1 class="text-base sm:text-lg md:text-2xl lg:text-3xl text-gray-200 mb-2">
                Selamat Datang di Website
            </h1>
            <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-bold max-w-4xl">
                Dinas Pemberdayaan Perempuan dan Perlindungan Anak Provinsi Sulawesi Utara
            </p>
        @else
            <h1 class="-mt-[40vh] text-2xl md:text-3xl lg:text-4xl font-bold text-gray-200 mb-2">
                {{ $title }}
            </h1>
        @endif
    </div>

</header>
