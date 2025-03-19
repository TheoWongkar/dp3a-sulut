<x-guest-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    @if (isset($report))
        <!-- Bagian Tampil Status -->
        <section
            class="bg-[#E9F0FF] min-h-screen flex flex-col items-center pt-24 pb-10 px-4 md:px-8 lg:px-16 space-y-6">
            <div class="bg-white w-full max-w-6xl py-4 px-6 rounded-md">
                <h1 class="text-lg font-bold">STATUS LAPORAN</h1>
            </div>
            <div
                class="bg-white w-full max-w-6xl p-8 rounded-md shadow-md flex flex-col md:flex-row justify-between space-y-6 md:space-y-0 md:space-x-6">
                <!-- Informasi Laporan -->
                <div class="p-6 rounded-md shadow-lg w-full md:w-1/3">
                    <h2 class="text-lg font-semibold">Informasi Laporan</h2>
                    <div class="mt-3 space-y-2">
                        <p class="mt-4 text-sm font-medium">Nomor Tiket: <span
                                class="block">{{ $report->ticket_number }}</span></p>
                        <p class="text-sm">Tanggal Kejadian: <span
                                class="block">{{ \Carbon\Carbon::parse($report->date)->translatedFormat('d M Y') }}
                            </span></p>
                        <p class="text-sm">Kategori: <span class="block">{{ $report->violence_category }}</span></p>
                        <p class="text-sm">Lokasi: <span class="block">{{ $report->scene }}</span></p>
                    </div>
                </div>

                <!-- Status Laporan -->
                <div class="p-6 rounded-md shadow-lg w-full md:w-2/3">
                    <h2 class="text-lg font-semibold">Status Laporan</h2>
                    <ul class="mt-4 space-y-2">
                        @foreach ($report->statuses as $status)
                            <li>{{ $status->created_at->format('H:i d/m/Y') }}
                                - {{ $status->status }} : {{ $status->description }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>
    @else
        <!-- Bagian Cek Status -->
        <section class="min-h-screen flex items-center justify-center px-4">
            <div
                class="bg-[#DCE8FF] px-8 py-6 sm:px-10 sm:py-8 lg:px-10 lg:py-10 rounded-lg shadow-xl max-w-2xl w-full">
                <h1 class="text-2xl lg:text-3xl font-bold mb-4 text-center">Masukkan Nomor Tiket Laporan
                    Anda</h1>
                <p class="mb-6 leading-relaxed text-center md:text-justify">Mohon masukkan nomor tiket laporan untuk
                    melihat status laporan. Nomor tiket laporan seharusnya anda dapatkan setelah anda mengirim formulir
                    laporan kekerasan.
                </p>
                <form action="{{ route('status.index') }}" method="GET">
                    <div class="flex items-center border-2 rounded-3xl p-2 bg-white">
                        <button type="submit" aria-label="Cari laporan">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="size-6 hover:text-green-500 hover:cursor-pointer" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                        <input type="text" name="search" value="{{ $search }}"
                            placeholder="Masukkan nomor tiket laporan" autofocus autocomplete="off"
                            class="ml-2 w-full bg-white border-none focus:outline-none focus:ring-0 text-sm md:text-lg">
                    </div>
                </form>
                <p class="mt-5 text-center">Belum membuat laporan? <a href="{{ route('reports.create') }}"
                        class="font-medium text-blue-700 hover:text-blue-800">Buat
                        Laporan Sekarang</a></p>
                <p class="mt-7 text-center text-sm">Butuh bantuan? <a href="#"
                        class="font-medium text-blue-700 hover:text-blue-800">Chat virtual
                        asistenmu di sini</a></p>
            </div>
        </section>
    @endif

</x-guest-layout>
