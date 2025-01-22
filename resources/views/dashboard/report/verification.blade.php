<x-app-layout>

    <!-- Judul Halaman -->
    <x-title :title=$title></x-title>

    <!-- Bagian Aksi Laporan -->
    <section>
        <div class="bg-white text-black shadow-lg rounded-lg p-8">
            <!-- Informasi Laporan -->
            <div class="flex items-center">
                <h2 class="text-xl font-semibold">Informasi Laporan</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                <div>
                    <div class="mt-4 space-y-2">
                        <div class="flex justify-between">
                            <h3 class="font-semibold">Nomor Tiket:</h3>
                            <span class="text-gray-900 font-medium">{{ $report->ticket_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <h3 class="font-medium">Tanggal Kejadian:</h3>
                            <span
                                class="text-gray-600">{{ \Carbon\Carbon::parse($report->date)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                        </div>
                        <div class="flex justify-between">
                            <h3 class="font-medium">Jenis Kekerasan:</h3>
                            <span class="text-gray-600">{{ $report->violence_category }}</span>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="font-medium leading-none">Tempat Kejadian:</h3>
                            <span class="text-gray-600">{{ $report->scene }}</span>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="font-medium leading-none">Kronologi Kejadian:</h3>
                            <span class="text-gray-600">{{ $report->chronology }}</span>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="mt-4">
                        <div class="overflow-y-auto max-w-xl max-h-60 border rounded-lg p-2">
                            <img src="{{ asset('storage/' . $report->evidence) }}" alt="Bukti Pendukung"
                                class="w-full h-auto object-contain">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Korban, Pelaku, Pelapor -->
            <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-10">
                <!-- Informasi Korban -->
                <div>
                    <h2 class="text-xl font-semibold">Informasi Korban</h2>
                    <div class="mt-4 space-y-1">
                        <div class="flex justify-between">
                            <span class="font-medium">Nama:</span>
                            <span class="text-gray-600">{{ $report->victim->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Telepon:</span>
                            <span class="text-gray-600">{{ $report->victim->phone }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Usia:</span>
                            <span class="text-gray-600">{{ $report->victim->age }} tahun</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Jenis Kelamin:</span>
                            <span class="text-gray-600">{{ $report->victim->gender }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium leading-none">Alamat:</span>
                            <span class="text-gray-600">{{ $report->victim->address }}</span>
                        </div>
                        <div class="flex flex-col">
                            <h3 class="font-medium leading-none">Deskripsi:</h3>
                            <span class="text-gray-600">{{ $report->victim->description }}</span>
                        </div>
                    </div>
                </div>

                <!-- Informasi Pelaku -->
                <div>
                    <h2 class="text-xl font-semibold">Informasi Pelaku</h2>
                    <div class="mt-4 space-y-1">
                        <div class="flex justify-between">
                            <span class="font-medium">Nama:</span>
                            <span class="text-gray-600">{{ $report->perpetrator->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Usia:</span>
                            <span class="text-gray-600">{{ $report->perpetrator->age }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Jenis Kelamin:</span>
                            <span class="text-gray-600">{{ $report->perpetrator->gender }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium leading-none">Deskripsi:</span>
                        </div>
                        <p class="inline text-gray-600 text-justify">{{ $report->perpetrator->description }}
                        </p>
                    </div>
                </div>

                <!-- Informasi Pelapor -->
                <div>
                    <h2 class="text-xl font-semibold">Informasi Pelapor</h2>
                    <div class="mt-4 space-y-1">
                        <div class="flex justify-between">
                            <span class="font-medium">Nama:</span>
                            <span class="text-gray-600">{{ $report->reporter->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="font-medium">Telepon:</span>
                            <span class="text-gray-600">{{ $report->reporter->phone }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium leading-none">Address:</span>
                            <span class="text-gray-600">{{ $report->reporter->address }}</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="font-medium leading-none">Hubungan Dengan Korban:</span>
                            <span class="text-gray-600">{{ $report->reporter->relationship_between }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Histori Status Laporan -->
            <div>
                <h2 class="text-xl font-medium mt-6">Histori Status
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
            <!-- Form Tambah Histori Status Laporan -->
            <div id="status-update" class="mt-5 bg-white p-5 rounded-lg shadow-lg">
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
                <form action="{{ route('dashboard.reports.received-verification', $report->ticket_number) }}"
                    method="POST">
                    @csrf
                    <!-- Tombol Batal & Tambah -->
                    <div class="mt-2 flex justify-end space-x-2">
                        <a href="{{ route('dashboard.reports.received') }}"
                            class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition duration-200 uppercase">
                            Kembali
                        </a>
                        <button type="submit"
                            class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg transition duration-200 uppercase">
                            VERIFIKASI
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

</x-app-layout>
