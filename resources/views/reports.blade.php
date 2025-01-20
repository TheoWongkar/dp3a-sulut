<x-guest-layout>

    <!-- Bagian Title -->
    <x-title :title=$title></x-title>

    <!-- Bagian Laporkan -->
    <section
        class="bg-[#E9F0FF] min-h-screen flex flex-col items-center justify-start pt-24 pb-10 px-4 md:px-8 lg:px-16 space-y-6">
        <div class="bg-white w-full max-w-6xl py-4 px-6 rounded-md">
            <h1 class="text-lg font-bold">LAPORAN KEKERASAN</h1>
        </div>
        <!-- Form Laporkan -->
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
                                    <option value="Kekerasan Fisik"
                                        {{ old('violence_category') == 'Kekerasan Fisik' ? 'selected' : '' }}>Kekerasan
                                        Fisik</option>
                                    <option value="Kekerasan Psikis"
                                        {{ old('violence_category') == 'Kekerasan Psikis' ? 'selected' : '' }}>Kekerasan
                                        Psikis</option>
                                    <option value="Kekerasan Seksual"
                                        {{ old('violence_category') == 'Kekerasan Seksual' ? 'selected' : '' }}>
                                        Kekerasan Seksual</option>
                                    <option value="Penelantaran Anak"
                                        {{ old('violence_category') == 'Penelantaran Anak' ? 'selected' : '' }}>
                                        Penelantaran Anak</option>
                                    <option value="Eksploitasi Anak"
                                        {{ old('violence_category') == 'Eksploitasi Anak' ? 'selected' : '' }}>
                                        Eksploitasi Anak</option>
                                </select>
                            </div>
                            <!-- Kronologi Insiden -->
                            <label for="chronology" class="block text-sm font-medium text-left">
                                Kronologi Insiden <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="chronology" name="chronology" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">{{ old('chronology') }}</textarea>
                            </div>
                            <!-- Tanggal Kejadian -->
                            <label for="date" class="block text-sm font-medium text-left">
                                Tanggal Kejadian <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="date" id="date" name="date" value="{{ old('date') }}"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Tempat Kejadian -->
                            <label for="scene" class="block text-sm font-medium text-left">
                                Tempat Kejadian <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="scene" name="scene" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">{{ old('scene') }}</textarea>
                            </div>
                            <!-- Bukti Pendukung -->
                            <label for="evidence" class="block text-sm font-medium text-left">
                                Bukti Pendukung
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
                                        <p class="inline text-gray-500 text-xl font-bold">Gambar</p>
                                        <p class="text-gray-500 font-semibold"
                                            x-text="files ? files[0].name : 'klik atau seret gambar'"></p>
                                        <p class="text-xs text-red-500 mt-1">JPG/JPEG/PNG</p>
                                        <p class="text-xs text-red-500 mt-1">Ukuran File 40 KB - 3072 KB</p>
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
                                    value="{{ old('victim_name') }}" placeholder="Masukkan nama korban"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Telepon Korban -->
                            <label for="victim_phone" class="block text-sm font-medium text-left">
                                No. Telepon Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="victim_phone" name="victim_phone"
                                    value="{{ old('victim_phone') }}" placeholder="08XXXXXXXXXX"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Alamat Korban -->
                            <label for="victim_address" class="block text-sm font-medium text-left">
                                Alamat Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="victim_address" name="victim_address" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">{{ old('victim_address') }}</textarea>
                            </div>
                            <!-- Usia Korban -->
                            <label for="victim_age" class="block text-sm font-medium text-left">
                                Usia Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="victim_age" name="victim_age"
                                    value="{{ old('victim_age') }}" placeholder="Masukkan usia korban"
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
                                    <option value="Pria" {{ old('victim_gender') == 'Pria' ? 'selected' : '' }}>Pria
                                    </option>
                                    <option value="Wanita" {{ old('victim_gender') == 'Wanita' ? 'selected' : '' }}>
                                        Wanita
                                    </option>
                                </select>
                            </div>
                            <!-- Deskripsi Tambahan Mengenai Korban -->
                            <label for="victim_description" class="block text-sm font-medium text-left">
                                Deskripsi Tambahan Mengenai Korban
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="victim_description" name="victim_description" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">{{ old('victim_description') }}</textarea>
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
                                    value="{{ old('perpetrator_name') }}" placeholder="Masukkan nama pelaku"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Usia Pelaku -->
                            <label for="perpetrator_age" class="block text-sm font-medium text-left">
                                Usia Pelaku
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="perpetrator_age" name="perpetrator_age"
                                    value="{{ old('perpetrator_age') }}" placeholder="Masukkan usia pelaku"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Jenis Kelamin Pelaku -->
                            <label for="perpetrator_gender" class="block text-sm font-medium text-left">
                                Jenis Kelamin Pelaku <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <select id="perpetrator_gender" name="perpetrator_gender"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                                    <option selected disabled>Pilih jenis kelamin pelaku</option>
                                    <option value="Pria"
                                        {{ old('perpetrator_gender') == 'Pria' ? 'selected' : '' }}>Pria
                                    </option>
                                    <option value="Wanita"
                                        {{ old('perpetrator_gender') == 'Wanita' ? 'selected' : '' }}>
                                        Wanita
                                    </option>
                                </select>
                            </div>
                            <!-- Deskripsi Tambahan Mengenai Pelaku -->
                            <label for="perpetrator_description" class="block text-sm font-medium text-left">
                                Deskripsi Tambahan Mengenai Pelaku
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="perpetrator_description" name="perpetrator_description" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">{{ old('perpetrator_description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Data Pelapor -->
                    <div x-cloak x-show="step === 4">
                        <h2 class="text-lg font-bold mb-6">Formulir Data Pelapor</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <!-- Nama Pelapor -->
                            <label for="reporter_name" class="block text-sm font-medium text-left">
                                Nama Pelapor
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="reporter_name" name="reporter_name"
                                    value="{{ old('reporter_name') }}" placeholder="Masukkan nama pelapor"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Telepon Pelapor -->
                            <label for="reporter_phone" class="block text-sm font-medium text-left">
                                No. Telepon
                            </label>
                            <div class="md:col-span-2">
                                <input type="text" id="reporter_phone" name="reporter_phone"
                                    value="{{ old('reporter_phone') }}" placeholder="08XXXXXXXXXX"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                            </div>
                            <!-- Alamat Pelapor -->
                            <label for="reporter_address" class="block text-sm font-medium text-left">
                                Alamat Pelapor
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="reporter_address" name="reporter_address" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">{{ old('reporter_address') }}</textarea>
                            </div>
                            <!-- Hubungan Pelapor Dengan Korban -->
                            <label for="reporter_relationship_between" class="block text-sm font-medium text-left">
                                Hubungan Dengan Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <select id="reporter_relationship_between" name="reporter_relationship_between"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF] focus:border-blue-400">
                                    <option selected disabled>Pilih hubungan pelaku dengan korban</option>
                                    <option value="Orang Tua"
                                        {{ old('reporter_relationship_between') == 'Orang Tua' ? 'selected' : '' }}>
                                        Orang Tua
                                    </option>
                                    <option value="Saudara"
                                        {{ old('reporter_relationship_between') == 'Saudara' ? 'selected' : '' }}>
                                        Saudara</option>
                                    <option value="Guru"
                                        {{ old('reporter_relationship_between') == 'Guru' ? 'selected' : '' }}>Guru
                                    </option>
                                    <option value="Teman"
                                        {{ old('reporter_relationship_between') == 'Teman' ? 'selected' : '' }}>
                                        Teman</option>
                                    <option value="Lainnya"
                                        {{ old('reporter_relationship_between') == 'Lainnya' ? 'selected' : '' }}>
                                        Lainnya</option>
                                </select>
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
