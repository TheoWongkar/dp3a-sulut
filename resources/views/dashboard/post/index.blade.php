<x-app-layout>

    <!-- Bagian Title -->
    @section('title')
        @isset($title)
            | {{ $title }}
        @endisset
    @endsection

    <!-- Bagian Berita -->
    <div class="py-5 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-lg p-8">
                <!-- Tambah dan Cari -->
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                    <!-- Tambah Berita -->
                    <a href="{{ route('dashboard.posts.create') }}"
                        class="flex items-center bg-[#141652] hover:bg-blue-800 text-white px-4 py-2 rounded-lg transition duration-200 w-full md:w-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 18.75a6 6 0 0 0 6-6v-1.5m-6 7.5a6 6 0 0 1-6-6v-1.5m6 7.5v3.75m-3.75 0h7.5M12 15.75a3 3 0 0 1-3-3V4.5a3 3 0 1 1 6 0v8.25a3 3 0 0 1-3 3Z" />
                        </svg>
                        Tambah Berita
                    </a>

                    <!-- Cari Berita -->
                    <form action="{{ route('dashboard.posts.index') }}" method="GET" class="flex w-full md:w-1/3">
                        <select name="status"
                            class="bg-[#141652] text-white rounded-l-full px-4 py-2 border focus:ring-0 focus:border-blue-800">
                            <option value="">Status</option>
                            <option value="1" {{ old('status', $status) === '1' ? 'selected' : '' }}>Terbit
                            </option>
                            <option value="0" {{ old('status', $status) === '0' ? 'selected' : '' }}>Arsip</option>
                        </select>
                        <input type="text" name="search" value="{{ $search }}"
                            class="px-4 py-2 w-full border-y focus:outline-none focus:bg-blue-50"
                            placeholder="Cari berita..." autocomplete="off" autofocus />
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

                <!-- Tabel Berita -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-gray-100 rounded-xl shadow-md">
                        <thead class="bg-[#141652] text-white">
                            <tr>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">#</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Judul</th>
                                <th class="text-left py-3 px-2 uppercase font-semibold text-sm">Jurnalis</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Status</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Dibuat</th>
                                <th class="text-center py-3 px-2 uppercase font-semibold text-sm">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($posts as $post)
                                <tr class="border-t hover:bg-blue-100 transition duration-200">
                                    <td class="py-4 px-2 text-center">{{ $loop->iteration }}</td>
                                    <td class="py-4 px-2">{{ substr($post->title, 0, 20) }}</td>
                                    <td class="py-4 px-2">{{ $post->employee->user->name }}</td>
                                    <td class="py-4 px-2 text-center">
                                        <span
                                            class="inline-block px-3 py-1 rounded-full text-xs shadow-md {{ $post->status ? 'bg-green-500 hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600' }} text-white transition duration-200">
                                            {{ $post->status ? 'Terbit' : 'Diarsipkan' }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-2 text-center">{{ $post->created_at->format('d M Y') }}</td>
                                    <td class="py-4 px-2 flex space-x-2 justify-center">
                                        <a href="{{ route('dashboard.posts.show', $post->slug) }}"
                                            class="bg-blue-600 hover:bg-blue-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Lihat</a>
                                        <a href="{{ route('dashboard.posts.edit', $post->slug) }}"
                                            class="bg-yellow-600 hover:bg-yellow-500 text-white px-3 py-1 rounded-full text-xs shadow-md">Ubah</a>
                                        <form action="{{ route('dashboard.posts.destroy', $post->slug) }}"
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
                                    <td colspan="6" class="text-center py-2">
                                        <h1 class="text-md font-semibold text-red-500">Maaf, postingan tidak ada</h1>
                                        <p class="text-sm text-gray-500">Silakan cek kembali nanti!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
