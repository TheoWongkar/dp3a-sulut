<!-- Footer -->
<footer class="bg-[#141652] text-white py-8">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8">
        <!-- Logo dan Deskripsi -->
        <section class="flex flex-col items-center md:items-start text-center md:text-left">
            <img src="{{ asset('img/application-logo.svg') }}" alt="Logo Aplikasi" class="w-24 h-24 mb-4">
            <p>
                SIPPAT adalah platform untuk melaporkan kekerasan pada anak, memastikan perlindungan dan keamanan
                anak-anak di seluruh Indonesia.
            </p>
        </section>

        <!-- Tautan Penting -->
        <nav class="flex flex-col items-center md:items-start">
            <h2 class="font-bold mb-4">Tautan Penting</h2>
            <ul class="space-y-2 text-center md:text-left">
                <li><a href="{{ route('home') }}" class="hover:underline">Beranda</a></li>
                <li><a href="{{ route('posts.index') }}" class="hover:underline">Berita</a></li>
                <li><a href="https://kekerasan.kemenpppa.go.id/ringkasan" target="_blank" rel="noopener noreferrer"
                        class="hover:underline">KemenPPPA</a></li>
                <li><a href="https://sulutprov.go.id/" target="_blank" rel="noopener noreferrer"
                        class="hover:underline">SulutProv</a></li>
                <li><a href="https://revolusimental.go.id/" target="_blank" rel="noopener noreferrer"
                        class="hover:underline">Revolusi Mental</a></li>
            </ul>
        </nav>

        <!-- Kontak -->
        <section class="flex flex-col items-center md:items-start">
            <h2 class="font-bold mb-4">Kontak Kami</h2>
            <address class="not-italic text-center md:text-left">
                Alamat: <span class="text-gray-300">Jl. Balaikota No.01, Tikala Ares, 95012 | Kota Manado, Sulawesi
                    Utara</span><br>
                Telepon: <span class="text-gray-300">(0431) 456-7890</span><br>
                Website: <a href="https://dpppa.manadokota.go.id/" target="_blank"
                    class="text-gray-300 hover:text-blue-500">dp3a.sulutprov.go.id</a>
            </address>
        </section>
    </div>

    <!-- Hak Cipta -->
    <div class="mt-8 border-t border-gray-600 pt-4 text-center">
        <p class="text-xs md:text-sm">&copy; 2025 DP3A Sulawesi Utara. Semua Hak Dilindungi Undang-Undang.</p>
    </div>
</footer>
