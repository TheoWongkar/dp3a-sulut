<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Laporan -->
    <section class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
        <!-- Tambah dan Cari -->
        <div class="flex flex-col md:flex-row justify-end items-center mb-4 space-y-2 md:space-y-0">
            <form action="{{ route('dashboard.reports.received') }}" method="GET">
                <div x-data="{ showModal: false }" class="relative flex items-center">
                    <!-- Tombol Filter -->
                    <button type="button" @click="showModal = true"
                        class="bg-[#141652] hover:bg-blue-800 text-white border border-[#141652] rounded-l-full px-4 py-2 transition duration-200">
                        Filter
                    </button>
                    <!-- Filter Pencarian -->
                    <input type="text" name="search" value="{{ $search }}"
                        class="w-full sm:w-auto px-4 py-2 border-y focus:outline-none focus:bg-blue-50"
                        placeholder="Cari laporan..." autocomplete="off" autofocus />
                    <!-- Tombol Submit -->
                    <button type="submit"
                        class="bg-[#141652] hover:bg-blue-800 text-white border border-[#141652] rounded-r-full px-4 py-2 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                    <!-- Modal -->
                    <div x-cloak x-show="showModal"
                        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
                        <div class="bg-white rounded-lg shadow-lg p-6 w-72 md:w-96 ">
                            <h2 class="text-lg font-semibold mb-3">Filter</h2>
                            <!-- Tanggal Awal -->
                            <div class="mb-4">
                                <label for="start_date" class="block text-sm font-medium">Tanggal
                                    Awal</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $start_date }}"
                                    class="w-full p-1 rounded-md border border-[#141652] focus:ring-none focus:outline-none">
                            </div>
                            <!-- Tanggal Akhir -->
                            <div class="mb-4">
                                <label for="end_date" class="block text-sm font-medium">Tanggal
                                    Akhir</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $end_date }}"
                                    class="w-full p-1 rounded-md border border-[#141652] focus:ring-none focus:outline-none">
                            </div>
                            <!-- Tombol Aksi -->
                            <div class="flex justify-end gap-2">
                                <button type="button" @click="showModal = false"
                                    class="bg-gray-700 hover:bg-gray-800 text-white rounded px-4 py-2">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="bg-[#141652] hover:bg-blue-800 text-white rounded px-4 py-2">
                                    Terapkan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Pesan Berhasil -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 rounded relative mb-3"
                role="alert">
                <span>{{ session('success') }}</span>
            </div>
        @elseif (session('error'))
            <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 rounded relative mb-3" role="alert">
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <!-- Tabel Berita -->
        <div class="overflow-x-auto rounded-md shadow-md">
            <table class="min-w-full bg-gray-100">
                <thead class="bg-[#141652] text-white">
                    <tr>
                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm">#</th>
                        <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Nomor Tiket</th>
                        <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Kategori Kekerasan</th>
                        <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Tempat Kejadian</th>
                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Status</th>
                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Dibuat</th>
                        <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-t hover:bg-blue-100 transition duration-200">
                            <td class="py-3 px-2 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2 whitespace-nowrap">{{ $report->ticket_number }}</td>
                            <td class="py-3 px-2">{{ $report->violence_category }}</td>
                            <td class="py-3 px-2">{{ Str::limit($report->scene, 20) }}</td>
                            <td class="py-4 px-2 text-center">
                                <span
                                    class="{{ $report->latestStatus->status === 'Diterima' ? 'bg-blue-500 hover:bg-blue-600' : '' }}
                                        inline-block px-3 py-1 rounded-full text-xs shadow-md text-white transition duration-200">
                                    {{ $report->latestStatus->status }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-center whitespace-nowrap">
                                {{ $report->created_at->format('d M Y') }}</td>
                            <td class="py-1 px-2 text-center whitespace-nowrap">
                                <div class="flex justify-center items-center space-x-1">
                                    @can('verification-report', $report)
                                        <a href="{{ route('dashboard.reports.received-show', $report->ticket_number) }}"
                                            class="bg-green-700 hover:bg-green-800 text-white p-2 rounded-md text-xs font-medium shadow-md uppercase">
                                            Verifikasi
                                        </a>
                                        <form
                                            action="{{ route('dashboard.reports.received-destroy', $report->ticket_number) }}"
                                            method="POST"
                                            onsubmit="return confirm('Laporan dihapus permanen dari database?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="bg-red-700 hover:bg-red-800 text-white p-2 rounded-md text-xs font-medium shadow-md uppercase">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <button onclick="alert('Akun anda tidak diizinkan untuk verifikasi data');"
                                            class="bg-green-700 hover:bg-green-800 text-white p-2 rounded-md text-xs font-medium shadow-md uppercase opacity-50">
                                            Verifikasi
                                        </button>
                                        <button type="submit"
                                            onclick="alert('Akun anda tidak diizinkan untuk menghapus data yang belum diverifikasi');"
                                            class="bg-red-700 hover:bg-red-800 text-white p-2 rounded-md text-xs font-medium shadow-md uppercase opacity-50">
                                            Hapus
                                        </button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <h3 class="font-medium text-red-500">Maaf, laporan tidak ada</h3>
                                <p class="text-sm text-gray-500">Silakan cek kembali nanti!</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $reports->links() }}
        </div>
    </section>

</x-app-layout>
