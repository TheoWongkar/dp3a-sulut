<x-guest-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Script Tambahan -->
    <x-slot name="script">
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.8/dist/chart.umd.min.js"></script>
    </x-slot>

    <!-- Bagian Hero -->
    <section class="relative flex items-center justify-center h-screen bg-cover bg-center"
        style="background-image: url('{{ asset('img/hero-image.webp') }}');">
        <div class="absolute inset-0 bg-black/50"></div>

        <!-- Konten -->
        <div class="relative text-center text-white max-w-3xl mx-auto">
            <div class="mb-5 flex justify-center">
                <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Aplikasi" class="w-25 h-25 md:w-30 md:h-30">
            </div>
            <h1 class="text-2xl md:text-3xl lg:text-5xl font-bold leading-tight tracking-wide md:tracking-wider">
                JANGAN TAKUT LAPORKAN KEKERASAN PADA ANAK
            </h1>
            <p class="mt-4 text-md md:text-xl lg:text-2xl">
                BERSAMA, KITA LINDUNGI MEREKA!
            </p>
            <a href="{{ route('reports.create') }}"
                class="mt-5 inline-block border border-white bg-transparent hover:bg-[#141652] font-semibold py-2 px-8 rounded-xl transition duration-300">
                LAPORKAN SEKARANG
            </a>
        </div>
    </section>

    <!-- Bagian Berita -->
    <section class="container mx-auto px-4 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Bingkai Kiri -->
            <div class="md:col-span-2">
                <div class="bg-white rounded-lg shadow-lg border border-gray-200">
                    @isset($post)
                        <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}"
                            alt="Gambar {{ $post->title }}" class="w-full h-64 md:h-80 rounded-t-lg object-cover"
                            loading="lazy">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold line-clamp-1">{{ $post->title }}</h2>
                            <div class="font-medium mb-2 text-gray-600">
                                <h3 class="inline">{{ $post->author->username }}</h3> &bull;
                                <span>{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="line-clamp-4">{{ strip_tags($post->content) }}</p>
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-blue-700 hover:text-blue-800">
                                Selengkapnya...
                            </a>
                        </div>
                    @else
                        <div class="p-6 text-center">
                            <h2 class="text-xl font-bold mb-2">Belum ada berita.</h2>
                        </div>
                    @endisset
                </div>
            </div>

            <!-- Bingkai Kanan -->
            <x-new-posts></x-new-posts>
        </div>
    </section>

    <!-- Bagian Pantau -->
    <section class="bg-gray-300 w-full">
        <div class="container mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Bingkai Kiri -->
            <div class="flex flex-col justify-center">
                <h2 class="text-2xl font-bold mb-4 leading-snug">
                    Pantau Perkembangan Laporan Secara Real-Time!
                </h2>
                <p class="mb-6 text-sm">
                    Angka-angka ini bukan hanya data, mereka adalah cerita nyata di balik setiap laporan. Dengan
                    statistik laporan ini, kita bisa merespon dengan cepat dan tepat, menyesuaikan langkah, dan
                    memastikan perlindungan yang lebih baik bagi anak-anak di seluruh negeri. Ambil langkah ini untuk
                    mendapatkan lebih banyak informasi secara real-time dan mendukung keselamatan mereka.
                </p>
                <div>
                    <a href="https://kekerasan.kemenpppa.go.id/ringkasan"
                        class="inline-block px-6 py-3 text-white bg-[#141652] rounded-md hover:bg-blue-800 transition duration-300">
                        SELENGKAPNYA
                    </a>
                </div>
            </div>

            <!-- Bingkai Kanan -->
            <div class="flex items-center justify-center">
                <div class="w-full h-72 bg-white border border-gray-300 shadow-lg rounded-md p-5 overflow-hidden">
                    <canvas id="reportChart"></canvas>
                </div>
            </div>
        </div>
    </section>

    @if ($newPosts->count())
        <section class="py-12">
            <div x-data="{
                activeSlide: 0,
                slides: [
                    @foreach ($newPosts as $post)
                    { img: '{{ $post->image ? asset('storage/' . $post->image) : asset('img/placeholder-image.webp') }}', title: '{{ $post->title }}' }, @endforeach
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
            }" x-init="startAutoplay()" @mouseenter="stopAutoplay()"
                @mouseleave="startAutoplay()" class="relative w-full max-w-5xl mx-auto overflow-hidden">

                <!-- Container Carousel -->
                <div class="overflow-hidden relative">
                    <div class="flex transition-transform duration-500 ease-in-out"
                        :style="`transform: translateX(-${activeSlide * 100}%)`">
                        <template x-for="(slide, index) in slides" :key="index">
                            <div class="min-w-full flex-shrink-0">
                                <img :src="slide.img" :alt="slide.title"
                                    class="w-full max-w-full h-40 sm:h-64 md:h-80 object-cover rounded-lg shadow-lg border border-gray-200">
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Tombol Navigasi -->
                <button @click="activeSlide = activeSlide === 0 ? slides.length - 1 : activeSlide - 1"
                    aria-label="Tombol Sebelumnya"
                    class="absolute left-2 sm:left-5 top-1/2 transform -translate-y-1/2 text-lg sm:text-xl md:text-2xl bg-white bg-opacity-50 hover:bg-opacity-100 rounded-full p-2">
                    &#10094;
                </button>

                <button @click="activeSlide = activeSlide === slides.length - 1 ? 0 : activeSlide + 1"
                    aria-label="Tombol Lanjut"
                    class="absolute right-2 sm:right-5 top-1/2 transform -translate-y-1/2 text-lg sm:text-xl md:text-2xl bg-white bg-opacity-50 hover:bg-opacity-100 rounded-full p-2">
                    &#10095;
                </button>

                <!-- Indikator Dots -->
                <div class="absolute bottom-4 left-0 right-0 flex justify-center space-x-2">
                    <template x-for="(slide, index) in slides" :key="index">
                        <button @click="activeSlide = index" aria-label="Tombol Indikator"
                            :class="activeSlide === index ? 'bg-blue-600' : 'bg-gray-300'"
                            class="w-3 h-3 rounded-full transition-opacity duration-300"></button>
                    </template>
                </div>
            </div>
        </section>
    @endif

    <script defer>
        document.addEventListener("DOMContentLoaded", function() {
            const reportCtx = document.getElementById('reportChart');

            if (reportCtx) {
                new Chart(reportCtx, {
                    type: 'line',
                    data: {
                        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt',
                            'Nov', 'Des'
                        ],
                        datasets: [{
                            label: 'Total Kasus',
                            data: @json($totalReportsPerMonth ?? []),
                            borderWidth: 2,
                            borderColor: '#1d4ed8',
                            backgroundColor: 'rgba(29, 78, 216, 0.2)',
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: {
                                    drawBorder: false,
                                    color: 'rgba(200, 200, 200, 0.2)',
                                    borderDash: [5,
                                        5
                                    ]
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            }
        });
    </script>

</x-guest-layout>
