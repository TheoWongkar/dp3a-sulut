<!-- Bagian Navigasi -->
<div x-data="{
    @if (request()->routeIs('home')) isNavbarVisible: false,
        isSidebarOpen: false,
        lastScrollTop: 0,
        handleScroll() {
            const currentScrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (currentScrollTop > 0) {
                this.isNavbarVisible = true;
            } else {
                this.isNavbarVisible = false;
            }

            this.lastScrollTop = currentScrollTop <= 0 ? 0 : currentScrollTop;
        }
    @else
    isSidebarOpen: false, @endif
}" @scroll.window="handleScroll" class="relative">

    <!-- Menu Navbar -->
    <header @if (request()->routeIs('home')) x-show="isNavbarVisible" x-cloak @endif
        class="fixed w-full bg-[#141652] px-3 py-4 md:px-8 transition-transform duration-500 z-20"
        x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 -translate-y-full"
        x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in-out duration-500"
        x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-full">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <!-- Tombol Menu Mobile -->
                <button @click="isSidebarOpen = true" class="text-white mr-5 focus:outline-none" aria-label="Open Menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
                <!-- Logo -->
                <a href="/" class="flex items-center">
                    <x-application-logo class="w-8 h-8 mr-2 fill-current" />
                    <span class="text-white text-lg font-semibold">DP3A SULUT</span>
                </a>
            </div>

            <!-- Link Navigasi -->
            <nav class="hidden lg:flex items-center space-x-6 text-sm font-normal" aria-label="Main Navigation">
                <ul class="flex space-x-6 text-white">
                    <li><a href="/" class="hover:border-b border-white">Beranda</a></li>
                    <li><a href="#" class="hover:border-b border-white">Berita</a></li>
                    <li><a href="#" class="hover:border-b border-white">Cek Status Laporan</a></li>
                </ul>
                <div class="flex space-x-4">
                    <a href="#" @click="open = true"
                        class="border border-white text-white px-4 py-1 rounded-full hover:bg-white hover:text-[#141652] duration-300">
                        Chat Dengan AI
                    </a>
                    <a href="#"
                        class="border border-white text-white px-4 py-1 rounded-full hover:bg-white hover:text-[#141652] duration-300">
                        Laporkan Kekerasan
                    </a>
                </div>
            </nav>
        </div>
    </header>

    <!-- Menu Sidebar -->
    <aside x-show="isSidebarOpen" x-cloak @click.away="isSidebarOpen = false"
        class="fixed top-0 left-0 h-full w-64 bg-[#DCE8FF] p-4 shadow-lg transition-transform duration-300 z-20"
        x-transition:enter="transform transition duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform transition duration-300"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <div class="flex justify-between items-center mb-4">
            <!-- Cari -->
            <form role="search" class="w-full flex items-center">
                <label for="search" class="sr-only">Cari Informasi</label>
                <input id="search" type="text" placeholder="Cari Informasi..."
                    class="w-full py-1 px-4 rounded-full border-2 border-[#141652] focus:outline-none">
            </form>
            <!-- Tombol Tutup -->
            <button @click="isSidebarOpen = false" class="ml-2 text-[#141652] focus:outline-none"
                aria-label="Close Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <!-- Link Navigasi -->
        <nav aria-label="Sidebar Navigation" class="flex flex-col text-[#141652]">
            <ul class="space-y-2">
                <li><a href="/" class="font-semibold hover:text-[#708CFF]">Beranda</a></li>
                <li><a href="#" class="font-semibold hover:text-[#708CFF]">Berita</a></li>
                <li><a href="#" class="font-semibold hover:text-[#708CFF]">Cek Status Laporan</a></li>
                <li><a href="#" class="font-semibold hover:text-[#708CFF]">Chat Dengan AI</a></li>
                <li><a href="#" class="font-semibold hover:text-[#708CFF]">Laporkan Kekerasan</a></li>
                <li>
                    @auth
                        <a href="#"
                            class="inline-block w-full py-1 bg-[#141652] text-white text-center rounded-full font-semibold hover:bg-[#708CFF] duration-300">
                            Dashboard
                        </a>
                    @else
                        <a href="#"
                            class="inline-block w-full py-1 bg-[#141652] text-white text-center rounded-full font-semibold hover:bg-[#708CFF] duration-300">
                            Login
                        </a>
                    @endauth
                </li>
            </ul>
        </nav>
    </aside>
</div>