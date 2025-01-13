<!-- Bagian Navigasi -->
<header class="bg-[#141652] text-white">
    <!-- Menu Navbar -->
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" x-data="{ open: false }">
        <div class="flex justify-between items-center h-16">
            <!-- Logo -->
            <a href="{{ route('dashboard') }}" class="flex items-center">
                <x-application-logo class="w-8 h-8 mr-2 fill-current" />
                <span class="text-white text-lg font-semibold">DP3A SULUT</span>
            </a>
            <!-- Link Navigasi -->
            <div class="hidden md:flex space-x-1 font-normal">
                <a href="{{ route('dashboard') }}"
                    class="hover:bg-blue-700 px-3 py-2 rounded-md text-sm flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21M3 21h18M12 6.75h.008v.008H12V6.75Z" />
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('dashboard.posts.index') }}"
                    class="hover:bg-blue-700 px-3 py-2 rounded-md text-sm flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                    </svg>
                    <span>Berita</span>
                </a>
                <a href="{{ route('dashboard.reports.index') }}"
                    class="hover:bg-blue-700 px-3 py-2 rounded-md text-sm flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                    <span>Laporan</span>
                </a>
                <a href="{{ route('dashboard.employees.index') }}"
                    class="hover:bg-blue-700 px-3 py-2 rounded-md text-sm flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                    </svg>
                    <span>Data Admin</span>
                </a>
                <div class="relative">
                    <button @click="open = !open"
                        class="hover:bg-blue-700 px-3 py-2 rounded-md text-sm flex items-center">
                        <span>
                            @auth
                                {{ Str::limit(auth()->user()->name, 12) }}
                            @else
                                User Admin
                            @endauth
                        </span>
                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <!-- Menu Dropdown -->
                    <div x-show="open" @click.away="open = false"
                        class="absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-md py-1 z-10">
                        <a href="#"
                            class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 flex items-center space-x-1">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span>Profile</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-200 flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-5">
                                    <path fill-rule="evenodd"
                                        d="M16.5 3.75a1.5 1.5 0 0 1 1.5 1.5v13.5a1.5 1.5 0 0 1-1.5 1.5h-6a1.5 1.5 0 0 1-1.5-1.5V15a.75.75 0 0 0-1.5 0v3.75a3 3 0 0 0 3 3h6a3 3 0 0 0 3-3V5.25a3 3 0 0 0-3-3h-6a3 3 0 0 0-3 3V9A.75.75 0 1 0 9 9V5.25a1.5 1.5 0 0 1 1.5-1.5h6ZM5.78 8.47a.75.75 0 0 0-1.06 0l-3 3a.75.75 0 0 0 0 1.06l3 3a.75.75 0 0 0 1.06-1.06l-1.72-1.72H15a.75.75 0 0 0 0-1.5H4.06l1.72-1.72a.75.75 0 0 0 0-1.06Z"
                                        clip-rule="evenodd" />
                                </svg>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- Tombol Menu Mobile -->
            <div class="md:hidden">
                <button @click="open = !open" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Menu Mobile -->
        <div x-show="open" @click.away="open = false" class="md:hidden bg-[#141652] pb-4 text-sm text-white">
            <p class="text-xs text-gray-400">MENU:</p>
            <a href="{{ route('dashboard') }}" class="block py-2 px-4 rounded-md  hover:bg-blue-700">Dashboard</a>
            <a href="{{ route('dashboard.posts.index') }}"
                class="block py-2 px-4 rounded-md hover:bg-blue-700">Berita</a>
            <a href="{{ route('dashboard.reports.index') }}"
                class="block py-2 px-4 rounded-md hover:bg-blue-700">Laporan</a>
            <a href="{{ route('dashboard.employees.index') }}"
                class="block py-2 px-4 rounded-md hover:bg-blue-700">Data Admin</a>
            <p class="text-xs text-gray-400 mt-3">
                USER:
            </p>
            <p class="block py-2 px-4 rounded-md text-gray-300">
                @auth
                    {{ auth()->user()->name }}
                @else
                    User Admin
                @endauth
            </p>
            <a href="#" class="block py-2 px-4 rounded-md hover:bg-blue-700">Profile</a>
            <a href="#" class="block py-2 px-4 rounded-md hover:bg-blue-700">Logout</a>
        </div>
    </nav>
</header>
