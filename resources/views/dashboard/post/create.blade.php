<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Tambah Berita -->
    <section class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
        <div class="border-b mb-6">
            <h2 class="text-xl font-semibold mb-2 text-black">Tambah Berita</h2>
        </div>

        <!-- Form Input Berita -->
        <form action="{{ route('dashboard.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <!-- Input Judul -->
                <div>
                    <label for="title" class="text-sm font-medium text-gray-800">Judul</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}"
                        class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring"
                        placeholder="Masukkan judul berita" />
                    @error('title')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pilihan Status -->
                <div>
                    <label for="status" class="text-sm font-medium text-gray-800">Status</label>
                    <select id="status" name="status"
                        class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                        <option value="" disabled selected>Pilih</option>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Terbit</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Arsip</option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Upload dan Preview Gambar -->
                <div x-data="{ imagePreview: null }">
                    <label for="image" class="text-sm font-medium text-gray-800">Gambar</label>
                    <input id="image" type="file" name="image"
                        class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring file:mr-4 file:py-2.5 file:px-4 file:font-medium file:border-0 file:text-sm file:bg-[#141652] file:text-white hover:file:bg-blue-800 transition ease-in-out duration-200"
                        @change="imagePreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : null">

                    <!-- Tampilkan Preview Gambar -->
                    <div class="mt-4" x-show="imagePreview" style="display: none;">
                        <div class="overflow-auto max-w-full h-64 rounded-md border border-gray-300">
                            <img :src="imagePreview" class="w-full h-auto" alt="Image Preview">
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Isi Berita -->
                <div>
                    <label for="body" class="text-sm font-medium text-gray-800">Isi Berita</label>
                    <input id="body" value="{{ old('body') }}" type="hidden" name="body">
                    <trix-editor input="body"></trix-editor>
                    @error('body')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Batal & Simpan -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('dashboard.posts.index') }}"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit"
                        class="bg-[#141652] hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition duration-200">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </section>

</x-app-layout>
