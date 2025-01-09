<aside class="bg-white rounded-lg border-2 shadow-lg p-6 flex flex-col space-y-4"
    style="max-height: 473px; overflow-y: auto;">
    <h3 class="text-xl font-bold mb-2">Berita Terbaru</h3>
    <div class="space-y-4">
        @forelse ($newPosts as $post)
            <a href="{{ route('posts.show', $post->slug) }}" class="flex items-center">
                <img src="{{ asset('storage/' . $post->image) }}" alt="Thumbnail Berita"
                    class="w-16 h-16 object-cover rounded-lg mr-4 aspect-square">
                <div>
                    <h4 class="text-md font-semibold">{{ substr($post->title, 0, 15) }}</h4>
                    <p>{{ $post->excerpt }}</p>
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
