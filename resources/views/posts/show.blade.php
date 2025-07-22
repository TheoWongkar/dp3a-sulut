<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Detail Berita</x-slot>

    {{-- Detail Berita --}}
    <section class="relative z-10 -mt-[70vh] md:-mt-screen container mx-auto px-5 py-10">
        <div class="rounded-xl bg-gray-100 p-5">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                {{-- Konten Berita --}}
                <article class="md:col-span-2 space-y-4">
                    {{-- Judul --}}
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $post->title }}</h1>

                    <div class="flex items-center text-sm text-gray-500 gap-4 flex-wrap">
                        {{-- Kategori --}}
                        @if ($post->category)
                            <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-sm md:text-md font-medium">
                                {{ $post->category->name }}
                            </span>
                        @endif

                        {{-- Tanggal --}}
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-calendar-week-fill" viewBox="0 0 16 16">
                                <path
                                    d="M4 .5a.5.5 0 0 0-1 0V1H2a2 2 0 0 0-2 2v1h16V3a2 2 0 0 0-2-2h-1V.5a.5.5 0 0 0-1 0V1H4zM16 14V5H0v9a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2M9.5 7h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5m3 0h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5M2 10.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5" />
                            </svg>
                            {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F Y') }}
                        </span>

                        {{-- Views --}}
                        <span class="flex items-center gap-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-eye-fill" viewBox="0 0 16 16">
                                <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                                <path
                                    d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                            </svg>
                            {{ $post->views }}x dilihat
                        </span>
                    </div>

                    {{-- Gambar (jika ada) --}}
                    <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}"
                        alt="{{ $post->title }}" class="rounded-xl w-full object-cover">

                    {{-- Isi Konten --}}
                    <div class="prose max-w-none">
                        {!! $post->content !!}
                    </div>
                </article>

                {{-- Kanan --}}
                <aside class="space-y-8">
                    <div class="space-y-4">
                        {{-- Judul --}}
                        <x-shared.section-title>Berita Terbaru</x-shared.section-title>

                        {{-- Card --}}
                        <div
                            class="max-h-80 overflow-y-auto bg-white rounded-xl shadow hover:shadow-md transition duration-300 p-3">
                            @forelse ($latestPosts as $post)
                                <x-cards.post-card-aside :post="$post"></x-cards.post-card-aside>
                            @empty
                                <div class="text-sm">
                                    Berita tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Judul --}}
                        <x-shared.section-title>Berita Teratas</x-shared.section-title>

                        {{-- Card --}}
                        <div
                            class="max-h-80 overflow-y-auto bg-white rounded-xl shadow hover:shadow-md transition duration-300 p-3">
                            @forelse ($popularPosts as $post)
                                <x-cards.post-card-aside :post="$post"></x-cards.post-card-aside>
                            @empty
                                <div class="text-sm">
                                    Berita tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Judul --}}
                        <x-shared.section-title>Kategori Berita</x-shared.section-title>

                        <div class="flex flex-wrap gap-1">
                            @forelse ($categories as $category)
                                <span class="px-2 py-1 bg-blue-100 text-blue-700">{{ $category->name }}</span>
                            @empty
                                <div class="text-sm">
                                    Kategori tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

</x-guest-layout>
