<footer class="bg-[#141652] text-white z-20">
    <div class="container mx-auto px-5 py-10 grid grid-cols-1 md:grid-cols-6 gap-8">
        {{-- Kolom Logo & Instansi --}}
        <div class="col-span-2">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Pemprov Sulut"
                        class="w-10 h-10 md:w-12 md:h-12 object-contain">
                    <div class="text-xs md:text-sm font-medium leading-tight">
                        Dinas Pemberdayaan Perempuan<br>
                        dan Perlindungan Anak<br>
                        <span class="text-gray-300 font-normal">Sulawesi Utara</span>
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2 max-w-xs">
                    Komitmen kami untuk mewujudkan perlindungan terhadap perempuan dan anak di Provinsi Sulawesi Utara.
                </p>
            </div>
        </div>

        {{-- Kolom Navigasi --}}
        <div>
            <h2 class="text-sm font-semibold mb-3">Navigasi</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:underline hover:text-blue-200">Beranda</a></li>
                <li><a href="{{ route('post.index') }}" class="hover:underline hover:text-blue-200">Berita</a></li>
                <li><a href="{{ route('report.check-status') }}" class="hover:underline hover:text-blue-200">Cek Status
                        Laporan</a></li>
                <li><a href="{{ route('report.create') }}" class="hover:underline hover:text-blue-200">Laporkan
                        Kekerasan</a></li>
            </ul>
        </div>

        {{-- Kolom Link --}}
        <div>
            <h2 class="text-sm font-semibold mb-3">Link</h2>
            <ul class="space-y-2 text-sm">
                <li><a href="https://kemenpppa.go.id" class="hover:underline hover:text-blue-200">Kemenpppa</a></li>
                <li><a href="https://sulutprov.go.id" class="hover:underline hover:text-blue-200">Pemerintah Provinsi
                        Sulut</a></li>
                <li><a href="https://kekerasan.kemenpppa.go.id" class="hover:underline hover:text-blue-200">SIMFONI
                        PPA</a></li>
            </ul>
        </div>

        {{-- Kolom Kontak --}}
        <div class="col-span-2">
            <h2 class="text-sm font-semibold mb-3">Kontak</h2>
            <ul class="text-sm space-y-2 text-gray-300">
                <li>Telepon: <a href="tel:+62 431-843333" class="hover:underline">+62 431-843333</a>
                </li>
                <li>Alamat: Jl. 17 Agustus Provinsi Sulawesi Utara</li>
            </ul>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="border-t border-white/10 mt-8">
        <div class="container mx-auto px-4 py-4 text-xs text-center text-gray-400">
            &copy; {{ date('Y') }} Dinas Pemberdayaan Perempuan dan Perlindungan Anak Provinsi Sulawesi Utara.
            All rights reserved.
        </div>
    </div>
</footer>
