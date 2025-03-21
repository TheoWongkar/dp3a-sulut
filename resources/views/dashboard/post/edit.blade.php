<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Script Tambahan -->
    <x-slot name="script">
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    </x-slot>

    <!-- Bagian Edit Berita -->
    <section class="bg-white p-6 shadow-lg rounded-lg">
        <div class="border-b mb-6">
            <h2 class="text-xl font-semibold mb-2 text-black">Ubah Berita</h2>
        </div>

        <!-- Form Edit Berita -->
        <form action="{{ route('dashboard.posts.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <!-- Input Judul -->
                <div>
                    <label for="title" class="text-sm font-medium text-black">Judul</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                        class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                        placeholder="Masukkan judul berita" />
                    @error('title')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Pilihan Status -->
                <div>
                    <label for="status" class="text-sm font-medium text-black">Status</label>
                    <select id="status" name="status"
                        class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                        <option value="" disabled>Pilih Status</option>
                        <option value="Terbit" {{ old('status', $post->status) == 'Terbit' ? 'selected' : '' }}>Terbit
                        </option>
                        <option value="Arsip" {{ old('status', $post->status) == 'Arsip' ? 'selected' : '' }}>Arsip
                        </option>
                    </select>
                    @error('status')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Upload dan Preview Gambar -->
                <div x-data="{
                    imagePreview: '{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}'
                }">
                    <label for="image" class="text-sm font-medium text-black">Gambar</label>
                    <input id="image" type="file" name="image" accept="image/jpeg, image/png"
                        class="mt-1 w-full border border-gray-200 rounded-md shadow-sm focus:outline-black file:mr-4 file:py-2 file:px-4 file:text-sm file:bg-gray-700 file:text-white hover:file:bg-gray-800"
                        @change="imagePreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : '{{ $post->image ? asset('storage/' . $post->image) : asset('images/default.png') }}'">

                    <!-- Tampilkan Preview Gambar -->
                    <div class="mt-4">
                        <div class="overflow-auto max-w-full h-64 rounded-md border border-gray-300">
                            <img :src="imagePreview" class="w-full h-auto object-cover" alt="Image Preview">
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Input Isi Berita -->
                <div>
                    <label for="content" class="text-sm font-medium text-black">Isi Berita</label>
                    <input id="content" value="{{ old('content', $post->content) }}" type="hidden" name="content">
                    <trix-editor input="content"></trix-editor>
                    @error('content')
                        <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Tombol Batal & Simpan -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('dashboard.posts.index') }}"
                        class="bg-gray-700 text-white py-2 px-6 rounded-md hover:bg-gray-800">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-700 text-white py-2 px-6 rounded-md hover:bg-green-800">
                        Simpan
                    </button>
                </div>
            </div>
        </form>
    </section>

</x-app-layout>
