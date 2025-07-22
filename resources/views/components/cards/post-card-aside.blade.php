@props(['post' => null])

<a href="{{ route('post.show', $post->slug) }}"
    class="flex items-start gap-3 p-3 rounded-xl hover:bg-blue-100 transition">
    {{-- Gambar thumbnail --}}
    <div class="w-14 h-14 flex-shrink-0">
        <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRi2x8RiCqcGmMiQn455B9Jxup0QTcobH7bw&s' }}"
            alt="{{ $post->title }}" class="w-full h-full object-cover rounded-lg">
    </div>

    {{-- Informasi singkat --}}
    <div class="flex flex-col flex-1 overflow-hidden">
        {{-- Judul --}}
        <h2 class="text-sm font-semibold text-gray-800 line-clamp-2 leading-snug">
            {{ $post->title }}
        </h2>

        {{-- Meta info --}}
        <div class="flex items-center text-xs text-gray-500 gap-2 mt-1 flex-wrap">
            {{-- Kategori --}}
            @if ($post->category)
                <span class="bg-blue-100 text-blue-700 px-2 py-0.5 rounded text-[11px] font-medium">
                    {{ $post->category->name }}
                </span>
            @endif

            {{-- Views --}}
            <span class="flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-eye-fill" viewBox="0 0 16 16">
                    <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0" />
                    <path
                        d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8m8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7" />
                </svg>
                {{ $post->views }}
            </span>

            {{-- Tanggal --}}
            <span>
                {{ \Carbon\Carbon::parse($post->created_at)->translatedFormat('d M Y') }}
            </span>
        </div>
    </div>
</a>
