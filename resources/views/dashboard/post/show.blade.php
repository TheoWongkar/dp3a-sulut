<x-guest-layout>

    <!-- Bagian Berita -->
    <section class="container mx-auto px-4 pt-24 pb-10 sm:px-6 lg:px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Detail Berita -->
            <div class="md:col-span-2 space-y-8">
                <div class="bg-white rounded-lg shadow-lg border-2 p-6">
                    <div class="mb-3">
                        <a href="{{ route('dashboard.posts.index') }}"
                            class="inline-block px-6 py-2 text-white bg-[#141652] rounded-lg shadow-lg hover:bg-blue-600 transition">
                            Kembali
                        </a>
                    </div>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita"
                        class="w-full h-96 object-cover rounded-lg mb-6">
                    <h1 class="text-3xl font-bold">{{ $post->title }}</h1>
                    <div class="text-sm">
                        <span>{{ $post->created_at->diffForHumans() }}</span> &bull;
                        <span>{{ $post->employee->user->name }}</span> |
                        <span>{{ $post->views }}x dikunjungi</span>
                    </div>
                    <div class="border-t border-blue-300 mt-2 mb-4"></div>
                    <p class="text-lg">{!! $post->body !!}</p>
                </div>
            </div>

            <!-- Berita Terbaru -->
            <x-news-widget></x-news-widget>
        </div>
    </section>

</x-guest-layout>
