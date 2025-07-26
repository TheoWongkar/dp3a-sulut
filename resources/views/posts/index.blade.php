<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Berita</x-slot>

    {{-- Bagian Berita --}}
    <section class="relative z-10 -mt-[70vh] md:-mt-screen container mx-auto px-5 py-10">
        <div class="rounded-xl bg-gray-100 p-5">

            {{-- Berita --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                {{-- Kiri --}}
                <div class="md:col-span-2 space-y-4">
                    {{-- Judul --}}
                    <x-shared.section-title>Berita</x-shared.section-title>

                    {{-- Search dan Filter --}}
                    <form method="GET" action="{{ route('post.index') }}" x-data
                        class="flex flex-col md:flex-row md:items-center gap-2">

                        {{-- Search --}}
                        <div class="w-full">
                            <x-forms.input name="search" placeholder="Cari berita..." autocomplete="off"
                                :value="request('search')" x-on:input.debounce.500ms="$root.submit()" />
                        </div>

                        {{-- Filter Kategori --}}
                        <div class="w-full md:w-1/2">
                            <x-forms.select name="category" :options="$categories->pluck('name', 'slug')" :selected="request('category')"
                                x-on:change="$root.submit()" />
                        </div>
                    </form>

                    {{-- Card --}}
                    <div class="flex flex-col gap-4">
                        @forelse ($posts as $post)
                            <x-cards.post-card :post="$post"></x-cards.post-card>
                        @empty
                            <div class="p-4 rounded-md bg-yellow-100 text-yellow-800 text-sm">
                                Berita tidak ditemukan.
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination --}}
                    <div>
                        {{ $posts->withQueryString()->links('pagination::custom') }}
                    </div>
                </div>

                {{-- Kanan --}}
                <aside class="space-y-8">
                    <div class="space-y-4">
                        {{-- Judul --}}
                        <x-shared.section-title>Berita Terbaru</x-shared.section-title>

                        {{-- Card --}}
                        <div
                            class="max-h-80 overflow-y-auto bg-white rounded-xl shadow hover:shadow-md transition duration-300 p-3">
                            @forelse ($latestPosts as $post)
                                <x-cards.post-card-aside :post="$post"></x-cards.post-card-aside>
                            @empty
                                <div class="text-sm">
                                    Berita tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Judul --}}
                        <x-shared.section-title>Berita Teratas</x-shared.section-title>

                        {{-- Card --}}
                        <div
                            class="max-h-80 overflow-y-auto bg-white rounded-xl shadow hover:shadow-md transition duration-300 p-3">
                            @forelse ($popularPosts as $post)
                                <x-cards.post-card-aside :post="$post"></x-cards.post-card-aside>
                            @empty
                                <div class="text-sm">
                                    Berita tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <div class="space-y-4">
                        {{-- Judul --}}
                        <x-shared.section-title>Kategori Berita</x-shared.section-title>

                        <div class="flex flex-wrap gap-1">
                            @forelse ($categories as $category)
                                <span class="px-2 py-1 bg-blue-100 text-blue-700">{{ $category->name }}</span>
                            @empty
                                <div class="text-sm">
                                    Kategori tidak ditemukan.
                                </div>
                            @endforelse
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>

</x-guest-layout>
