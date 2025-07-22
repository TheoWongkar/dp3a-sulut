@props(['post' => null])

<a href="{{ route('post.show', $post->slug) }}"
    class="bg-white rounded-xl shadow hover:shadow-md hover:scale-102 transition duration-300 flex flex-col md:flex-row overflow-hidden">
    {{-- Gambar kiri --}}
    <div class="md:w-1/4">
        <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRi2x8RiCqcGmMiQn455B9Jxup0QTcobH7bw&s' }}"
            alt="{{ $post->title }}" class="w-full h-24 md:h-full object-cover">
    </div>

    {{-- Konten kanan --}}
    <div class="p-4 flex flex-col flex-1 space-y-2">
        {{-- Kategori --}}
        @if ($post->category)
            <span class="inline-block w-fit bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded">
                {{ $post->category->name }}
            </span>
        @endif

        {{-- Judul --}}
        <h2 class="text-lg font-semibold text-gray-800 line-clamp-2">
            {{ $post->title }}
        </h2>

        {{-- Konten ringkas --}}
        <p class="text-sm text-gray-700 leading-relaxed line-clamp-3">
            {{ strip_tags($post->content) }}
        </p>

        {{-- Spacer --}}
        <div class="flex-grow"></div>

        {{-- Info views dan tanggal --}}
        <div class="flex justify-between items-center text-xs text-gray-500 pt-2 border-t">
            <span>{{ $post->views }}x dilihat</span>
            <span>{{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('d F Y') }}</span>
        </div>
    </div>
</a>
