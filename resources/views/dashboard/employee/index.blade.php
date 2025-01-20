<x-app-layout>

    <!-- Judul Halaman -->
    <x-title :title=$title></x-title>

    <!-- Bagian Karyawan -->
    <section>
        <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
            <!-- Tambah dan Cari -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-4 space-y-2 md:space-y-0">
                <!-- Tambah Karyawan -->
                @can('create-employee')
                    <a href="{{ route('dashboard.employees.create') }}"
                        class="flex items-center bg-[#141652] hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition duration-200 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                        </svg>
                        Tambah Karyawan
                    </a>
                @else
                    <button onclick="alert('Akun anda tidak diizinkan untuk menambah data');"
                        class="flex items-center bg-[#141652] hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition duration-200 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                        </svg>
                        Tambah Karyawan
                    </button>
                @endcan

                <form action="{{ route('dashboard.employees.index') }}" method="GET">
                    <div x-data="{ showModal: false }" class="relative flex items-center">
                        <!-- Tombol Filter -->
                        <button type="button" @click="showModal = true"
                            class="bg-[#141652] hover:bg-blue-800 text-white border border-[#141652] rounded-l-full px-4 py-2 transition duration-200">
                            Filter
                        </button>
                        <!-- Filter Pencarian -->
                        <input type="text" name="search" value="{{ $search }}"
                            class="w-full sm:w-auto px-4 py-2 border-y focus:outline-none focus:bg-blue-50"
                            placeholder="Cari karyawan..." autocomplete="off" autofocus />
                        <!-- Tombol Submit -->
                        <button type="submit"
                            class="bg-[#141652] hover:bg-blue-800 text-white border border-[#141652] rounded-r-full px-4 py-2 transition duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </button>
                        <!-- Modal -->
                        <div x-cloak x-show="showModal"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-cloak>
                            <div class="bg-white rounded-lg shadow-lg p-6 w-72 md:w-96 ">
                                <h2 class="text-lg font-semibold mb-3">Filter</h2>
                                <!-- Select Status -->
                                <div class="mb-4">
                                    <label for="status" class="block text-sm font-medium">Status</label>
                                    <select name="status" id="status"
                                        class="w-full p-1 rounded-md border border-[#141652] focus:ring-none focus:outline-none">
                                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Semua</option>
                                        <option value="1" {{ $status == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ $status == '0' ? 'selected' : '' }}>Non Aktif</option>
                                    </select>
                                </div>
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
                <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 rounded relative mb-3"
                    role="alert">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabel Karyawan -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-gray-100 rounded-xl shadow-md">
                    <thead class="bg-[#141652] text-white">
                        <tr>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">#</th>
                            <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Nama</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">NIP</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Jenis Kelamin</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Jabatan</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Berita</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Laporan</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Status</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Dibuat</th>
                            <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($employees as $employee)
                            <tr class="border-t hover:bg-blue-100 transition duration-200">
                                <td class="py-3 px-2 text-center">{{ $loop->iteration }}</td>
                                <td class="py-3 px-2 whitespace-nowrap">{{ Str::limit($employee->name, 20) }}</td>
                                <td class="py-3 px-2">{{ $employee->nip }}</td>
                                <td class="py-3 px-2 text-center">{{ substr($employee->gender, 0, 1) }}</td>
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    {{ substr($employee->position, 0, 20) }}</td>
                                <td class="py-3 px-2 text-center">{{ $employee->posts->count() }}</td>
                                <td class="py-3 px-2 text-center">{{ $employee->reports->count() }}</td>
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    <span
                                        class="inline-block px-3 py-1 rounded-full text-xs shadow-md {{ $employee->status ? 'bg-green-500 hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600' }} text-white transition duration-200">
                                        {{ $employee->status ? 'Aktif' : 'Non Aktif' }}
                                    </span>
                                </td>
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    {{ $employee->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-2 text-center whitespace-nowrap">
                                    <div class="flex justify-center items-center space-x-1">
                                        @can('show-employee', $employee)
                                            <a href="{{ route('dashboard.employees.show', $employee->nip) }}"
                                                class="bg-blue-600 hover:bg-blue-500 text-white p-1 rounded-md text-xs shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </a>
                                        @else
                                            <button onclick="alert('Tidak dapat melihat karyawan lain');"
                                                class="bg-blue-600 hover:bg-blue-500 opacity-50 text-white p-1 rounded-md text-xs shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </button>
                                        @endcan
                                        @can('update_delete-employee', $employee)
                                            <a href="{{ route('dashboard.employees.edit', $employee->nip) }}"
                                                class="bg-yellow-600 hover:bg-yellow-500 text-white p-1 rounded-md text-xs shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </a>
                                            <form action="{{ route('dashboard.employees.destroy', $employee->nip) }}"
                                                method="POST" onsubmit="return confirm('Yakin ingin menghapus?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="flex items-center bg-red-600 hover:bg-red-500 text-white p-1 rounded-md text-xs shadow-md">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @else
                                            <button onclick="alert('Akun anda tidak diizinkan untuk mengubah data');"
                                                class="bg-yellow-600 hover:bg-yellow-500 opacity-50 text-white p-1 rounded-md text-xs shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                            <button onclick="alert('Akun anda tidak diizinkan untuk menghapus data');"
                                                class="bg-red-600 hover:bg-red-500 opacity-50 text-white p-1 rounded-md text-xs shadow-md">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                    class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-2">
                                    <h1 class="text-md font-semibold text-red-500">Maaf, karyawan tidak ada</h1>
                                    <p class="text-sm text-gray-500">Silakan cek kembali nanti!</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $employees->links() }}
            </div>
        </div>
    </section>

</x-app-layout>
