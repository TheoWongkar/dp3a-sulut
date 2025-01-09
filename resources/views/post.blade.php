<x-guest-layout>

    <!-- Bagian Berita -->

    <section class="container mx-auto px-4 pt-24 pb-10 sm:px-6 lg:px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Detail Berita -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white rounded-lg shadow-lg border-2 p-6">
                    <div class="mb-3">
                        <a href="{{ route('posts.index') }}"
                            class="inline-block px-6 py-2 text-white bg-[#141652] rounded-lg shadow-lg hover:bg-blue-600 transition">
                            Kembali
                        </a>
                    </div>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita"
                        class="w-full h-96 object-cover rounded-lg mb-6">
                    <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>
                    <div class="text-sm mb-4">
                        <span>{{ $post->created_at->diffForHumans() }}</span> &bull;
                        <span>{{ $post->employee->user->name }}</span>
                    </div>
                    <p class="text-lg">{{ $post->body }}</p>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <aside class="bg-white rounded-lg border-2 shadow-lg p-6 flex flex-col space-y-4"
                style="max-height: 500px; overflow-y: auto;">
                <h3 class="text-xl font-bold mb-4">Berita Terbaru</h3>
                <div class="space-y-4">
                    @forelse ($newPosts as $post)
                        <div class="flex items-center">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita Terbaru"
                                class="w-16 h-16 object-cover rounded-lg mr-4 aspect-square">
                            <div>
                                <h4 class="text-md font-semibold">{{ substr($post->title, 0, 15) }}</h4>
                                <p>{{ $post->excerpt }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex items-center">
                            <div>
                                <h4 class="text-md font-semibold">Belum ada berita.</h4>
                            </div>
                        </div>
                    @endforelse
                </div>
            </aside>
        </div>
    </section>

</x-guest-layout>
