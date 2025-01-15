<x-app-layout>

    <!-- Bagian Title -->
    @section('title')
        @isset($title)
            | {{ $title }}
        @endisset
    @endsection

    <!-- Bagian Laporan Diterima -->
    <div class="py-5 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <!-- Tambah dan Cari -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                    <!-- Laporan Diterima -->
                    <div
                        class="flex items-center bg-blue-500 hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition duration-200 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        Laporan Belum Ditanggapi
                    </div>
                    <!-- Cari Laporan Diterima -->
                    <form action="{{ route('dashboard.reports.index') }}" method="GET" class="flex w-full md:w-1/3">
                        <select name="receivedStatus"
                            class="bg-[#141652] text-white rounded-l-full px-4 py-2 border focus:ring-0 focus:border-blue-800">
                            <option value="Diterima" {{ $status === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            </option>
                        </select>
                        <input type="text" name="receivedSearch" value="{{ $receivedSearch }}"
                            class="px-4 py-2 w-full border-y focus:outline-none focus:bg-blue-50"
                            placeholder="Cari laporan..." autocomplete="off" autofocus />
                        <button type="submit"
                            class="flex items-center justify-center bg-[#141652] hover:bg-blue-800 text-white rounded-r-full px-4 py-2 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </form>
                </div>
                <!-- Tabel Laporan Diterima -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-100 rounded-xl shadow-md">
                        <thead class="bg-[#141652] text-white">
                            <tr>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">#</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Nomor Tiket</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Kategori Kekerasan</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Diterima Oleh</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Status</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Dibuat</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($receivedReports as $report)
                                <tr class="border-t hover:bg-blue-100 transition duration-200">
                                    <td class="py-4 px-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-2">{{ $report->ticket_number }}</td>
                                    <td class="py-4 px-2">{{ $report->violence_category }}</td>
                                    <td class="py-4 px-2">{{ $report->employee->user->name ?? '' }}</td>
                                    <td class="py-4 px-2 text-center">
                                        <span
                                            class="{{ $report->latestStatus->status === 'Diterima' ? 'bg-blue-500 hover:bg-blue-600' : '' }}
                                            inline-block px-3 py-1 rounded-full text-xs shadow-md text-white transition duration-200">
                                            {{ $report->latestStatus->status }}
                                        </span>

                                    </td>
                                    <td class="py-4 px-2 text-center">{{ $report->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-2 flex space-x-2 justify-center">
                                        <a href="{{ route('dashboard.reports.show', $report->ticket_number) }}"
                                            class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Lihat</a>
                                        <form action="{{ route('dashboard.reports.destroy', $report->ticket_number) }}"
                                            method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-2">
                                        <h1 class="text-md font-semibold text-red-500">Maaf, laporan tidak ada</h1>
                                        <p class="text-sm text-gray-500">Silakan cek kembali nanti!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $receivedReports->links() }}
                </div>
            </div>
        </div>
    </div>

    <!-- Bagian Laporan -->
    <div class="py-5 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <!-- Cari Laporan -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                    <!-- Laporan Diterima -->
                    <div
                        class="flex items-center bg-[#141652] hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition duration-200 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m20.25 7.5-.625 10.632a2.25 2.25 0 0 1-2.247 2.118H6.622a2.25 2.25 0 0 1-2.247-2.118L3.75 7.5m8.25 3v6.75m0 0-3-3m3 3 3-3M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125Z" />
                        </svg>
                        Semua Laporan
                    </div>
                    <form action="{{ route('dashboard.reports.index') }}#reports" method="GET"
                        class="flex w-full md:w-1/3">
                        <select name="status"
                            class="bg-[#141652] text-white rounded-l-full px-4 py-2 border focus:ring-0 focus:border-blue-800">
                            <option value="">Status</option>
                            <option value="Diterima" {{ $status === 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Diproses" {{ $status === 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ $status === 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Dibatalkan" {{ $status === 'Dibatalkan' ? 'selected' : '' }}>Dibatalkan
                            </option>
                        </select>
                        <input type="text" name="search" value="{{ $search }}"
                            class="px-4 py-2 w-full border-y focus:outline-none focus:bg-blue-50"
                            placeholder="Cari laporan..." autocomplete="off" autofocus />
                        <button type="submit"
                            class="flex items-center justify-center bg-[#141652] hover:bg-blue-800 text-white rounded-r-full px-4 py-2 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Pesan Berhasil -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 rounded relative mb-3"
                        role="alert">
                        <span>{{ session('success') }}</span>
                    </div>
                @elseif (session('error'))
                    <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 rounded relative mb-3"
                        role="alert">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Tabel Laporan -->
                <div class="overflow-x-auto">
                    <table id="reports" class="min-w-full bg-gray-100 rounded-xl shadow-md">
                        <thead class="bg-[#141652] text-white">
                            <tr>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">#</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Nomor Tiket</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Kategori Kekerasan</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Diterima Oleh</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Status</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Dibuat</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($reports as $report)
                                <tr class="border-t hover:bg-blue-100 transition duration-200">
                                    <td class="py-4 px-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-2">{{ $report->ticket_number }}</td>
                                    <td class="py-4 px-2">{{ $report->violence_category }}</td>
                                    <td class="py-4 px-2">{{ $report->employee->user->name ?? '' }}</td>
                                    <td class="py-4 px-2 text-center">
                                        <span
                                            class="{{ $report->latestStatus->status === 'Diterima' ? 'bg-blue-500 hover:bg-blue-600' : '' }}
                                            {{ $report->latestStatus->status === 'Diproses' ? 'bg-yellow-500 hover:bg-yellow-600' : '' }}
                                            {{ $report->latestStatus->status === 'Selesai' ? 'bg-green-500 hover:bg-green-600' : '' }}
                                            {{ $report->latestStatus->status === 'Dibatalkan' ? 'bg-red-500 hover:bg-red-600' : '' }}
                                            inline-block px-3 py-1 rounded-full text-xs shadow-md text-white transition duration-200">
                                            {{ $report->latestStatus->status }}
                                        </span>

                                    </td>
                                    <td class="py-4 px-2 text-center">{{ $report->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-2 flex space-x-2 justify-center">
                                        <a href="{{ route('dashboard.reports.show', $report->ticket_number) }}"
                                            class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Lihat</a>
                                        <form
                                            action="{{ route('dashboard.reports.destroy', $report->ticket_number) }}#reports"
                                            method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="bg-red-600 hover:bg-red-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-2">
                                        <h1 class="text-md font-semibold text-red-500">Maaf, laporan tidak ada</h1>
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
            </div>
        </div>
    </div>

</x-app-layout>
