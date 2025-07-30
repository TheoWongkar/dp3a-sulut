<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Data Kategori Berita</x-slot>

    {{-- Bagian Kategori Berita --}}
    <section class="space-y-2">

        {{-- Header --}}
        <div class="bg-gray-50 rounded-lg border border-gray-300 shadow">
            <div class="p-2 space-y-2">
                <div class="flex flex-col lg:flex-row items-center justify-between gap-4">
                    @can('create', App\Models\PostCategory::class)
                        <div x-data="{ createModal: false }">
                            {{-- Tombol Tambah --}}
                            <x-buttons.primary-button @click="createModal = true"
                                class="w-full lg:w-auto text-center bg-green-600 hover:bg-green-700">
                                Tambah
                            </x-buttons.primary-button>

                            {{-- Modal --}}
                            <div x-show="createModal" x-cloak
                                class="fixed inset-0 flex items-center justify-center bg-black/50 z-10">
                                <div class="w-full max-w-md bg-white rounded-lg shadow p-4">
                                    <h2 class="mb-5 font-semibold text-gray-700">Tambah Kategori</h2>

                                    <form action="{{ route('dashboard.post-category.store') }}" method="POST">
                                        @csrf

                                        <div class="grid gap-4">
                                            <x-forms.input name="name" label="Nama"></x-forms.input>
                                            <x-forms.textarea name="description" label="Deskripsi"></x-forms.textarea>
                                        </div>
                                        <div class="flex justify-end gap-2">
                                            <x-buttons.primary-button type="button" @click="createModal = false"
                                                class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                                            <x-buttons.primary-button type="submit"
                                                class="bg-green-600 hover:bg-green-700">Simpan</x-buttons.primary-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <x-buttons.primary-button type="button"
                            onclick="alert('Tindakan ini hanya bisa dilakukan oleh Admin.')"
                            class="bg-gray-600 hover:bg-gray-700">Tambah</x-buttons.primary-button>
                    @endcan

                    {{-- Form Filter & Search --}}
                    <form method="GET" action="{{ route('dashboard.post-category.index') }}"
                        class="w-full flex justify-end gap-1" x-data="{ openFilter: '' }">

                        {{-- Filter: Kategori Berita --}}
                        <div class="relative">
                            <button type="button"
                                @click="requestAnimationFrame(() => openFilter = openFilter === 'category' ? '' : 'category')"
                                class="cursor-pointer bg-white border border-gray-300 rounded-md p-2 hover:ring-1 hover:ring-blue-500">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-tags size-5" viewBox="0 0 16 16">
                                    <path
                                        d="M3 2v4.586l7 7L14.586 9l-7-7zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586z" />
                                    <path
                                        d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1m0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3M1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1z" />
                                </svg>
                            </button>
                            <div x-show="openFilter === 'category'" @click.away="openFilter = ''" x-transition
                                class="absolute z-10 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-lg p-3">
                                <label class="block text-xs text-gray-500 mb-1">Kategori Berita</label>
                                <select name="category" x-on:change="$root.submit()"
                                    class="block w-full px-3 py-2 text-sm border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                                    <option value="" @selected(request('category') == '')>Semua</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->slug }}" @selected(request('category') == $category->slug)>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
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
                                placeholder="Cari nama atau deskripsi berita..." autocomplete="off"
                                value="{{ request('search') }}"
                                x-on:input.debounce.500ms="$root.submit()"></x-forms.input>
                        </div>
                    </form>
                </div>

                {{-- Pagination --}}
                <div class="overflow-x-auto">
                    {{ $postCategories->withQueryString()->links('pagination::custom') }}
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
                        <th class="p-2 font-normal text-center border-r border-gray-600">#</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600">Kategori</th>
                        <th class="p-2 font-normal text-left border-r border-gray-600">Deskripsi</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600">Digunakan</th>
                        <th class="p-2 font-normal text-center border-r border-gray-600">Dibuat</th>
                        <th class="p-2 font-normal text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-300">
                    @forelse($postCategories as $postCategory)
                        <tr class="hover:bg-blue-50">
                            <td class="p-2 text-center border-r border-gray-300">
                                {{ ($postCategories->currentPage() - 1) * $postCategories->perPage() + $loop->iteration }}
                            </td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">
                                {{ Str::limit($postCategory->name, 25) }}</td>
                            <td class="p-2 border-r border-gray-300 whitespace-nowrap">
                                {{ Str::limit($postCategory->description, 25) }}</td>
                            <td class="p-2 text-center border-r border-gray-300 whitespace-nowrap">
                                {{ $postCategory->posts->count() }}</td>
                            <td class="p-2 text-center border-r border-gray-300 whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($postCategory->created_at)->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-2 whitespace-nowrap">
                                <div class="flex justify-center items-center gap-2">
                                    @can('update', $postCategory)
                                        <div x-data="{ editModal: false }">
                                            {{-- Tombol Edit --}}
                                            <button @click="editModal = true"
                                                class="text-yellow-600 hover:underline text-sm cursor-pointer">Edit</button>

                                            {{-- Modal Edit --}}
                                            <div x-show="editModal" x-cloak
                                                class="fixed inset-0 flex items-center justify-center bg-black/50 z-20">
                                                <div class="w-full max-w-md bg-white rounded-lg shadow p-4">
                                                    <h2 class="mb-5 text-base font-semibold text-gray-700">Edit Kategori
                                                    </h2>

                                                    <form
                                                        action="{{ route('dashboard.post-category.update', $postCategory->slug) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="grid gap-4">
                                                            <x-forms.input name="name" label="Nama"
                                                                value="{{ $postCategory->name }}"></x-forms.input>
                                                            <x-forms.textarea name="description" label="Deskripsi">
                                                                {{ $postCategory->description }}
                                                            </x-forms.textarea>
                                                        </div>
                                                        <div class="flex justify-end gap-2">
                                                            <x-buttons.primary-button type="button"
                                                                @click="editModal = false"
                                                                class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                                                            <x-buttons.primary-button
                                                                type="submit">Simpan</x-buttons.primary-button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <button type="button"
                                            onclick="alert('Tindakan ini hanya bisa dilakukan oleh Admin.')"
                                            class="text-gray-600 hover:underline text-sm cursor-pointer">Edit</button>
                                    @endcan

                                    @can('delete', $postCategory)
                                        <form action="{{ route('dashboard.post-category.destroy', $postCategory->slug) }}"
                                            method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="text-red-600 hover:underline text-sm cursor-pointer">Hapus</button>
                                        </form>
                                    @else
                                        <button type="button"
                                            onclick="alert('Tindakan ini hanya bisa dilakukan oleh Admin.')"
                                            class="text-gray-600 hover:underline text-sm cursor-pointer">Hapus</button>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-4 text-center text-gray-500">Tidak ada data kategori berita
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</x-app-layout>
