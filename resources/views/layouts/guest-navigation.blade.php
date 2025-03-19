<!-- Navigasi -->
<div x-data="{
    isNavbarVisible: {{ request()->routeIs('home') ? 'false' : 'true' }},
    isSidebarOpen: false,
    handleScroll() {
        if ({{ request()->routeIs('home') ? 'true' : 'false' }}) {
            this.isNavbarVisible = window.scrollY > 0;
        }
    }
}" @scroll.window="handleScroll" class="relative">

    <!-- Navbar -->
    <header x-show="isNavbarVisible" x-cloak
        class="fixed w-full bg-[#141652] text-white transition-transform duration-500 z-20"
        x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-500"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-full">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <!-- Tombol Menu Mobile -->
                <button @click="isSidebarOpen = true" aria-label="Buka Sidebar"
                    class="focus:outline-none hover:cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Aplikasi" class="w-10 h-10">
                    <h1 class="text-sm font-semibold leading-none">
                        Dinas Pemberdayaan Perempuan
                        <span class="block">dan Perlindungan Anak</span>
                        <span class="block text-xs font-normal">Sulawesi Utara</span>
                    </h1>
                </a>
            </div>
            <!-- Link Navigasi -->
            <nav class="hidden lg:flex items-center space-x-6 text-sm" aria-label="Main Navigation">
                <ul class="flex space-x-6">
                    @foreach ([['route' => 'home', 'routeIs' => 'home', 'label' => 'Beranda'], ['route' => 'posts.index', 'routeIs' => 'posts.*', 'label' => 'Berita'], ['route' => 'status.index', 'routeIs' => 'status.index', 'label' => 'Cek Status Laporan']] as $menu)
                        <li>
                            <a href="{{ route($menu['route']) }}"
                                class="{{ Request::routeIs($menu['routeIs']) ? 'animate-pulse' : '' }} font-medium hover:border-b border-white">
                                {{ $menu['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
                <div class="flex space-x-4">
                    <button @click="$dispatch('open-chat')"
                        class="border border-white font-medium px-4 py-1 rounded-full hover:bg-white hover:text-[#141652] hover:cursor-pointer duration-300">
                        Chatbot
                    </button>
                    <a href="{{ route('reports.create') }}"
                        class="border border-white font-medium px-4 py-1 rounded-full hover:bg-white hover:text-[#141652] duration-300">
                        Laporkan Kekerasan
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Sidebar -->
    <aside x-show="isSidebarOpen" x-cloak @click.away="isSidebarOpen = false"
        class="fixed top-0 left-0 h-full w-64 bg-[#DCE8FF] py-4 shadow-lg transition-transform duration-300 z-20"
        x-transition:enter="transform transition duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform transition duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <div class="flex justify-between items-center mx-4 mb-5 gap-2">
            <!-- Cari -->
            <form role="search" class="w-full flex items-center">
                <label for="search" class="sr-only">Cari Informasi</label>
                <input id="search" type="text" placeholder="Cari Informasi..."
                    class="w-full py-1.5 px-4 bg-white rounded-full border focus:outline-none">
            </form>
            <!-- Tombol Tutup -->
            <button @click="isSidebarOpen = false" class="text-[#141652] focus:outline-none hover:cursor-pointer"
                aria-label="Tutup Sidebar">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- Link Navigasi -->
        <nav aria-label="Sidebar Navigation" class="flex flex-col text-black">
            <ul class="space-y-0">
                @foreach ([['route' => 'home', 'routeIs' => 'home', 'label' => 'Beranda'], ['route' => 'posts.index', 'routeIs' => 'posts.*', 'label' => 'Berita'], ['route' => 'status.index', 'routeIs' => 'status.index', 'label' => 'Cek Status Laporan']] as $menu)
                    <li>
                        <a href="{{ route($menu['route']) }}"
                            class="flex px-6 py-3 w-full font-medium hover:bg-[#E9F0FF]">
                            {{ $menu['label'] }}
                        </a>
                    </li>
                @endforeach
                <li>
                    <button @click="$dispatch('open-chat'); isSidebarOpen = false"
                        class="flex px-6 py-3 w-full font-medium hover:bg-[#E9F0FF]">
                        Chatbot
                    </button>
                </li>
                <li>
                    <a href="{{ route('reports.create') }}"
                        class="flex px-6 py-3 w-full font-medium hover:bg-[#E9F0FF]">
                        Laporkan Kekerasan
                    </a>
                </li>
                <li class="mx-4">
                    @auth
                        <a href="#"
                            class="flex items-center mt-4 justify-center w-full py-2 bg-[#141652] text-white text-center rounded-full font-medium hover:bg-blue-800 duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center mt-4 justify-center w-full py-2 bg-[#141652] text-white text-center rounded-full font-medium hover:bg-blue-800 duration-300">
                            Login
                        </a>
                    @endauth
                </li>
            </ul>
        </nav>
    </aside>
</div>
