<x-app-layout>

    <!-- Bagian Title -->
    @section('title')
        @isset($title)
            | {{ $title }}
        @endisset
    @endsection

    <div class="py-5 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <div class="flex items-center space-x-4 border-b pb-4 mb-6">
                    <h1 class="text-2xl font-bold">Informasi Laporan</h1>
                </div>
                <!-- Informasi Laporan -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-7">
                    <div>
                        <div class="mt-4 space-y-2">
                            <div class="flex justify-between">
                                <h3 class="font-semibold">Nomor Tiket:</h3>
                                <span class="text-gray-900 font-semibold">{{ $report->ticket_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <h3 class="font-semibold">Tanggal Kejadian:</h3>
                                <span
                                    class="text-gray-900">{{ \Carbon\Carbon::parse($report->date)->locale('id')->isoFormat('D MMMM YYYY') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <h3 class="font-semibold">Jenis Kekerasan:</h3>
                                <span class="text-gray-900">{{ $report->violence_category }}</span>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold">Tempat Kejadian:</h3>
                                <span class="text-gray-900">{{ $report->scene }}</span>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold">Deskripsi Kejadian:</h3>
                                <span class="text-gray-900">{{ $report->description }}</span>
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
                <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-16">
                    <!-- Informasi Korban -->
                    <div>
                        <h2 class="text-xl font-semibold">Informasi Korban</h2>
                        <div class="mt-4 space-y-1">
                            <div class="flex justify-between">
                                <span class="font-semibold">Nama Korban:</span>
                                <span class="text-gray-900">{{ $report->victim->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Usia:</span>
                                <span class="text-gray-900">{{ $report->victim->age }} tahun</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Jenis Kelamin:</span>
                                <span class="text-gray-900">{{ $report->victim->gender }}</span>
                            </div>
                            <div class="flex flex-col">
                                <h3 class="font-semibold">Deskripsi Kejadian:</h3>
                                <span class="text-gray-900">{{ $report->victim->description }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pelaku -->
                    <div>
                        <h2 class="text-xl font-semibold">Informasi Pelaku</h2>
                        <div class="mt-4 space-y-1">
                            <div class="flex justify-between">
                                <span class="font-semibold">Nama Pelaku:</span>
                                <span class="text-gray-900">{{ $report->perpetrator->name ?? '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Usia:</span>
                                <span class="text-gray-900">{{ $report->perpetrator->age ?? '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Hubungan Dengan Korban:</span>
                                <span
                                    class="text-gray-900">{{ $report->perpetrator->relationship_between ?? '' }}</span>
                            </div>
                            <div class="flex justify-start">
                                <span class="font-semibold">Deskripsi Pelaku:</span>
                            </div>
                            <p class="inline text-gray-900 text-justify">{{ $report->perpetrator->description ?? '' }}
                            </p>
                        </div>
                    </div>

                    <!-- Informasi Pelapor -->
                    <div>
                        <h2 class="text-xl font-semibold">Informasi Pelapor</h2>
                        <div class="mt-4 space-y-1">
                            <div class="flex justify-between">
                                <span class="font-semibold">Whatsapp:</span>
                                <span class="text-gray-900">{{ $report->reporter->whatsapp ?? '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Telegram:</span>
                                <span class="text-gray-900">{{ $report->reporter->telegram ?? '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Instagram:</span>
                                <span class="text-gray-900">{{ $report->reporter->instagram ?? '' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="font-semibold">Email:</span>
                                <span class="text-gray-900">{{ $report->reporter->email ?? '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Histori Status Laporan -->
                <div>
                    <h2 class="text-xl font-semibold mt-6">Histori Status
                        Laporan</h2>
                    <div class="space-y-4">
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
                                        <span class="font-semibold">Status: {{ $status->status }}</span>
                                    </div>
                                    <span
                                        class="text-sm text-gray-500">{{ $status->updated_at->diffForHumans() }}</span>
                                </div>
                                <div class="mt-3">
                                    <p class="">{{ $status->description }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <!-- Form Tambah Histori Status Laporan -->
                <div class="mt-5 bg-white p-5 rounded-lg shadow-lg">
                    <form action="{{ route('dashboard.reports.store', $report->ticket_number) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Pilihan Status -->
                            <div>
                                <label for="status" class="block font-semibold">Tambah Status</label>
                                <select name="status" id="status"
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                    <option value="Diproses">Diproses</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Dibatalkan">Dibatalkan</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500">Ubah status sesuai dengan kenyataan.</p>
                            </div>
                            <!-- Deskripsi Status -->
                            <div>
                                <label for="description" class="block text-gray-700 font-semibold">Deskripsi</label>
                                <textarea name="description" id="description" rows="4"
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]"></textarea>
                            </div>
                        </div>
                        <!-- Tombol Batal & Tambah -->
                        <div class="mt-2 flex justify-end space-x-2">
                            <a href="{{ route('dashboard.reports.index') }}"
                                class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition duration-200">
                                Kembali
                            </a>
                            <button type="submit"
                                class="bg-[#141652] hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition duration-200">
                                Tambah
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
