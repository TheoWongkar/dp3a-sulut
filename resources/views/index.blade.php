<x-guest-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Beranda</x-slot>

    {{-- Script Tambahan --}}
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @endpush

    {{-- Bagian Prakata --}}
    <section class="bg-white">
        <div class="container mx-auto px-5 py-10">

            {{-- Header: Nama & Jabatan --}}
            <div class="flex py-8 items-center justify-center">
                {{-- Teks --}}
                <div class="text-right">
                    <h2 class="text-lg md:text-3xl font-bold text-gray-800">Kepala Dinas P3AD Provinsi Sulut</h2>
                    <h3 class="text-md md:text-3xl text-gray-800">WANDA L.C MUSU, SE, ME</h3>
                    <div class="ml-auto w-3/4 bg-[#141652] py-0.5 skew-x-[-20deg]"></div>
                </div>

                {{-- Gambar --}}
                <div class="flex-shrink-0">
                    <img src="{{ asset('img/kadis-wandamusu.webp') }}" alt="Foto Kepala Dinas"
                        class="w-32 md:w-64 h-auto object-cover rounded">
                    <div class="w-full bg-[#141652] py-2 skew-x-[-20deg]"></div>
                </div>
            </div>

            {{-- Prakata --}}
            <div class="space-y-4">
                {{-- Judul --}}
                <x-shared.section-title>Prakata Kepala Dinas P3AD Prov. Sulut</x-shared.section-title>

                {{-- Isi --}}
                <p class="indent-8 text-sm text-justify text-gray-700 leading-relaxed">
                    Ucapan syukur kami panjatkan kehadirat Tuhan Yang Maha Kuasa karena atas perkenan Tuhan Website
                    Dinas Pemberdayaan Perempuan dan Perlindungan Anak Daerah Provinsi Sulawesi Utara boleh selesai
                    dan dapat dipublish, sehingga masyarakat bisa memperoleh informasi dengan mengakses website ini
                    baik dari Komputer/Laptop atau juga melalui Smartphone.
                </p>

                <p class="indent-8 text-sm text-justify text-gray-700 leading-relaxed">
                    Saya selaku Kepala Dinas Pemberdayaan Perempuan dan Perlindungan Anak Daerah mengucapkan banyak
                    terima kasih kepada pihak terkait yang sudah berupaya dalam mendesign website ini sehingga bisa
                    dikonsumsi oleh masyarakat. Kami menyadari bahwa website ini belum sempurna, sehingga dengan
                    segala kerendahan hati kami membutuhkan koreksi, masukan positif guna pemanfaatan website ini.
                </p>

                <p class="indent-8 text-sm text-justify text-gray-700 leading-relaxed">
                    Semoga dengan adanya website ini, dapat memberikan ruang informasi terbuka kepada masyarakat
                    luas khususnya di daerah Sulawesi Utara terkait adanya Pusat Pelayanan Terpadu Pemberdayaan
                    Perempuan dan Anak dimana didalam website ini kami telah menyediakan Aplikasi bilamana terjadi
                    kekerasan terhadap perempuan dan anak. Diharapkan segera mengubungi call center yang sudah kami
                    sediakan.
                </p>

                <p class="indent-8 text-sm text-justify text-gray-700 leading-relaxed">
                    Akhirnya dengan memanjatkan puji syukur kehadirat Tuhan yang Maha Kuasa, maka Website Dinas
                    Pemberdayaan Perempuan dan Perlindungan Anak Daerah Provinsi Sulawesi Utara dengan ini saya
                    resmikan dan siap dikonsumsi oleh masyarakat.
                </p>

                <p class="indent-8 text-sm text-justify text-gray-700 leading-relaxed">Terima kasih</p>
            </div>
        </div>
    </section>

    {{-- Bagian Statistik --}}
    <section>
        <div class="container mx-auto px-5 py-10">

            {{-- Statistik --}}
            <div class="space-y-4">
                {{-- Judul --}}
                <x-shared.section-title>Pantau Secara Real-time</x-shared.section-title>

                <div class="grid grid-cols-1 md:grid-cols-2 items-stretch gap-5">
                    {{-- Kiri: Teks --}}
                    <div class="h-full">
                        <p class="text-sm text-justify text-gray-700 leading-relaxed">
                            Angka-angka ini bukan hanya data, mereka adalah cerita nyata di balik setiap laporan. Dengan
                            statistik laporan ini,
                            kita bisa merespon dengan cepat dan tepat, menyesuaikan langkah, dan memastikan perlindungan
                            yang lebih baik bagi
                            anak-anak di seluruh negeri. Ambil langkah ini untuk mendapatkan lebih banyak informasi
                            secara real-time dan
                            mendukung keselamatan mereka.
                        </p>

                        <x-buttons.primary-button href="https://kekerasan.kemenpppa.go.id/ringkasan" target="__BLANK"
                            class="inline-block mt-2">
                            Selengkapnya
                        </x-buttons.primary-button>
                    </div>

                    {{-- Kanan: Chart --}}
                    <div class="h-full overflow-hidden bg-white p-5 border border-gray-300 rounded-md">
                        <canvas id="reportChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Bagian Berita --}}
    @if ($latestPosts->count())
        <section class="bg-white">
            <div class="container mx-auto px-5 py-10">

                {{-- Berita --}}
                <div class="space-y-4">
                    {{-- Judul --}}
                    <x-shared.section-title>Berita</x-shared.section-title>

                    {{-- Card --}}
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                        @foreach ($latestPosts as $post)
                            <a href="{{ route('post.show', $post->slug) }}"
                                class="bg-white rounded-xl shadow hover:shadow-md hover:scale-102 transition duration-300 flex flex-col">
                                {{-- Gambar --}}
                                <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSRi2x8RiCqcGmMiQn455B9Jxup0QTcobH7bw&s' }}"
                                    alt="{{ $post->title }}" class="w-full h-48 object-cover rounded-t-xl">

                                <div class="p-4 flex flex-col flex-1 space-y-2">
                                    {{-- Kategori --}}
                                    @if ($post->category)
                                        <span
                                            class="inline-block w-fit bg-blue-100 text-blue-700 text-xs font-medium px-2 py-1 rounded">
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
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Bagian Berita Kekerasan --}}
    @if ($carouselPosts->count())
        <section>
            <div class="container mx-auto px-5 py-10">

                {{-- Berita --}}
                <div class="space-y-4">
                    {{-- Judul --}}
                    <x-shared.section-title>Berita Kekerasan</x-shared.section-title>

                    {{-- Statistik --}}
                    <div x-data="carouselComponent()" x-init="init()"
                        class="flex flex-col items-center space-y-4 w-full">
                        {{-- Carousel Images --}}
                        <div class="flex items-center justify-center gap-4 w-full overflow-x-hidden">
                            {{-- Previous --}}
                            <button @click="goToPage(currentPage - 1)" :disabled="currentPage === 0"
                                aria-label="Previous Button"
                                class="bg-white p-2 rounded-full cursor-pointer transition hover:bg-blue-100 disabled:hover:bg-white disabled:opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0" />
                                </svg>
                            </button>

                            {{-- Carousel Items --}}
                            <template x-for="post in paginatedItems" :key="post.slug">
                                <a :href="'{{ route('post.index', '') }}/' + post.slug" aria-label="Berita"
                                    class="block">
                                    <img :src="post.image" :alt="post.title"
                                        class="rounded-xl shadow hover:shadow-md transition duration-300 w-36 h-36 object-cover">
                                </a>
                            </template>

                            {{-- Next --}}
                            <button @click="goToPage(currentPage + 1)" :disabled="currentPage >= totalPages - 1"
                                aria-label="Next Button"
                                class="bg-white p-2 rounded-full cursor-pointer transition hover:bg-blue-100 disabled:hover:bg-white disabled:opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                        d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708" />
                                </svg>
                            </button>
                        </div>

                        {{-- Pagination Dots --}}
                        <div class="flex gap-2">
                            <template x-for="(dot, index) in totalPages" :key="index">
                                <button @click="goToPage(index)" aria-label="Pagination Dots"
                                    class="w-2 h-2 cursor-pointer rounded-full transition-all duration-200"
                                    :class="index === currentPage ? 'bg-gray-800 scale-110' : 'bg-gray-400'">
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <script>
        const ctx = document.getElementById('reportChart').getContext('2d');

        const reportChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
                    'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'
                ],
                datasets: [{
                    label: 'Jumlah Laporan',
                    data: @json($monthlyReports->values()),
                    borderColor: '#141652',
                    backgroundColor: '#E9F0FF',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#141652'
                }]
            },
            options: {
                maintainAspectRatio: false,
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

    <script>
        function carouselComponent() {
            return {
                currentPage: 0,
                perPage: 5,
                items: @js(
    $carouselPosts->map(
        fn($p) => [
            'image' => $p->image ? asset('storage/' . $p->image) : asset('img/placeholder-image.webp'),
            'slug' => $p->slug,
        ],
    ),
),
                get totalPages() {
                    return Math.ceil(this.items.length / this.perPage);
                },
                get paginatedItems() {
                    const start = this.currentPage * this.perPage;
                    return this.items.slice(start, start + this.perPage);
                },
                goToPage(index) {
                    if (index >= 0 && index < this.totalPages) {
                        this.currentPage = index;
                    }
                },
                updatePerPage() {
                    const width = window.innerWidth;
                    if (width < 768) {
                        this.perPage = 2;
                    } else if (width < 1024) {
                        this.perPage = 3;
                    } else {
                        this.perPage = 5;
                    }
                    this.currentPage = 0;
                },
                init() {
                    this.updatePerPage();
                    window.addEventListener('resize', () => {
                        this.updatePerPage();
                    });
                }
            }
        }
    </script>

</x-guest-layout>
