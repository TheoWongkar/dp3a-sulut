<x-app-layout>

    <!-- Bagian Karyawan -->
    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <!-- Tambah dan Cari -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                    <!-- Tambah Karyawan -->
                    <a href="{{ route('dashboard.employees.create') }}"
                        class="flex items-center bg-[#141652] hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition duration-200 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                        </svg>
                        Tambah Karyawan
                    </a>

                    <!-- Cari Karyawan -->
                    <form action="{{ route('dashboard.employees.index') }}" method="GET" class="flex w-full md:w-1/3">
                        <select name="status"
                            class="bg-[#141652] text-white rounded-l-full px-4 py-2 border focus:ring-0 focus:border-blue-800">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>Status</option>
                            <option value="active" {{ $status == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ $status == 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        <input type="text" name="search" value="{{ $search }}"
                            class="px-4 py-2 w-full border-y focus:outline-none focus:bg-blue-50"
                            placeholder="Cari karyawan..." autocomplete="off" autofocus />
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

                <!-- Tabel Karyawan -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-100 rounded-xl shadow-md">
                        <thead class="bg-[#141652] text-white">
                            <tr>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm whitespace-nowrap">#
                                </th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Nama</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm whitespace-nowrap">NIP
                                </th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Jenis Kelamin</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Jabatan</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm whitespace-nowrap">
                                    Status</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Berita</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Laporan</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($employees as $employee)
                                <tr class="border-t hover:bg-blue-100 transition duration-200">
                                    <td class="py-4 px-2 text-center whitespace-nowrap">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-2">{{ $employee->name }}</td>
                                    <td class="py-4 px-2 text-center whitespace-nowrap">{{ $employee->nip }}</td>
                                    <td class="py-4 px-2 text-center">{{ $employee->gender }}</td>
                                    <td class="py-4 px-2 text-center">{{ $employee->position }}</td>
                                    <td class="py-4 px-2 text-center whitespace-nowrap">
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs shadow-md {{ $employee->status ? 'bg-green-500 hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600' }} text-white transition duration-200">
                                            {{ $employee->status ? 'Aktif' : 'Tidak Aktif' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-center">{{ $employee->posts->count() }}</td>
                                    <td class="py-4 px-2 text-center">{{ $employee->reports->count() }}</td>
                                    <td class="py-4 px-2 flex space-x-2 justify-center">
                                        <a href="{{ route('dashboard.employees.show', $employee->nip) }}"
                                            class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Lihat</a>
                                        <a href="{{ route('dashboard.employees.edit', $employee->nip) }}"
                                            class="bg-yellow-600 hover:bg-yellow-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Ubah</a>
                                        <form action="{{ route('dashboard.employees.destroy', $employee->nip) }}"
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
                                    <td colspan="9" class="text-center py-2">
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
        </div>
    </div>


</x-app-layout>
