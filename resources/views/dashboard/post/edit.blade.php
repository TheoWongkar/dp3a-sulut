<x-app-layout>

    <!-- Bagian Title -->
    <x-title :title=$title></x-title>

    <!-- Bagian Ubah Berita -->
    <section>
        <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center space-x-4 border-b pb-4 mb-6">
                <h1 class="text-2xl font-bold">Ubah Berita</h1>
            </div>
            <!-- Form Ubah Berita -->
            <form action="{{ route('dashboard.posts.update', $post->slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-6">
                    <!-- Judul -->
                    <div>
                        <label for="title" class="block text-sm font-medium">Judul</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}"
                            class="mt-1 px-4 py-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]"
                            placeholder="Masukkan judul berita" required />
                        @error('title')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium">Status</label>
                        <select id="status" name="status"
                            class="mt-1 px-4 py-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                            <option value="1" {{ old('status', $post->status) == 1 ? 'selected' : '' }}>Terbit
                            </option>
                            <option value="0" {{ old('status', $post->status) == 0 ? 'selected' : '' }}>Arsip
                            </option>
                        </select>
                        @error('status')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
                        @enderror
                    </div>
                    <!-- Gambar -->
                    <div x-data="{ imagePreview: null, oldImage: '{{ asset('storage/' . $post->image) }}' }">
                        <label for="image" class="block text-sm font-medium">Gambar</label>
                        <input id="image" type="file" name="image"
                            class="mt-1 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652] file:mr-4 file:py-2.5 file:px-4 file:font-medium file:border-0 file:text-sm file:bg-[#141652] file:text-white hover:file:bg-blue-800 transition ease-in-out duration-200"
                            @change="if ($event.target.files.length) { 
                                    const file = $event.target.files[0]; 
                                    const reader = new FileReader(); 
                                    reader.onload = (e) => { imagePreview = e.target.result; }; 
                                    reader.readAsDataURL(file); 
                                } else { imagePreview = null; }">
                        <!-- Preview Gambar -->
                        <div class="mt-4" x-show="imagePreview || oldImage" x-transition>
                            <div class="overflow-auto max-w-full h-64 rounded-md shadow-md border border-gray-300">
                                <img :src="imagePreview || oldImage" class="w-full h-auto" alt="Image Preview">
                            </div>
                        </div>
                        @error('image')
                            <p class="text-red-500 text-md mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Isi Berita -->
                    <div>
                        <label for="body" class="block text-sm font-medium">Isi Berita</label>
                        <input id="body" value="{{ old('body', $post->body) }}" type="hidden" name="body">
                        <trix-editor input="body"></trix-editor>
                        @error('body')
                            <span class="text-red-500 text-xs">{{ $message }}</span>
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
        </div>
    </section>

</x-app-layout>
