<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Berita -->
    <section class="bg-white p-6 shadow-lg rounded-lg">
        <div class="flex flex-col md:flex-row justify-end items-center mb-4 space-y-2 md:space-y-0">

            <!-- Form Pencarian dan Filter -->
            <form action="{{ route('dashboard.reports.index', ['status' => $status]) }}" method="GET">
                <div x-data="{ showModal: false }" class="relative flex items-center">

                    <!-- Tombol Filter -->
                    <button type="button" @click="showModal = true" aria-label="Tombol Filter"
                        class="bg-[#141652] hover:bg-blue-800 text-white border border-[#141652] rounded-l-full px-4 py-2 transition duration-200">
                        Filter
                    </button>

                    <!-- Input Pencarian -->
                    <input type="text" name="search" value="{{ $search }}"
                        class="w-full sm:w-auto px-4 py-2 border-y focus:outline-none focus:bg-blue-50"
                        placeholder="Cari laporan..." autocomplete="off" autofocus />

                    <!-- Tombol Submit -->
                    <button type="submit" aria-label="Tombol Cari"
                        class="bg-[#141652] hover:bg-blue-800 text-white border border-[#141652] rounded-r-full px-4 py-2 transition duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>

                    <!-- Modal Filter -->
                    <div x-cloak x-show="showModal"
                        class="fixed inset-0 bg-black/80 flex items-center justify-center z-20">
                        <div class="bg-white rounded-lg shadow-lg p-6 w-72 md:w-96">
                            <h2 class="text-lg font-semibold mb-3">Filter</h2>
                            <div class="mb-4">
                                <label for="start_date" class="block text-sm font-medium">Tanggal Awal</label>
                                <input type="date" name="start_date" id="start_date" value="{{ $start_date }}"
                                    class="w-full p-1 rounded-md border">
                            </div>
                            <div class="mb-4">
                                <label for="end_date" class="block text-sm font-medium">Tanggal Akhir</label>
                                <input type="date" name="end_date" id="end_date" value="{{ $end_date }}"
                                    class="w-full p-1 rounded-md border">
                            </div>
                            <div class="flex justify-end gap-2">
                                <button type="button" @click="showModal = false"
                                    class="bg-gray-700 text-white py-2 px-4 rounded-md hover:bg-gray-800">Batal</button>
                                <button type="submit"
                                    class="bg-green-700 text-white py-2 px-4 rounded-md hover:bg-green-800">Terapkan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Pesan Status -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 rounded relative mb-3">
                {{ session('success') }}</div>
        @elseif (session('error'))
            <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 rounded relative mb-3">
                {{ session('error') }}</div>
        @endif

        <!-- Tabel Berita -->
        <div class="overflow-x-auto rounded-md shadow-md">
            <table class="min-w-full bg-gray-100">
                <thead class="bg-[#141652] text-white">
                    <tr>
                        <th class="text-center py-3 px-2 text-sm font-semibold">#</th>
                        <th class="text-left py-3 px-2 text-sm font-semibold">Nomor Tiket</th>
                        <th class="text-center py-3 px-2 text-sm font-semibold">Jenis Kekerasan</th>
                        <th class="text-center py-3 px-2 text-sm font-semibold">Tempat Kejadian</th>
                        <th class="text-center py-3 px-2 text-sm font-semibold">Status</th>
                        <th class="text-center py-3 px-2 text-sm font-semibold">Dibuat</th>
                        <th class="text-center py-3 px-2 text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reports as $report)
                        <tr class="border-t hover:bg-blue-100 transition duration-200">
                            <td class="py-3 px-2 text-center">{{ $loop->iteration }}</td>
                            <td class="py-3 px-2">{{ $report->ticket_number }}</td>
                            <td class="py-3 px-2 text-center">{{ $report->violence_category }}</td>
                            <td class="py-3 px-2">{{ $report->district }}, {{ Str::limit($report->regency, 8) }}</td>
                            <td class="py-3 px-2 text-center">
                                <span
                                    class="px-3 py-1 text-xs rounded-full shadow-md 
                                        {{ $report->latestStatus->status == 'Diterima'
                                            ? 'bg-blue-600 hover:bg-blue-500'
                                            : ($report->latestStatus->status == 'Diproses'
                                                ? 'bg-yellow-600 hover:bg-yellow-500'
                                                : ($report->latestStatus->status == 'Selesai'
                                                    ? 'bg-green-600 hover:bg-green-500'
                                                    : 'bg-red-600 hover:bg-red-500')) }} text-white">
                                    {{ $report->latestStatus->status }}
                                </span>
                            </td>
                            <td class="py-3 px-2 text-center">
                                {{ \Carbon\Carbon::parse($report->created_at)->translatedFormat('d M Y') }}</td>
                            <td class="py-3 px-2 flex items-center justify-center gap-1">
                                <a href="{{ route('dashboard.reports.edit', $report->ticket_number) }}"
                                    class="bg-yellow-600 hover:bg-yellow-500 text-white px-2 py-1.5 font-medium uppercase rounded-md text-xs shadow-md">
                                    Ubah
                                </a>
                                @php
                                    $status = $report->latestStatus->status;
                                @endphp

                                @if ($status === 'Diterima')
                                    <a href="{{ route('dashboard.reports.received.show', ['status' => 'diterima', 'ticket_number' => $report->ticket_number]) }}"
                                        class="bg-green-600 hover:bg-green-500 text-white px-2 py-1.5 font-medium uppercase rounded-md text-xs shadow-md">
                                        Verifikasi
                                    </a>
                                @elseif ($status === 'Diproses')
                                    <a href="{{ route('dashboard.reports.processed.show', ['status' => 'diproses', 'ticket_number' => $report->ticket_number]) }}"
                                        class="bg-green-600 hover:bg-green-500 text-white px-2 py-1.5 font-medium uppercase rounded-md text-xs shadow-md">
                                        Ubah Status
                                    </a>
                                @elseif ($status === 'Selesai' or 'Dibatalkan')
                                    <a href="{{ route('dashboard.reports.completed.show', ['status' => 'selesai', 'ticket_number' => $report->ticket_number]) }}"
                                        class="bg-green-600 hover:bg-green-500 text-white px-2 py-1.5 font-medium uppercase rounded-md text-xs shadow-md">
                                        Lihat
                                    </a>
                                @endif
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
        <div class="mt-4">{{ $reports->links() }}</div>
    </section>

</x-app-layout>
