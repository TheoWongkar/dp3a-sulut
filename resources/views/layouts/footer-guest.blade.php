<!-- Bagian Footer -->
<footer class="bg-[#141652] text-white py-8">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Logo dan Deskripsi -->
        <section aria-labelledby="footer-about"
            class="flex flex-col items-center md:items-start text-center md:text-left">
            <x-application-logo class="w-24 h-24 mb-4 fill-current" />
            <h2 id="footer-about" class="sr-only">Tentang Kami</h2>
            <p class="text-sm md:text-base">
                SIPPAT adalah platform untuk melaporkan kekerasan pada anak, memastikan perlindungan dan
                keamanan anak-anak di seluruh Indonesia.
            </p>
        </section>

        <!-- Tautan Penting -->
        <nav aria-labelledby="footer-links" class="flex flex-col items-center md:items-start">
            <h2 id="footer-links" class="font-semibold mb-4">Tautan Penting</h2>
            <ul class="space-y-2 text-center md:text-left">
                <li><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
                <li><a href="{{ route('posts.index') }}" class="hover:underline">Berita</a></li>
                <li><a href="{{ route('status.index') }}" class="hover:underline">Cek Status</a></li>
                <li><a href="#" class="hover:underline">Kebijakan Privasi</a></li>
                <li><a href="#" class="hover:underline">Bantuan</a></li>
            </ul>
        </nav>

        <!-- Kontak -->
        <section aria-labelledby="footer-contact" class="flex flex-col items-center md:items-start">
            <h2 id="footer-contact" class="font-semibold mb-4">Kontak Kami</h2>
            <address class="not-italic text-sm md:text-base">
                Jl. Balaikota No.01, Tikala Ares, 95012 | Manado - Sulawesi Utara<br>
                Telepon: (0431) 456-7890<br>
                Website:
                <a href="https://dpppa.manadokota.go.id/" target="_blank" class="hover:text-blue-500">
                    dp3a.sulutprov.go.id
                </a>
            </address>
        </section>
    </div>

    <!-- Hak Cipta -->
    <div class="mt-8 border-t mx-4 md:mx-auto border-gray-600 pt-4 text-center">
        <p class="text-xs md:text-sm">
            &copy; 2025 DP3A Sulawesi Utara. Semua Hak Dilindungi Undang-Undang.
        </p>
    </div>
</footer>
