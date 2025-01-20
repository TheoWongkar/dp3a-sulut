<x-app-layout>

    <!-- Judul Halaman -->
    <x-title :title=$title></x-title>

    <!-- Bagian Lihat Berita -->
    <section>
        <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
            <!-- Detail Berita -->
            <div class="mb-3">
                <a href="{{ route('dashboard.posts.index') }}"
                    class="inline-block px-6 py-2 text-white bg-[#141652] rounded-lg shadow-lg hover:bg-blue-600 transition">
                    Kembali
                </a>
            </div>
            <img src="{{ asset('storage/' . $post->image) }}" alt="Berita {{ $post->title }}"
                class="w-full h-96 object-cover rounded-lg mb-6">
            <h1 class="text-2xl font-bold">{{ $post->title }}</h1>
            <div class="text-sm">
                <span>{{ $post->created_at->diffForHumans() }}</span> &bull;
                <span>{{ $post->employee->user->name }}</span> |
                <span>{{ $post->views }}x dikunjungi</span>
            </div>
            <div class="border-t border-blue-300 mt-2 mb-4"></div>
            <p class="text-md">{!! $post->body !!}</p>
        </div>
    </section>

</x-app-layout>
