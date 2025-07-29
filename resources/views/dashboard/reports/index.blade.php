<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Data Laporan</x-slot>

    {{-- Bagian Laporan --}}
    <section class="space-y-2">

        {{-- Header --}}
        <div class="bg-gray-50 rounded-lg border border-gray-300 shadow">
            <div class="p-2 space-y-2">
                <div class="flex flex-col lg:flex-row items-center justify-end gap-4">
                    {{-- Form Filter & Search --}}
                    <form method="GET" action="{{ route('dashboard.report.index', $status) }}"
                        class="w-full flex justify-end gap-1" x-data="{ openFilter: '' }">

                        {{-- Filter: Kategori Kekerasan --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'violence_category' ? '' : 'violence_category')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-tags size-5" viewBox="0 0 16 16">
                                    <path
                                        d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z" />
                                    <path
                                        d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'violence_category'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                                <label class="block text-xs text-gray-500 mb-1">Kategori Kekerasan</label>
                                <select name="violence_category" x-on:change="$root.submit()"
                                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" @selected(request('violence_category') == '')>Semua</option>
                                    @foreach (['Fisik', 'Psikis', 'Seksual', 'Penelantaran', 'Eksploitasi', 'Lainnya'] as $violenceCategory)
                                        <option value="{{ $violenceCategory }}" @selected(request('violence_category') == $violenceCategory)>
                                            {{ $violenceCategory }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Filter: Jenis Kelamin --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'gender' ? '' : 'gender')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-gender-ambiguous size-5" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M11.5 1a.5.5 0 0 1 0-1h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-3.45 3.45A4 4 0 0 1 8.5 10.97V13H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V14H6a.5.5 0 0 1 0-1h1.5v-2.03a4 4 0 1 1 3.471-6.648L14.293 1zm-.997 4.346a3 3 0 1 0-5.006 3.309 3 3 0 0 0 5.006-3.31z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'gender'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3 space-y-5">
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Jenis Kelamin Korban</label>
                                    <select name="victim_gender" x-on:change="$root.submit()"
                                        class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                        <option value="" @selected(request('victim_gender') === '')>Semua</option>
                                        <option value="Laki-laki" @selected(request('victim_gender') === 'Laki-laki')>Laki-laki</option>
                                        <option value="Perempuan" @selected(request('victim_gender') === 'Perempuan')>Perempuan</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Jenis Kelamin Terduga</label>
                                    <select name="suspect_gender" x-on:change="$root.submit()"
                                        class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                        <option value="" @selected(request('suspect_gender') === '')>Semua</option>
                                        <option value="Laki-laki" @selected(request('suspect_gender') === 'Laki-laki')>Laki-laki</option>
                                        <option value="Perempuan" @selected(request('suspect_gender') === 'Perempuan')>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        {{-- Filter: Tanggal Mulai --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'start_date' ? '' : 'start_date')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-calendar-check size-5" viewBox="0 0 16 16">
                                    <path
                                        d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'start_date'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                                <label class="block text-xs text-gray-500 mb-1">Tanggal Mulai</label>
                                <input type="date" name="start_date" value="{{ request('start_date') }}"
                                    x-on:input.debounce.500ms="$root.submit()"
                                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>

                        {{-- Filter: Tanggal Selesai --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'end_date' ? '' : 'end_date')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    class="bi bi-calendar-x size-5" viewBox="0 0 16 16">
                                    <path
                                        d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708" />
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'end_date'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                                <label class="block text-xs text-gray-500 mb-1">Tanggal Selesai</label>
                                <input type="date" name="end_date" value="{{ request('end_date') }}"
                                    x-on:input.debounce.500ms="$root.submit()"
                                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500" />
                            </div>
                        </div>

                        {{-- Input Search --}}
                        <div class="w-full lg:w-80">
                            <x-forms.input type="text" name="search"
                                placeholder="Cari nomor tiket atau kabupaten/kota atau kecamatan..." autocomplete="off"
                                value="{{ request('search') }}"
                                x-on:input.debounce.500ms="$root.submit()"></x-forms.input>
                        </div>
                    </form>
                </div>

                {{-- Pagination --}}
                <div class="overflow-x-auto">
                    {{ $reports->withQueryString()->links('pagination::custom') }}
                </div>
            </div>
        </div>

        {{-- Flash Message --}}
        <x-alerts.flash-message />

        {{-- Table --}}
        <div class="bg-white rounded-lg border border-gray-300 shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-[#141652] text-gray-50">
                    <tr>
                        <th class="p-2 font-normal text-center border-r border-gray-600" rowspan="2">#</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600" rowspan="2">Nomor Tiket</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600" rowspan="2">Jenis Kekerasan
                        </th>
                        <th class="p-2 font-normal text-left border-r border-gray-600" rowspan="2">Kabupaten/Kota
                        </th>
                        <th class="p-2 font-normal text-left border-r border-gray-600" rowspan="2">Kecamatan
                        </th>
                        <th class="p-2 font-normal text-center border-r border-gray-600" colspan="2">Jenis Kelamin
                        </th>
                        <th class="p-2 font-normal text-center border-r border-gray-600" rowspan="2">Status</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600" rowspan="2">Dibuat</th>
                        <th class="p-2 font-normal text-center" rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <th class="p-2 font-normal text-center border-r border-gray-600">Korban</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600">Terduga</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @forelse($reports as $report)
                        <tr class="hover:bg-blue-50">
                            <td class="p-2 text-center border-r border-gray-300">
                                {{ ($reports->currentPage() - 1) * $reports->perPage() + $loop->iteration }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">
                                {{ $report->ticket_number }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">
                                {{ $report->violence_category }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">
                                {{ $report->regency }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">
                                {{ $report->district }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap text-center">
                                {{ $report->victim->gender }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap text-center">
                                {{ $report->suspect->gender }}</td>
                            <td class="p-2 text-center border-r border-gray-300">
                                @php
                                    $reportStatus = $report->latestStatus->status;
                                    $colors = [
                                        'Diterima' => 'bg-blue-200 text-blue-800 border border-blue-400',
                                        'Menunggu Verifikasi' =>
                                            'bg-yellow-200 text-yellow-800 border border-yellow-400',
                                        'Diproses' => 'bg-amber-200 text-amber-800 border border-amber-400',
                                        'Selesai' => 'bg-green-200 text-green-800 border border-green-400',
                                        'Dibatalkan' => 'bg-red-200 text-red-800 border border-red-400',
                                    ];
                                @endphp
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-medium whitespace-nowrap {{ $colors[$reportStatus] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $reportStatus }}
                                </span>
                            </td>
                            <td class="p-2 text-center border-r border-gray-300 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($report->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="flex justify-center items-center ">
                                    @if ($reportStatus == 'Diterima')
                                        <a href="{{ route('dashboard.report.edit', ['diterima', $report->ticket_number]) }}"
                                            class="text-blue-600 hover:underline text-sm">Lihat</a>
                                    @elseif($reportStatus == 'Menunggu Verifikasi')
                                        <a href="{{ route('dashboard.report.edit', ['menunggu-verifikasi', $report->ticket_number]) }}"
                                            class="text-blue-600 hover:underline text-sm">Lihat</a>
                                    @elseif($reportStatus == 'Diproses')
                                        <a href="{{ route('dashboard.report.edit', ['diproses', $report->ticket_number]) }}"
                                            class="text-blue-600 hover:underline text-sm">Lihat</a>
                                    @elseif($reportStatus == 'Selesai')
                                        <a href="{{ route('dashboard.report.edit', ['selesai', $report->ticket_number]) }}"
                                            class="text-blue-600 hover:underline text-sm">Lihat</a>
                                    @elseif($reportStatus == 'Dibatalkan')
                                        <a href="{{ route('dashboard.report.edit', ['dibatalkan', $report->ticket_number]) }}"
                                            class="text-blue-600 hover:underline text-sm">Lihat</a>
                                    @endif
                                    <form
                                        action="{{ route('dashboard.report.destroy', [$status, $report->ticket_number]) }}"
                                        method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            class="ml-2 text-red-600 hover:underline text-sm cursor-pointer">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="p-4 text-center text-gray-500">Tidak ada data laporan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</x-app-layout>
