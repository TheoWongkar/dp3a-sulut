<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Aksi Laporan -->
    <section class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
        <!-- Informasi Laporan -->
        <div class="flex items-center">
            <h2 class="text-xl font-semibold mb-2">Informasi Laporan</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
            <div>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between">
                        <h3 class="font-medium">Nomor Tiket:</h3>
                        <span class="font-medium">{{ $report->ticket_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <h3 class="font-medium">Tanggal Kejadian:</h3>
                        <span
                            class="text-gray-800">{{ \Carbon\Carbon::parse($report->date)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <h3 class="font-medium">Jenis Kekerasan:</h3>
                        <span class="text-gray-800">{{ $report->violence_category }}</span>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-medium">Tempat Kejadian:</h3>
                        <span class="text-gray-800">{{ $report->scene }}</span>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-medium text-black">Kronologi Kejadian:</h3>
                        <span class="text-gray-800">{{ $report->chronology }}</span>
                    </div>
                </div>
            </div>
            <div>
                <div class="mt-4">
                    <div class="max-w-full max-h-50 overflow-y-auto border rounded-md">
                        <img src="{{ $report->evidence ? asset('storage/' . $report->evidence) : asset('img/placeholder-image.webp') }}"
                            alt="Bukti Pendukung" class="w-full h-auto object-contain rounded-lg">
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Korban, Pelaku, Pelapor -->
        <div class="mt-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            <!-- Informasi Korban -->
            <div>
                <h2 class="text-xl font-semibold text-black">Informasi Korban</h2>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">NIK:</span>
                        <span class="text-gray-800">{{ $report->victim->nik }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Nama:</span>
                        <span class="text-gray-800">{{ $report->victim->name }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Telepon:</span>
                        <span class="text-gray-800">{{ $report->victim->phone }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Usia:</span>
                        <span class="text-gray-800">{{ $report->victim->age }} tahun</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Jenis Kelamin:</span>
                        <span class="text-gray-800">{{ $report->victim->gender }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-medium">Alamat:</span>
                        <span class="text-gray-800">{{ $report->victim->address }}</span>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-medium">Deskripsi:</h3>
                        <span class="text-gray-800">{{ $report->victim->description }}</span>
                    </div>
                </div>
            </div>

            <!-- Informasi Terduga -->
            <div>
                <h2 class="text-xl font-semibold text-black">Informasi Terduga</h2>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">NIK:</span>
                        <span class="text-gray-800">{{ $report->suspect->nik }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Nama:</span>
                        <span class="text-gray-800">{{ $report->suspect->name }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Telepon:</span>
                        <span class="text-gray-800">{{ $report->suspect->phone }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Usia:</span>
                        <span class="text-gray-800">{{ $report->suspect->age }} tahun</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Jenis Kelamin:</span>
                        <span class="text-gray-800">{{ $report->suspect->gender }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-medium">Alamat:</span>
                        <span class="text-gray-800">{{ $report->suspect->address }}</span>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-medium">Deskripsi:</h3>
                        <span class="text-gray-800">{{ $report->suspect->description }}</span>
                    </div>
                </div>
            </div>

            <!-- Informasi Pelapor -->
            <div>
                <h2 class="text-xl font-semibold text-black">Informasi Korban</h2>
                <div class="mt-4 space-y-2">
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">NIK:</span>
                        <span class="text-gray-800">{{ $report->reporter->nik }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Nama:</span>
                        <span class="text-gray-800">{{ $report->reporter->name }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Telepon:</span>
                        <span class="text-gray-800">{{ $report->reporter->phone }}</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Usia:</span>
                        <span class="text-gray-800">{{ $report->reporter->age }} tahun</span>
                    </div>
                    <div class="flex justify-between flex-col md:flex-row">
                        <span class="font-medium">Jenis Kelamin:</span>
                        <span class="text-gray-800">{{ $report->reporter->gender }}</span>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-medium">Hubungan dengan korban:</h3>
                        <span class="text-gray-800">{{ $report->reporter->relationship_between }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="font-medium">Alamat:</span>
                        <span class="text-gray-800">{{ $report->reporter->address }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Histori Status Laporan -->
        <div>
            <h2 class="mt-6 text-xl font-semibold text-black">Histori Status
                Laporan</h2>
            <div class="space-y-4">
                <!-- List Status -->
                @foreach ($report->statuses as $status)
                    <div
                        class="bg-white rounded-lg p-5 shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out transform hover:-translate-y-1">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-2">
                                <span class="text-green-600">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m-7 8h12a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </span>
                                <span class="font-medium">Status: {{ $status->status }}</span>
                            </div>
                            <span class="text-sm text-gray-500">{{ $status->updated_at->diffForHumans() }}</span>
                        </div>
                        <div class="mt-3">
                            <p class="">{{ $status->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tombol Batal & Tambah -->
        <div class="mt-6 flex flex-wrap gap-2 justify-center md:justify-end">
            <a href="{{ route('dashboard.reports.index', ['status' => 'diterima']) }}"
                class="bg-gray-700 text-white py-2 px-6 rounded-md hover:bg-gray-800 w-full md:w-auto text-center">
                Kembali
            </a>
            <form action="#" method="POST" class="w-full md:w-auto">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="bg-red-700 text-white py-2 px-6 rounded-md hover:bg-red-800 w-full md:w-auto text-center"
                    onclick="return confirm('Yakin ingin menghapus laporan?');">
                    Hapus
                </button>
            </form>
            @can('verification-report', $report)
                <form
                    action="{{ route('dashboard.reports.received.update', ['status' => 'diterima', 'ticket_number' => $report->ticket_number]) }}"
                    method="POST" class="w-full md:w-auto">
                    @csrf
                    <button type="submit"
                        class="bg-green-700 text-white py-2 px-6 rounded-md hover:bg-green-800 w-full md:w-auto text-center">
                        Verifikasi
                    </button>
                </form>
            @endcan
        </div>
    </section>

</x-app-layout>
