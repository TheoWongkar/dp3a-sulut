<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Cek Status Laporan</x-slot>

    {{-- Bagian Cek Status Laporan --}}
    <section class="relative z-10 -mt-[70vh] md:-mt-screen max-w-3xl mx-auto px-5 py-10">
        <div class="rounded-xl bg-gray-100 border-b border-gray-300 shadow p-10 space-y-10">

            {{-- Input Tiket --}}
            <div class="max-w-xl mx-auto text-center space-y-6">
                {{-- Judul --}}
                <h2 class="text-2xl font-semibold text-gray-800">
                    Masukkan Nomor Tiket Laporan Anda
                </h2>

                {{-- Keterangan --}}
                <p class="text-sm text-gray-700 leading-relaxed">
                    Mohon masukkan nomor tiket laporan untuk melihat status laporan.
                    Nomor tiket laporan Anda dapatkan setelah Anda mengirim formulir laporan kekerasan.
                </p>

                {{-- Form Pencarian --}}
                <form action="{{ route('report.check-status') }}" method="GET" class="flex items-center w-full gap-2">
                    <div class="relative w-full">
                        <input type="text" name="ticket_number" value="{{ old('ticket_number', $ticketNumber) }}"
                            placeholder="Contoh: TKT-123....." autofocus
                            class="w-full pr-10 pl-5 py-3 bg-white text-black shadow border border-gray-300 rounded-full focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <button type="submit" aria-label="Search Button"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center cursor-pointer text-gray-500 hover:text-blue-500">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search size-5" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                            </svg>
                        </button>
                    </div>
                </form>

                @if (!request('ticket_number') || !$report)
                    <p class="text-sm text-gray-700">
                        Belum membuat laporan?
                        <a href="{{ route('report.create') }}" class="text-blue-600 hover:underline">
                            Buat laporan sekarang
                        </a>
                    </p>
                @endif
            </div>

            {{-- Status Laporan --}}
            @if (request('ticket_number'))
                @if ($report)
                    <div class="flex flex-col md:flex-row gap-5 justify-center">

                        {{-- Informasi Laporan --}}
                        <div class="w-full md:w-1/3 bg-white rounded-xl shadow p-5 space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Laporan</h3>

                            <div class="space-y-1">
                                <p class="text-xs text-gray-500 uppercase font-semibold">Nomor Tiket</p>
                                <p class="text-sm text-gray-700 font-medium">{{ $report->ticket_number }}</p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-xs text-gray-500 uppercase font-medium">Jenis Kekerasan</p>
                                <p class="text-sm text-gray-700">{{ $report->violence_category }}</p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-xs text-gray-500 uppercase font-medium">Tanggal Kejadian</p>
                                <p class="text-sm text-gray-700">
                                    {{ \Carbon\Carbon::parse($report->incident_date)->translatedFormat('d F Y') }}</p>
                            </div>

                            <div class="space-y-1">
                                <p class="text-xs text-gray-500 uppercase font-medium">Lokasi Kejadian</p>
                                <p class="text-sm text-gray-700">{{ $report->scene }}, {{ $report->district }},
                                    {{ $report->regency }}</p>
                            </div>
                        </div>

                        {{-- Riwayat Status --}}
                        <div class="w-full md:w-1/2 bg-white rounded-xl shadow p-5">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2 mb-4">Riwayat Status</h3>

                            @if ($report->statuses->isEmpty())
                                <p class="text-sm text-gray-500 italic">Belum ada status yang tercatat.</p>
                            @else
                                <ol class="relative border-l border-gray-300 space-y-6">
                                    @foreach ($report->statuses as $status)
                                        <li class="ml-4 relative">
                                            <div
                                                class="absolute w-3 h-3 rounded-full -left-5.5 top-1.5 
                                                {{ $loop->last ? 'bg-blue-500' : 'bg-gray-400' }}">
                                            </div>

                                            <p
                                                class="text-sm font-semibold {{ $loop->last ? 'text-blue-700' : 'text-gray-800' }}">
                                                {{ $status->status }}
                                            </p>
                                            <p class="text-sm {{ $loop->last ? 'text-blue-600' : 'text-gray-600' }}">
                                                {{ $status->description }}
                                            </p>
                                            <p class="text-xs text-gray-400">
                                                {{ \Carbon\Carbon::parse($status->created_at)->translatedFormat('d F Y | H:i') }}
                                            </p>
                                        </li>
                                    @endforeach
                                </ol>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="p-4 rounded-md bg-yellow-100 text-yellow-800 text-sm">
                        Laporan tidak ditemukan.
                    </div>
                @endif
            @endif
        </div>
    </section>

</x-guest-layout>
