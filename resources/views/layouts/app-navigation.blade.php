<!-- Sidebar Overlay -->
<div x-show="sidebarOpen" class="fixed inset-0 z-20 xl:hidden" style="background: rgba(0, 0, 0, 0.842);"
    @click="sidebarOpen = false">
</div>

<!-- Sidebar -->
<aside
    class="fixed inset-y-0 z-30 w-64 bg-[#141652] shadow-md xl:static xl:shadow-none xl:translate-x-0 transform transition-transform duration-300"
    :class="{ '-translate-x-full': !sidebarOpen, 'translate-x-0': sidebarOpen }">

    <!-- Logo dan Judul -->
    <div class="px-6 py-4 flex items-center gap-2">
        <img src="{{ asset('img/application-logo.svg') }}" alt="Logo DP3A Sulut" class="w-12 h-12">
        <div>
            <h1 class="text-3xl font-bold text-white leading-none">
                DP3A <span class="block text-sm font-semibold text-gray-300 leading-none">Sulawesi Utara</span>
            </h1>
        </div>
    </div>

    <!-- Navigasi Utama -->
    <nav class="flex-1 p-4 space-y-2 font-light">

        <!-- Menu Utama -->
        <div>
            <h2 class="px-2 py-1 font-medium text-gray-400">Menu</h2>

            <!-- Dashboard -->
            <a href="{{ route('dashboard') }}"
                class="{{ Request::routeIs('dashboard') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                </svg>
                <span class="inline">Dashboard</span>
            </a>

            <!-- Berita -->
            <a href="#"
                class="{{ Request::routeIs('dashboard.posts.*') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                </svg>
                <span>Berita</span>
            </a>

            <!-- Data Karyawan -->
            <a href="#"
                class="{{ Request::routeIs('dashboard.employees.*') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                </svg>
                <span>Data Karyawan</span>
            </a>
        </div>

        <!-- Laporan -->
        <div>
            <h2 class="px-2 py-1 font-medium text-gray-400">Laporan</h2>

            <!-- Kasus Baru -->
            <a href="#"
                class="{{ Request::routeIs('dashboard.reports.create') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="inline">Kasus Baru</span>
            </a>

            <!-- Laporan Kasus -->
            <a href="#"
                class="{{ Request::routeIs('dashboard.reports.received') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m9 12.75 3 3m0 0 3-3m-3 3v-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Laporan Kasus</span>
            </a>

            <!-- Laporan Diproses -->
            <a href="#"
                class="{{ Request::routeIs('dashboard.reports.processed') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Laporan Diproses</span>
            </a>

            <!-- Laporan Selesai -->
            <a href="#"
                class="{{ Request::routeIs('dashboard.reports.completed') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span>Laporan Selesai</span>
            </a>
        </div>

        <!-- Lainnya -->
        <div>
            <h2 class="px-2 py-1 font-medium text-gray-400">Lainnya</h2>

            <!-- Data Anda -->
            <a href="{{ route('profile.show') }}"
                class="{{ Request::routeIs('profile.show') ? 'animate-pulse' : 'animate-none' }} flex gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>
                <span class="inline">Data Anda</span>
            </a>

            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="flex w-full gap-4 px-4 py-1.5 text-white rounded hover:bg-gray-200 hover:text-gray-900">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15M12 12h7.5M12 12v7.5M12 12H4.5" />
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </nav>
</aside>
