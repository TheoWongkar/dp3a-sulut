<x-guest-layout>

    <!-- Bagian Laporkan -->
    <section
        class="bg-[#E9F0FF] min-h-screen flex flex-col items-center justify-start pt-24 pb-10 px-4 md:px-8 lg:px-16 space-y-6">
        <div class="bg-white w-full max-w-6xl py-4 px-6 rounded-md">
            <h1 class="text-lg font-bold">LAPORAN KEKERASAN</h1>
        </div>

        <div class="bg-white w-full max-w-6xl p-8 rounded-md shadow-md" x-data="{ step: 1 }">
            <div>
                <form action="{{ route('reports.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Menampilkan Semua Pesan Error -->
                    @if ($errors->any())
                        <h3 class="text-red-500 font-semibold text-left">Mohon diperhatikan:</h3>
                        <div class="text-red-500 mb-4">
                            <ul class="list-inside list-disc text-left">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Step 1: Laporan Kekerasan -->
                    <div x-cloak x-show="step === 1">
                        <h2 class="text-lg font-bold mb-6">Formulir Laporan Kekerasan</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <!-- Jenis Kekerasan -->
                            <label for="violence_category" class="block text-sm font-medium text-left">
                                Jenis Kekerasan <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <select id="violence_category" name="violence_category"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                                    <option selected disabled>Pilih jenis kekerasan</option>
                                    <option value="Kekerasan Fisik">Kekerasan Fisik</option>
                                    <option value="Kekerasan Psikis">Kekerasan Psikis</option>
                                    <option value="Kekerasan Seksual">Kekerasan Seksual</option>
                                    <option value="Penelantaran Anak">Penelantaran Anak</option>
                                    <option value="Eksploitasi Anak">Eksploitasi Anak</option>
                                </select>
                            </div>
                            <!-- Deskripsi Insiden -->
                            <label for="description" class="block text-sm font-medium text-left">
                                Deskripsi Insiden <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="description" name="description" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400"></textarea>
                            </div>
                            <!-- Tanggal Kejadian -->
                            <label for="date" class="block text-sm font-medium text-left">
                                Tanggal Kejadian <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="date" id="date" name="date"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Tempat Kejadian -->
                            <label for="scene" class="block text-sm font-medium text-left">
                                Tempat Kejadian <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="scene" name="scene" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400"></textarea>
                            </div>
                            <!-- Bukti Pendukung -->
                            <label for="evidence" class="block text-sm font-medium text-left">
                                Bukti Pendukung <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-1 mb-5">
                                <div x-cloak x-data="{ files: null, isDropping: false, previewUrl: null }"
                                    class="border-4 p-6 text-center bg-white rounded-md"
                                    :class="{ 'border-blue-500': isDropping, 'border-[#DCE8FF]': !isDropping }"
                                    x-on:dragover.prevent="isDropping = true"
                                    x-on:dragleave.prevent="isDropping = false"
                                    x-on:drop.prevent="
                                        isDropping = false;
                                        files = $event.dataTransfer.files;
                                        previewUrl = URL.createObjectURL(files[0]);
                                    ">
                                    <input type="file" id="evidence" name="evidence" class="hidden"
                                        accept="image/png, image/jpeg, image/jpg" x-ref="file"
                                        x-on:change="
                                            files = $event.target.files;
                                            previewUrl = URL.createObjectURL(files[0]);
                                        ">
                                    <!-- Placeholder -->
                                    <div x-show="!previewUrl" x-on:click="$refs.file.click()"
                                        class="cursor-pointer inline">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-8 mx-auto text-gray-500 inline">
                                            <path fill-rule="evenodd"
                                                d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <p class="inline text-gray-500 text-xl font-bold">Image</p>
                                        <p class="text-gray-500 font-semibold"
                                            x-text="files ? files[0].name : 'Drop Image to Upload'"></p>
                                        <p class="text-xs text-red-500 mt-1">JPG/PNG</p>
                                        <p class="text-xs text-red-500 mt-1">Ukuran File 40 KB - 100 KB</p>
                                    </div>
                                    <!-- Image Preview -->
                                    <template x-if="previewUrl">
                                        <div class="mt-1">
                                            <p class="text-gray-500 font-semibold mb-1">Preview Gambar:</p>
                                            <img :src="previewUrl" alt="Image Preview"
                                                class="w-48 h-48 object-cover mx-auto rounded-md">
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Data Korban -->
                    <div x-cloak x-show="step === 2">
                        <h2 class="text-lg font-bold mb-6">Formulir Data Korban</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <!-- Nama Korban -->
                            <label for="victim_name" class="block text-sm font-medium text-left">
                                Nama Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="victim_name" name="victim_name"
                                    placeholder="Masukkan nama korban"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Usia Korban -->
                            <label for="victim_age" class="block text-sm font-medium text-left">
                                Usia Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="victim_age" name="victim_age"
                                    placeholder="Masukkan usia korban"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Jenis Kelamin Korban -->
                            <label for="victim_gender" class="block text-sm font-medium text-left">
                                Jenis Kelamin Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <select id="victim_gender" name="victim_gender"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                                    <option selected disabled>Pilih jenis kelamin korban</option>
                                    <option value="Pria">Pria</option>
                                    <option value="Wanita">Wanita</option>
                                </select>
                            </div>
                            <!-- Deskripsi Tambahan Mengenai Korban -->
                            <label for="victim_description" class="block text-sm font-medium text-left">
                                Deskripsi Tambahan Mengenai Korban
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="victim_description" name="victim_description" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Data Pelaku -->
                    <div x-cloak x-show="step === 3">
                        <h2 class="text-lg font-bold mb-6">Formulir Data Pelaku</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <!-- Nama Pelaku -->
                            <label for="perpetrator_name" class="block text-sm font-medium text-left">
                                Nama Pelaku
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="perpetrator_name" name="perpetrator_name"
                                    placeholder="Masukkan nama pelaku"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Usia Pelaku -->
                            <label for="perpetrator_age" class="block text-sm font-medium text-left">
                                Usia Pelaku
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="perpetrator_age" name="perpetrator_age"
                                    placeholder="Masukkan usia pelaku"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Hubungan Pelaku Dengan Korban -->
                            <label for="relationship_between" class="block text-sm font-medium text-left">
                                Hubungan Pelaku Dengan Korban
                            </label>
                            <div class="md:col-span-2">
                                <select id="relationship_between" name="relationship_between"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                                    <option selected>Pilih hubungan pelaku dengan korban</option>
                                    <option value="Orang Tua">Orang Tua</option>
                                    <option value="Saudara">Saudara</option>
                                    <option value="Guru">Guru</option>
                                    <option value="Teman">Teman</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                            </div>
                            <!-- Deskripsi Tambahan Mengenai Pelaku -->
                            <label for="perpetrator_description" class="block text-sm font-medium text-left">
                                Deskripsi Tambahan Mengenai Pelaku
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="perpetrator_description" name="perpetrator_description" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400"></textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Data Pelapor -->
                    <div x-cloak x-show="step === 4">
                        <h2 class="text-lg font-bold mb-6">Formulir Data Pelapor</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <!-- Whatsapp -->
                            <label for="reporter_whatsapp" class="block text-sm font-medium text-left">
                                Whatsapp
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="reporter_whatsapp" name="reporter_whatsapp"
                                    placeholder="08XXXXXXXXXX"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Telegram -->
                            <label for="reporter_telegram" class="block text-sm font-medium text-left">
                                Telegram
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="reporter_telegram" name="reporter_telegram"
                                    placeholder="08XXXXXXXXXX"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Instagram -->
                            <label for="reporter_instagram" class="block text-sm font-medium text-left">
                                Instagram
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="reporter_instagram" name="reporter_instagram"
                                    placeholder="@xxx123"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Email -->
                            <label for="reporter_email" class="block text-sm font-medium text-left">
                                Instagram
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="reporter_email" name="reporter_email"
                                    placeholder="xxxxx@email.com"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                        </div>
                    </div>

                    <!-- Step 5: Kirim Laporan -->
                    <div x-cloak x-show="step === 5">
                        <h2 class="text-lg font-bold mb-6">Formulir Laporan Kekerasan</h2>
                        <div class="text-sm md:text-lg">
                            <h3 class="font-bold text-center">Terima Kasih Telah Melakukan
                                Pelaporan!</h3>
                            <h3 class="font-bold text-center">Apakah Anda Yakin Ingin
                                Mengirimkan
                                Laporan Ini
                                Sekarang?</h3>
                        </div>
                    </div>

                    <!-- Navigation Buttons -->
                    <div class="flex justify-between mt-6 text-sm">
                        <button type="button" x-cloak x-show="step > 1 && step <= 4" @click="step--"
                            class="bg-gray-800 text-white py-2 px-6 rounded-md font-semibold hover:bg-gray-700 transition">
                            KEMBALI
                        </button>

                        <button type="button" x-cloak x-show="step <= 4" @click="step++"
                            class="bg-[#141652] text-white py-2 px-6 rounded-md font-semibold hover:bg-blue-900 transition">
                            SELANJUTNYA
                        </button>

                    </div>
                    <div class="flex items-center justify-center text-sm">
                        <button type="submit" x-cloak x-show="step === 5"
                            class="bg-[#141652] text-white py-2 px-6 rounded-md font-semibold hover:bg-blue-900 transition">
                            KIRIM LAPORAN
                        </button>
                    </div>

                    <p class="text-sm text-red-500 mt-4" x-cloak x-show="step <= 4">* Bertanda Pertanyaan yang wajib
                        diisi
                    </p>
                </form>
            </div>
        </div>
    </section>

</x-guest-layout>
