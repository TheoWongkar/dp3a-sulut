<div x-show="sidebarOpen" @click="sidebarOpen = false"
    class="fixed inset-0 bg-black/50 z-20 transition-opacity scrollbar-custom md:hidden"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
</div>

{{-- Sidebar Utama --}}
<div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-30 w-64 transform bg-[#141652] text-white transition duration-300 md:translate-x-0 md:static md:inset-0 flex flex-col">

    {{-- Header Sidebar --}}
    <div class="flex items-center space-x-3 px-4 py-4">
        {{-- Logo Gambar --}}
        <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Pemprov Sulut" class="w-12 h-12 object-contain">

        {{-- Tulisan --}}
        <div class="leading-tight">
            <h2 class="text-3xl font-bold">DP3A</h2>
            <span class="text-gray-100">Sulawesi Utara</span>
        </div>
    </div>

    {{-- Navigasi Menu --}}
    <nav class="flex-1 overflow-y-auto pl-4 space-y-3">
        {{-- Dashboard --}}
        <div>
            <h1 class="mb-1 text-xs text-gray-400 font-bold uppercase">Dashboard</h1>
            <a href="{{ route('dashboard') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard') ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-house-door-fill" viewBox="0 0 16 16">
                    <path
                        d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5" />
                </svg>
                <span>Dashboard</span>
            </a>
        </div>

        {{-- Pegawai --}}
        @can('viewAny', App\Models\Employee::class)
            <div>
                <h1 class="mb-1 text-xs text-gray-400 font-bold uppercase">Kepegawaian</h1>
                <a href="{{ route('dashboard.employee.index') }}"
                    class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.employee.index') ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-people-fill" viewBox="0 0 16 16">
                        <path
                            d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5" />
                    </svg>
                    <span>Data Pegawai</span>
                </a>
            </div>
        @endcan

        {{-- Berita --}}
        <div>
            <h1 class="mb-1 text-xs text-gray-400 font-bold uppercase">Media</h1>
            <a href="{{ route('dashboard.post.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.post.*') ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-file-post" viewBox="0 0 16 16">
                    <path
                        d="M4 3.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5z" />
                    <path
                        d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm10-1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1" />
                </svg>
                <span>Kelola Berita</span>
            </a>
            <a href="{{ route('dashboard.post-category.index') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.post-category.*') ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-tags-fill" viewBox="0 0 16 16">
                    <path
                        d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3" />
                    <path
                        d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043z" />
                </svg>
                <span>Kategori Berita</span>
            </a>
        </div>

        {{-- Laporan --}}
        <div>
            <h1 class="mb-1 text-xs text-gray-400 font-bold uppercase">Laporan</h1>
            <a href="{{ route('dashboard.report.create') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.report.create') ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-file-earmark-plus-fill text-purple-500" viewBox="0 0 16 16">
                    <path
                        d="M9.293 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V4.707A1 1 0 0 0 13.707 4L10 .293A1 1 0 0 0 9.293 0M9.5 3.5v-2l3 3h-2a1 1 0 0 1-1-1M8.5 7v1.5H10a.5.5 0 0 1 0 1H8.5V11a.5.5 0 0 1-1 0V9.5H6a.5.5 0 0 1 0-1h1.5V7a.5.5 0 0 1 1 0" />
                </svg>
                <span>Kasus Baru</span>
            </a>
            <a href="{{ route('dashboard.report.index', 'diterima') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.report.*') && request()->route('status') == 'diterima' ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-person-vcard-fill text-blue-500" viewBox="0 0 16 16">
                    <path
                        d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm9 1.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4a.5.5 0 0 0-.5.5M9 8a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 0-1h-4A.5.5 0 0 0 9 8m1 2.5a.5.5 0 0 0 .5.5h3a.5.5 0 0 0 0-1h-3a.5.5 0 0 0-.5.5m-1 2C9 10.567 7.21 9 5 9c-2.086 0-3.8 1.398-3.984 3.181A1 1 0 0 0 2 13h6.96q.04-.245.04-.5M7 6a2 2 0 1 0-4 0 2 2 0 0 0 4 0" />
                </svg>
                <span>Diterima</span>
            </a>
            <a href="{{ route('dashboard.report.index', 'menunggu-verifikasi') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.report.*') && request()->route('status') == 'menunggu-verifikasi' ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-patch-check-fill text-yellow-500" viewBox="0 0 16 16">
                    <path
                        d="M10.067.87a2.89 2.89 0 0 0-4.134 0l-.622.638-.89-.011a2.89 2.89 0 0 0-2.924 2.924l.01.89-.636.622a2.89 2.89 0 0 0 0 4.134l.637.622-.011.89a2.89 2.89 0 0 0 2.924 2.924l.89-.01.622.636a2.89 2.89 0 0 0 4.134 0l.622-.637.89.011a2.89 2.89 0 0 0 2.924-2.924l-.01-.89.636-.622a2.89 2.89 0 0 0 0-4.134l-.637-.622.011-.89a2.89 2.89 0 0 0-2.924-2.924l-.89.01zm.287 5.984-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708.708" />
                </svg>
                <span>Menunggu Verifikasi</span>
            </a>
            <a href="{{ route('dashboard.report.index', 'diproses') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.report.*') && request()->route('status') == 'diproses' ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-hourglass-split text-amber-500" viewBox="0 0 16 16">
                    <path
                        d="M2.5 15a.5.5 0 1 1 0-1h1v-1a4.5 4.5 0 0 1 2.557-4.06c.29-.139.443-.377.443-.59v-.7c0-.213-.154-.451-.443-.59A4.5 4.5 0 0 1 3.5 3V2h-1a.5.5 0 0 1 0-1h11a.5.5 0 0 1 0 1h-1v1a4.5 4.5 0 0 1-2.557 4.06c-.29.139-.443.377-.443.59v.7c0 .213.154.451.443.59A4.5 4.5 0 0 1 12.5 13v1h1a.5.5 0 0 1 0 1zm2-13v1c0 .537.12 1.045.337 1.5h6.326c.216-.455.337-.963.337-1.5V2zm3 6.35c0 .701-.478 1.236-1.011 1.492A3.5 3.5 0 0 0 4.5 13s.866-1.299 3-1.48zm1 0v3.17c2.134.181 3 1.48 3 1.48a3.5 3.5 0 0 0-1.989-3.158C8.978 9.586 8.5 9.052 8.5 8.351z" />
                </svg>
                <span>Diproses</span>
            </a>
            <a href="{{ route('dashboard.report.index', 'selesai') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.report.*') && request()->route('status') == 'selesai' ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-check-circle-fill text-green-500" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                </svg>
                <span>Selesai</span>
            </a>
            <a href="{{ route('dashboard.report.index', 'dibatalkan') }}"
                class="flex items-center space-x-3 px-4 py-2 text-sm font-semibold rounded-l-full hover:bg-blue-100 {{ Route::is('dashboard.report.*') && request()->route('status') == 'dibatalkan' ? 'bg-gray-100 text-gray-800' : 'text-white hover:text-gray-800' }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-x-circle-fill text-red-500" viewBox="0 0 16 16">
                    <path
                        d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M5.354 4.646a.5.5 0 1 0-.708.708L7.293 8l-2.647 2.646a.5.5 0 0 0 .708.708L8 8.707l2.646 2.647a.5.5 0 0 0 .708-.708L8.707 8l2.647-2.646a.5.5 0 0 0-.708-.708L8 7.293z" />
                </svg>
                <span>Dibatalkan</span>
            </a>
        </div>
    </nav>
</div>
