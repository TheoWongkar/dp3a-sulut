<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Lihat Berita -->
    <section class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">

        <!-- Tombol Kembali ke Daftar Berita -->
        <div class="mb-3">
            <a href="{{ route('dashboard.posts.index') }}"
                class="inline-block px-6 py-2 text-white bg-[#141652] rounded-lg shadow-lg hover:bg-blue-600 transition">
                Kembali
            </a>
        </div>

        <!-- Gambar Berita -->
        <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita {{ $post->title }}"
            class="w-full h-96 object-cover rounded-lg mb-6">

        <!-- Judul Berita -->
        <h1 class="text-2xl font-bold mb-2">{{ $post->title }}</h1>

        <!-- Informasi Terkait Berita -->
        <div class="text-sm text-gray-600 mb-4">
            <!-- Waktu Pembuatan Berita -->
            <span>{{ $post->created_at->diffForHumans() }}</span> &bull;

            <!-- Nama Jurnalis -->
            <span>{{ $post->employee->user->name }}</span> |

            <!-- Jumlah Kunjungan Berita -->
            <span>{{ $post->views }}x dikunjungi</span>
        </div>

        <!-- Pembatas (Divider) -->
        <div class="border-t border-blue-300 mt-2 mb-4"></div>

        <!-- Isi Berita -->
        <p class="text-md leading-relaxed">{!! $post->body !!}</p>
    </section>

</x-app-layout>
