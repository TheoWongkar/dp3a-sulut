<!-- Bagian Berita Terbaru -->
<aside class="bg-white rounded-lg border border-gray-300  shadow-lg p-6 flex flex-col space-y-4"
    style="max-height: 473px; overflow-y: auto;">
    <h3 class="text-xl font-bold mb-2">Berita Terbaru</h3>
    <div class="space-y-4">
        @forelse ($newPosts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Thumbnail {{ $post->title }}"
                    class="w-16 h-16 object-cover rounded-lg mr-4 aspect-square border border-gray-300 ">
                <div>
                    <h4 class="text-md font-semibold">{{ substr($post->title, 0, 15) }}</h4>
                    <p>{{ substr($post->excerpt, 0, 50) }}</p>
                </div>
            </a>
        @empty
            <div class="flex items-center">
                <div>
                    <h4 class="text-md font-semibold">Belum ada berita.</h4>
                </div>
            </div>
        @endforelse
    </div>
</aside>
