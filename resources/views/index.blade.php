<x-guest-layout>

    <!-- Bagian Title -->
    @section('title')
        @isset($title)
            | {{ $title }}
        @endisset
    @endsection

    <!-- Bagian Hero -->
    <section class="relative flex items-center justify-center h-screen bg-cover bg-center"
        style="background-image: url('https://png.pngtree.com/background/20230424/original/pngtree-bamboo-pathway-in-the-forest-wallpaper-hd-picture-image_2464509.jpg');">
        <div class="absolute inset-0 bg-opacity-100"></div>
        <!-- Konten -->
        <div class="relative z-10 text-center text-white max-w-3xl mx-auto">
            <div class="mb-8 flex justify-center">
                <x-application-logo class="w-16 h-16" />
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight tracking-wider">
                JANGAN TAKUT LAPORKAN KEKERASAN PADA ANAK
            </h1>
            <p class="mt-4 text-lg sm:text-xl lg:text-2xl">
                BERSAMA, KITA LINDUNGI MEREKA!
            </p>
            <a href="{{ route('reports.index') }}"
                class="mt-6 inline-block border hover:bg-[#141652] font-semibold py-2 px-8 rounded-xl transition duration-300">
                LAPORKAN SEKARANG
            </a>
        </div>

        <!-- Chat Bot -->
        <div x-data="{ open: false }" class="fixed bottom-4 right-4 z-20">
            <!-- Chat Icon -->
            <div x-show="!open" @click="open = true"
                class="cursor-pointer bg-blue-700 hover:bg-[#141652] text-white p-2 rounded-full shadow-lg">
                <img src="{{ asset('img/chatbot-logo.png') }}" alt="Chatbot" class="size-14">
            </div>

            <!-- Chat Widget -->
            <div x-cloak x-show="open" class="w-80 bg-white rounded-lg shadow-lg flex flex-col">
                <!-- Chat Header -->
                <div class="bg-[#141652] hover:bg-blue-700 text-white p-3 rounded-t-lg cursor-pointer"
                    @click="open = false">
                    <h4 class="font-bold">DP3A Chatbot</h4>
                </div>

                <!-- Chat Container -->
                <div id="chat-container" class="flex-1 p-4 space-y-3 max-h-64 overflow-y-auto">
                    <!-- Messages will appear here -->
                </div>

                <!-- Chat Form -->
                <form id="chat-form" class="p-3 border-t">
                    <div class="flex items-center space-x-2">
                        <input type="text" id="message"
                            class="flex-1 border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring focus:ring-blue-300"
                            placeholder="Tanyakan sesuatu..." autocomplete="off">
                        <button type="submit"
                            class="bg-[#141652] text-white px-4 py-2 rounded-lg hover:bg-blue-700">Kirim</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Bagian Konten -->
    <section class="container mx-auto px-4 py-10 sm:px-6 lg:px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Bingkai Kiri -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg border-2 overflow-hidden">
                    @if ($post)
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Gambar Berita"
                            class="w-full h-64 md:h-80 object-cover">
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-2">{{ $post->title }}</h2>
                            <div class="text-sm font-medium mb-4">
                                <span>{{ $post->created_at->diffForHumans() }}</span> &bull;
                                <span>{{ $post->employee->user->name }}</span>
                            </div>
                            <p class="font-normal">{{ $post->excerpt }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}"
                                class="text-blue-500 hover:text-blue-800">Selengkapnya...
                            </a>
                        </div>
                    @else
                        <div class="p-6">
                            <h2 class="text-2xl font-bold mb-2">Belum ada berita.</h2>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bingkai Kanan -->
            <x-news-widget></x-news-widget>
        </div>
    </section>

    <!-- Bagian Pantau -->
    <section class="container bg-gray-300 max-w-full">
        <div class="px-4 py-10 sm:px-6 lg:px-14 rounded-lg grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Bingkai Kiri -->
            <div class="flex flex-col justify-center">
                <h2 class="text-2xl lg:text-3xl font-bold mb-4 leading-snug">
                    Pantau Perkembangan Laporan Secara Real-Time!
                </h2>
                <p class="mb-6">
                    Angka-angka ini bukan hanya data, mereka adalah cerita nyata di balik setiap laporan. Dengan
                    statistik laporan ini, kita bisa merespon dengan cepat dan tepat, menyesuaikan langkah, dan
                    memastikan perlindungan yang lebih baik bagi anak-anak di seluruh negeri. Ambil langkah ini untuk
                    mendapatkan lebih banyak informasi secara real-time dan mendukung keselamatan mereka.
                </p>
                <div>
                    <a href="#"
                        class="inline-block px-6 py-3 text-white bg-[#141652] rounded-md hover:bg-blue-900 transition duration-300">
                        SELENGKAPNYA
                    </a>
                </div>
            </div>

            <!-- Bingkai Kanan -->
            <div class="flex items-center justify-center">
                <div class="w-full h-72 bg-gray-300 border-2 border-gray-800 rounded-md"></div>
            </div>
        </div>
    </section>

    <!-- Bagian Carousel -->
    <section class="py-12">
        <div x-data="{
            activeSlide: 0,
            slides: [
                @foreach ($newPosts as $postCarousel)
                    '{{ asset('storage/' . $postCarousel->image) }}', @endforeach
            ],
            autoplay: null,
            startAutoplay() {
                this.autoplay = setInterval(() => {
                    this.activeSlide = (this.activeSlide + 1) % this.slides.length;
                }, 3000);
            },
            stopAutoplay() {
                clearInterval(this.autoplay);
            }
        }" x-init="startAutoplay" @mouseenter="stopAutoplay" @mouseleave="startAutoplay"
            class="relative w-full max-w-4xl mx-auto">
            <!-- Carousel Container -->
            <div class="overflow-hidden relative">
                <div class="flex transition-transform duration-500"
                    :style="`transform: translateX(-${activeSlide * 100}%)`">
                    <template x-for="(slide, index) in slides" :key="index">
                        <div class="min-w-full flex-shrink-0">
                            <img :src="slide" alt="Slide Image"
                                class="w-full h-64 object-cover rounded-lg shadow-lg">
                        </div>
                    </template>
                </div>
            </div>
            <!-- Prev Button -->
            <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1" @focus="stopAutoplay"
                @blur="startAutoplay" aria-label="Previous Slide"
                class="absolute left-0 top-1/2 transform -translate-y-1/2 text-2xl bg-white rounded-full shadow-lg p-2 focus:outline-none">
                &#10094;
            </button>
            <!-- Next Button -->
            <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1" @focus="stopAutoplay"
                @blur="startAutoplay" aria-label="Next Slide"
                class="absolute right-0 top-1/2 transform -translate-y-1/2 text-2xl bg-white rounded-full shadow-lg p-2 focus:outline-none">
                &#10095;
            </button>
            <!-- Dots Indicator -->
            <div class="absolute bottom-0 left-0 right-0 flex justify-center space-x-2 p-4">
                <template x-for="(slide, index) in slides" :key="index">
                    <button @click="activeSlide = index"
                        :class="{ 'bg-blue-600': activeSlide === index, 'bg-gray-300': activeSlide !== index }"
                        class="w-3 h-3 rounded-full transition duration-300 ease-in-out"></button>
                </template>
            </div>
        </div>
    </section>

</x-guest-layout>
