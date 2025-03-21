<x-guest-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Lihat Berita -->
    <section class="container mx-auto px-4 py-10 mt-15">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Detail Berita -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white rounded-lg shadow-lg border border-gray-200 p-6">

                    <!-- Kembali -->
                    <div class="mb-3">
                        <a href="{{ route('posts.index') }}"
                            class="inline-block px-6 py-2 text-white bg-gray-700 rounded-lg hover:bg-gray-800 transition">
                            Kembali
                        </a>
                    </div>

                    <!-- Gambar dan Views -->
                    <div class="relative">
                        <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}"
                            alt="Gambar {{ $post->title }}" class="w-full h-96 object-cover rounded-lg mb-6">

                        <span class="absolute top-4 right-4 bg-[#141652] text-white text-xs px-2 py-1 rounded">
                            {{ $post->views }}x dilihat
                        </span>
                    </div>

                    <!-- Konten -->
                    <h2 class="text-xl font-semibold">{{ $post->title }}</h2>
                    <div class="font-medium mb-2 text-gray-600">
                        <h3 class="inline">{{ $post->author->username }}</h3> &bull;
                        <span>{{ $post->created_at->diffForHumans() }}</span>
                    </div>
                    <div class="border-t mt-2 mb-4"></div>
                    <p>{!! $post->content !!}</p>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <x-new-posts></x-new-posts>
        </div>
    </section>

</x-guest-layout>
