<x-app-layout>

    <!-- Bagian Title -->
    @section('title')
        @isset($title)
            | {{ $title }}
        @endisset
    @endsection

    <!-- Bagian Dashboard -->
    <section class="py-5 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Grid Layout Berita dan Karyawan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Statistik Berita -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                        </svg>
                        <h2 class="text-2xl font-bold">Statistik Berita</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Card: Jumlah Berita -->
                        <div
                            class="bg-blue-500 text-gray-100 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                            <div class="bg-blue-700 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m21 7.5-2.25-1.313M21 7.5v2.25m0-2.25-2.25 1.313M3 7.5l2.25-1.313M3 7.5l2.25 1.313M3 7.5v2.25m9 3 2.25-1.313M12 12.75l-2.25-1.313M12 12.75V15m0 6.75 2.25-1.313M12 21.75V19.5m0 2.25-2.25-1.313m0-16.875L12 2.25l2.25 1.313M21 14.25v2.25l-2.25 1.313m-13.5 0L3 16.5v-2.25" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm">Jumlah Berita</span>
                                <p class="text-3xl font-bold">{{ $postsCount }}</p>
                            </div>
                        </div>

                        <!-- Card: Status Terbit -->
                        <div
                            class="bg-green-500 text-gray-100 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                            <div class="bg-green-700 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm">Status Terbit</span>
                                <p class="text-2xl font-bold">{{ $statusTerbit }}</p>
                            </div>
                        </div>

                        <!-- Card: Status Diarsipkan -->
                        <div
                            class="bg-yellow-500 text-gray-100 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                            <div class="bg-yellow-700 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm">Status Diarsipkan</span>
                                <p class="text-3xl font-bold">{{ $statusDiarsipkan }}</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="mt-6 text-lg font-semibold">Berita Populer</h3>
                    <ul class="mt-4 space-y-4">
                        @foreach ($topPosts as $post)
                            <li
                                class="flex items-center bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div
                                    class="bg-yellow-500 text-white w-10 h-10 flex items-center justify-center rounded-full mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p
                                        class="text-base font-semibold text-gray-800 hover:underline hover:text-blue-600 transition-colors">
                                        {{ $post->title }}
                                    </p>
                                    <span class="text-sm text-gray-500">{{ $post->views }} views</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Statistik Karyawan -->
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-8">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        <h2 class="text-2xl font-bold">Statistik Karyawan</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-4">
                        <!-- Card: Jumlah Karyawan -->
                        <div
                            class="bg-blue-500 text-gray-100 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                            <div class="bg-blue-700 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm">Jumlah Karyawan</span>
                                <p class="text-3xl font-bold">{{ $employeesCount }}</p>
                            </div>
                        </div>

                        <!-- Card: Status Aktif -->
                        <div
                            class="bg-green-500 text-gray-100 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                            <div class="bg-green-700 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm">Status Aktif</span>
                                <p class="text-3xl font-bold">{{ $activeEmployees }}</p>
                            </div>
                        </div>

                        <!-- Card: Status Tidak Aktif -->
                        <div
                            class="bg-red-500 text-gray-100 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                            <div class="bg-red-700 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                            </div>
                            <div>
                                <span class="text-sm">Status Non Aktif</span>
                                <p class="text-3xl font-bold">{{ $inactiveEmployees }}</p>
                            </div>
                        </div>
                    </div>
                    <h3 class="mt-6 text-lg font-semibold">Karyawan Populer</h3>
                    <ul class="mt-4 space-y-4">
                        @foreach ($topPosters as $employee)
                            <li
                                class="flex items-center bg-gray-100 p-4 rounded-lg shadow-sm hover:shadow-md transition-shadow">
                                <div
                                    class="bg-yellow-500 text-white w-10 h-10 flex items-center justify-center rounded-full mr-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.5 18.75h-9m9 0a3 3 0 0 1 3 3h-15a3 3 0 0 1 3-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 0 1-.982-3.172M9.497 14.25a7.454 7.454 0 0 0 .981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 0 0 7.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 0 0 2.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 0 1 2.916.52 6.003 6.003 0 0 1-5.395 4.972m0 0a6.726 6.726 0 0 1-2.749 1.35m0 0a6.772 6.772 0 0 1-3.044 0" />
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p
                                        class="text-base font-semibold text-gray-800 hover:underline hover:text-blue-600 transition-colors">
                                        {{ $employee->name }}
                                    </p>
                                    <span class="text-sm text-gray-500">{{ $employee->posts_count }} posts</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Statistik Laporan -->
            <div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-xl transition-shadow">
                <div class="flex items-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-8">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>

                    <h2 class="text-2xl font-bold">Statistik Laporan</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    <!-- Card: Jumlah Laporan -->
                    <div
                        class="bg-blue-100 text-blue-800 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                        <div class="bg-blue-200 p-4 rounded-full">
                            <i class="fas fa-list text-3xl"></i>
                        </div>
                        <div>
                            <span class="text-sm text-blue-600">Jumlah Laporan</span>
                            <p class="text-2xl font-bold">{{ $reportsCount }}</p>
                        </div>
                    </div>

                    <!-- Card: Laporan Diterima -->
                    <div
                        class="bg-blue-100 text-green-800 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                        <div class="bg-green-200 p-4 rounded-full">
                            <i class="fas fa-check-circle text-3xl"></i>
                        </div>
                        <div>
                            <span class="text-sm text-green-600">Laporan Diterima</span>
                            <p class="text-2xl font-bold text-green-600">{{ $reportsDiterima }}</p>
                        </div>
                    </div>

                    <!-- Card: Laporan Diproses -->
                    <div
                        class="bg-blue-100 text-blue-800 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                        <div class="bg-blue-200 p-4 rounded-full">
                            <i class="fas fa-spinner text-3xl"></i>
                        </div>
                        <div>
                            <span class="text-sm text-blue-600">Laporan Diproses</span>
                            <p class="text-2xl font-bold text-blue-600">{{ $reportsDiproses }}</p>
                        </div>
                    </div>

                    <!-- Card: Laporan Selesai -->
                    <div
                        class="bg-indigo-100 text-indigo-800 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                        <div class="bg-indigo-200 p-4 rounded-full">
                            <i class="fas fa-check text-3xl"></i>
                        </div>
                        <div>
                            <span class="text-sm text-indigo-600">Laporan Selesai</span>
                            <p class="text-2xl font-bold text-indigo-600">{{ $reportsSelesai }}</p>
                        </div>
                    </div>

                    <!-- Card: Laporan Dibatalkan -->
                    <div
                        class="bg-red-100 text-red-800 shadow-lg rounded-lg p-5 flex items-center space-x-4 hover:shadow-xl transition-shadow">
                        <div class="bg-red-200 p-4 rounded-full">
                            <i class="fas fa-times-circle text-3xl"></i>
                        </div>
                        <div>
                            <span class="text-sm text-red-600">Laporan Dibatalkan</span>
                            <p class="text-2xl font-bold text-red-600">{{ $reportsDibatalkan }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
