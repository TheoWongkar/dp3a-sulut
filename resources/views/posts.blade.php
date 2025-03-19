<x-guest-layout>
    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Berita -->
    <section class="container mx-auto px-4 py-10 mt-15">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Semua Berita -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white rounded-lg border border-gray-200 shadow-lg">
                    @forelse ($posts as $post)
                        <!-- Pembatas -->
                        <div class="p-6 flex flex-col md:flex-row justify-between items-start gap-4">
                            <div class="w-full md:w-auto">
                                <h2 class="text-xl font-semibold truncate">{{ $post->title }}</h2>
                                <div class="font-medium mb-2 text-gray-600">
                                    <h3 class="inline">{{ $post->author->username }}</h3> &bull;
                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="line-clamp-2 break-words">{{ strip_tags($post->content) }}</p>
                                <a href="{{ route('posts.show', $post->slug) }}"
                                    class="text-blue-700 hover:text-blue-800">
                                    Selengkapnya...
                                </a>
                            </div>
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}"
                                alt="Gambar {{ $post->title }}"
                                class="hidden md:block w-24 h-24 object-cover rounded-lg border border-gray-300">
                        </div>
                    @empty
                        <div class="p-6 text-center">
                            <h2 class="text-xl font-bold">Belum ada berita.</h2>
                        </div>
                    @endforelse
                    <div class="p-6">
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <x-new-posts></x-new-posts>
        </div>
    </section>

    <!-- Bagian Berita Populer -->
    <section class="container mx-auto px-4 py-10">
        <h1 class="text-xl text-center font-bold mb-4">Berita Populer</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @forelse ($popularPosts as $post)
                <a href="{{ route('posts.show', $post->slug) }}"
                    class="bg-white border border-gray-200 hover:bg-gray-100 rounded-lg shadow-md overflow-hidden">
                    <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}"
                        alt="Gambar {{ $post->title }}" class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="font-semibold truncate">{{ $post->title }}</h2>
                        <p class="text-sm line-clamp-3 text-justify">{{ strip_tags($post->content) }}</p>
                    </div>
                </a>
            @empty
                <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 text-center">
                    <h2 class="text-xl font-semibold">Belum ada berita.</h2>
                </div>
            @endforelse
        </div>
    </section>
</x-guest-layout>
