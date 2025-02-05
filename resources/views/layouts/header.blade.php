<!-- Header -->
<header class="flex items-center justify-between px-4 py-2 bg-white shadow">
    <!-- Judul Halaman -->
    <div class="flex items-center space-x-2">
        <button @click="sidebarOpen = !sidebarOpen" aria-label="humberger button" class="lg:hidden focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <div class="w-32 md:w-56 lg:w-64 overflow-hidden whitespace-nowrap text-ellipsis">
            <h2 class="text-md md:text-lg lg:text-xl font-bold">@yield('pageTitle')</h2>
        </div>
    </div>
    <!-- Profil User -->
    <div x-data="{ open: false }" class="relative flex items-center">
        <!-- Trigger (Nama, Jabatan, Gambar, dan Ikon) -->
        <div @click="open = !open" class="flex items-center space-x-1 cursor-pointer">
            <!-- Nama dan Jabatan -->
            <div class="text-right mr-1 hidden md:block">
                <h1 class="text-sm font-bold">
                    {{ auth()->user()->employee->name }}
                </h1>
                <p class="text-xs text-gray-500 leading-none">
                    {{ auth()->user()->role }}
                </p>
            </div>

            <!-- Gambar Profil -->
            <img src="{{ auth()->user()->employee->image ? asset('storage/' . auth()->user()->employee->image) : asset('img/profile-placeholder.jpg') }}"
                alt="Profile" class="size-12 rounded-full border-2">

            <!-- Dropdown Icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </div>

        <!-- Dropdown Menu -->
        <div x-cloak x-show="open" @click.outside="open = false" x-transition
            class="absolute top-full mt-1 right-0 w-48 bg-white border-2 border-gray-200 rounded-lg shadow-lg z-50">
            <a href="{{ route('home') }}"
                class="flex items-center gap-1 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                <span>Beranda</span>
            </a>
            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-1 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-4">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Profil Saya</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="flex items-center gap-1 w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-4">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>

</header>
