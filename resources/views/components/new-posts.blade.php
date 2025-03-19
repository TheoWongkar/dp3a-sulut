<!-- Bagian Berita Terbaru -->
<aside class="bg-white rounded-lg border border-gray-200 shadow-lg p-6 flex flex-col space-y-4"
    style="max-height: 473px; overflow-y: auto;">
    <h2 class="text-xl font-bold mb-2">Berita Terbaru</h2>
    <div class="space-y-4">
        @forelse ($newPosts as $post)
            <a href="{{ route('posts.show', $post->slug) }}"
                class="flex items-center gap-4 hover:bg-gray-100 p-2 rounded-lg transition">
                <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}"
                    alt="Thumbnail {{ $post->title }}"
                    class="w-16 h-16 object-cover rounded-lg aspect-square border border-gray-300" loading="lazy">
                <div>
                    <h3 class="text-lg font-semibold line-clamp-1">{{ $post->title }}</h3>
                    <p class="line-clamp-2 leading-tight">{{ strip_tags($post->content) }}</p>
                </div>
            </a>
        @empty
            <div class="text-center text-gray-500">
                <h3 class="text-md font-semibold">Belum ada berita.</h3>
            </div>
        @endforelse
    </div>
</aside>
