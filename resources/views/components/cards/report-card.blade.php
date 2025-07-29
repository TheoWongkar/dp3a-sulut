@props(['report' => null])

<div class="p-4 bg-white rounded-lg border border-gray-300 shadow">
    <div class="space-y-10">
        {{-- Informasi Kasus --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
            <div>
                <h2 class="mb-5 text-lg font-semibold text-gray-700">Informasi Kasus</h2>

                <div class="space-y-2">
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Nomor Tiket:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->ticket_number }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Jenis Kekerasan:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->violence_category }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Tanggal Kejadian:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ \Carbon\Carbon::parse($report->incident_date)->translatedFormat('d F Y') }}
                        </p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Kabupaten/Kota:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->regency }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Kecamatan:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->district }}</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Tempat Kejadian:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->scene }}</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Kronologi:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->chronology }}
                        </p>
                    </div>
                </div>
            </div>

            @php
                $file = $report->evidence ? asset('storage/' . $report->evidence) : asset('img/placeholder-image.webp');
                $ext = pathinfo($file, PATHINFO_EXTENSION);
            @endphp

            <div class="xl:mt-10 w-full max-h-[200px] overflow-y-auto border rounded-lg bg-gray-50">
                <a href="{{ $file }}" target="_blank" class="relative block w-full">
                    @if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp']))
                        <img src="{{ $file }}" alt="Bukti Pendukung" class="w-full h-auto object-cover">
                    @elseif(in_array(strtolower($ext), ['mp4', 'webm']))
                        <video src="{{ $file }}" class="w-full h-auto"></video>
                    @elseif(strtolower($ext) === 'pdf')
                        <iframe src="{{ $file }}" class="w-full h-[200px]" frameborder="0"></iframe>
                    @else
                        <p class="p-4 text-center text-sm text-gray-500">Tidak dapat menampilkan file</p>
                    @endif

                    {{-- Overlay Teks --}}
                    <div
                        class="absolute inset-0 flex items-center justify-center bg-black/40 opacity-0 hover:opacity-100 transition">
                        <span class="text-white text-sm font-medium">Klik untuk membuka</span>
                    </div>
                </a>
            </div>
        </div>

        {{-- Data Pelapor --}}
        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <div>
                <h2 class="mb-3 font-semibold text-gray-700">Data Pelapor</h2>

                <div class="space-y-2">
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Nama Pelapor:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->reporter->name }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">NIK:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->reporter->nik }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">No. Telepon:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->reporter->phone }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Jenis Kelamin:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->reporter->gender }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Usia:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->reporter->age }}</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Hubungan dengan Korban:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->reporter->relationship_between }}</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Alamat:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->reporter->address }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Data Korban --}}
            <div>
                <h2 class="mb-3 font-semibold text-gray-700">Data Korban</h2>

                <div class="space-y-2">
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Nama Korban:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->victim->name }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">NIK:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->victim->nik }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">No. Telepon:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->victim->phone }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Jenis Kelamin:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->victim->gender }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Usia:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->victim->age }}</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Alamat:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->victim->address }}
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Keterangan Tambahan:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->victim->description }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Data Terduga --}}
            <div>
                <h2 class="mb-3 font-semibold text-gray-700">Data Terduga</h2>

                <div class="space-y-2">
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Nama Terduga:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->suspect->name }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">NIK:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->suspect->nik }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">No. Telepon:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->suspect->phone }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Jenis Kelamin:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->suspect->gender }}</p>
                    </div>
                    <div class="md:flex justify-between">
                        <h3 class="text-sm font-medium text-gray-600">Usia:</h3>
                        <p class="text-sm font-semibold text-gray-900">{{ $report->suspect->age }}</p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Alamat:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->suspect->address }}
                        </p>
                    </div>
                    <div class="flex flex-col">
                        <h3 class="text-sm font-medium text-gray-600">Keterangan Tambahan:</h3>
                        <p class="text-sm font-semibold text-gray-900">
                            {{ $report->suspect->description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
