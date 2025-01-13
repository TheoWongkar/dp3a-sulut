<x-guest-layout>

    <!-- Bagian Berita -->
    <section class="container mx-auto px-4 pt-24 pb-10 sm:px-6 lg:px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Semua Berita -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white rounded-lg shadow-lg border-2 overflow-hidden">
                    @forelse ($posts as $post)
                        <div class="p-6 flex items-start">
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold mb-2">{{ substr($post->title, 0, 30) }}</h2>
                                <div class="text-sm mb-4">
                                    <span>{{ $post->created_at->diffForHumans() }}</span> &bull;
                                    <span>{{ $post->employee->user->name }}</span>
                                </div>
                                <p>{{ $post->excerpt }}</p>
                                <a href="{{ route('posts.show', $post->slug) }}"
                                    class="text-blue-500 hover:text-blue-800">Selengkapnya...
                                </a>
                            </div>
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita"
                                class="w-24 h-24 object-cover aspect-square rounded-lg ml-auto">
                        </div>
                        <!-- Pembatas -->
                        <div class="border-b-2 shadow-lg w-1/2 mx-auto"></div>
                    @empty
                        <div class="p-6 flex items-start">
                            <div class="flex-1">
                                <h2 class="text-2xl font-bold mb-2">Belum ada berita.</h2>
                            </div>
                        </div>
                    @endforelse
                    @if ($posts->count())
                        <div class="p-6 flex items-start">
                            <div class="flex-1">
                                {{ $posts->links() }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Berita Terbaru -->
            <x-news-widget></x-news-widget>
        </div>
    </section>

    <!-- Bagian Berita Populer -->
    <section class="container mx-auto my-10 px-4 sm:px-6 md:px-7 lg:px-4">
        <!-- Berita Populer --> 
        <h1 class="text-2xl font-bold mb-4">Berita Populer</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @forelse ($popularPosts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita Populer"
                        class="w-full h-48 object-cover">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">{{ substr($post->title, 0, 30) }}</h2>
                        <p class="text-gray-600">{{ $post->excerpt }}</p>
                        <a href="{{ route('posts.show', $post->slug) }}"
                            class="text-blue-500 hover:text-blue-800">Selengkapnya...
                        </a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-4">
                        <h2 class="text-lg font-semibold">Belum ada berita.</h2>
                        <p class="text-gray-600"></p>
                    </div>
                </div>
            @endforelse
        </div>
    </section>

</x-guest-layout>
