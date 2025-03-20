<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Lihat Berita -->
    <section class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">

        <!-- Tombol Kembali ke Daftar Berita -->
        <div class="mb-3">
            <a href="{{ route('dashboard.posts.index') }}"
                class="inline-block py-2 px-6 text-white bg-gray-700 rounded-lg hover:bg-gray-800 transition">
                Kembali
            </a>
        </div>

        <!-- Gambar Berita -->
        <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}"
            alt="Gambar {{ $post->title }}" class="w-full h-96 object-cover rounded-lg mb-6">

        <!-- Isi Berita -->
        <h2 class="text-xl font-semibold">{{ $post->title }} <span
                class="bg-[#141652] text-white text-xs ml-2 px-2 py-1 rounded-full">
                {{ $post->views }}x dilihat</span></h2>
        <div class="font-medium mb-2 text-gray-600">
            <h3 class="inline">{{ $post->author->username }}</h3> &bull;
            <span>{{ $post->created_at->diffForHumans() }}</span>
        </div>

        <!-- Pembatas -->
        <div class="border-t mt-2 mb-4"></div>

        <!-- Isi Konten -->
        <p>{!! $post->content !!}</p>
    </section>

</x-app-layout>
