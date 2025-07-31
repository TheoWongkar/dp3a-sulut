<div x-data="{ sidebarOpen: false, atTop: true }" x-init="window.addEventListener('scroll', () => { atTop = window.scrollY <= 10 })" :class="atTop ? 'bg-transparent' : 'bg-[#141652]'"
    class="fixed w-full text-white top-0 z-50 transition-colors duration-500">
    <div class="container mx-auto px-5 py-3 flex justify-between items-center">

        {{-- Logo dan Hamburger --}}
        <div class="flex items-center gap-3">

            {{-- Tombol Hamburger --}}
            <button @click="sidebarOpen = true" aria-label="Hamburger Button" class="cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-list w-6 h-6" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>

            <a href="{{ route('home') }}" class="flex items-center gap-3">
                {{-- Logo Gambar --}}
                <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Pemprov Sulut"
                    class="w-8 h-8 md:w-10 md:h-10 object-contain">

                {{-- Logo Tulisan --}}
                <div class="text-[0.625rem] md:text-xs font-medium leading-tight">
                    Dinas Pemberdayaan Perempuan<br>
                    dan Perlindungan Anak<br>
                    <span class="text-[0.625rem] text-gray-100 font-normal">Sulawesi Utara</span>
                </div>
            </a>
        </div>

        {{-- Navigasi Desktop --}}
        <nav class="hidden lg:flex gap-6 items-center text-sm">
            <a href="{{ route('home') }}"
                class="{{ Route::is('home') ? 'underline underline-offset-8 text-blue-100' : '' }} hover:underline hover:underline-offset-8 transition">Beranda</a>
            <a href="{{ route('post.index') }}"
                class="{{ Route::is('post.*') ? 'underline underline-offset-8 text-blue-100' : '' }} hover:underline hover:underline-offset-8 transition">Berita</a>
            <a href="{{ route('report.check-status') }}"
                class="{{ Route::is('report.check-status') ? 'underline underline-offset-8 text-blue-100' : '' }} hover:underline hover:underline-offset-8 transition">Cek
                Status Laporan</a>
            <a href="{{ route('report.create') }}"
                class="{{ Route::is('report.create') ? 'bg-gray-200 border text-[#141652]' : '' }} px-4 py-1 border rounded-full hover:bg-white hover:text-[#141652] transition duration-300">
                Laporkan Kekerasan
            </a>
        </nav>
    </div>

    {{-- Overlay saat sidebar aktif --}}
    <div x-show="sidebarOpen" x-cloak x-transition.opacity class="fixed inset-0 bg-black/40 z-40"
        @click="sidebarOpen = false">
    </div>

    {{-- Sidebar Navigasi --}}
    <div x-show="sidebarOpen" x-cloak x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full" class="fixed top-0 left-0 w-64 h-full bg-[#DCE8FF] shadow z-50">

        {{-- Header Sidebar --}}
        <div class="flex items-center justify-between p-4">
            {{-- Form Pencarian --}}
            <form action="#" method="GET" class="flex items-center w-full gap-2">
                <div class="relative w-full">
                    <input type="text" name="search" placeholder="Cari..." value="{{ old('search') }}"
                        class="w-full pr-10 pl-3 py-2 bg-white text-black text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-600 focus:border-blue-600">
                    <button type="submit" aria-label="Search Button"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-blue-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        {{-- Navigasi Sidebar --}}
        <nav class="flex flex-col text-sm text-[#141652]">
            <a href="{{ route('home') }}" class="px-5 py-3 hover:bg-[#E9F0FF]">Beranda</a>
            <a href="{{ route('post.index') }}" class="px-5 py-3 hover:bg-[#E9F0FF]">Berita</a>
            <a href="{{ route('report.check-status') }}" class="px-5 py-3 hover:bg-[#E9F0FF]">Cek Status Laporan</a>
            <a href="{{ route('report.create') }}" class="px-5 py-3 hover:bg-[#E9F0FF]">Laporkan Kekerasan</a>

            @auth
                <x-buttons.primary-button href="{{ route('dashboard') }}"
                    class="mt-3 px-5 py-2 self-center text-center w-5/6">Dashboard</x-buttons.primary-button>
            @else
                <x-buttons.primary-button href="{{ route('login') }}"
                    class="mt-3 px-5 py-2 self-center text-center w-5/6">Login</x-buttons.primary-button>
            @endauth
        </nav>
    </div>
</div>
