<x-guest-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Pesan Success -->
    <div x-data="{ open: @json(session('success') ? true : false) }">
        <div x-show="open" x-cloak class="fixed inset-0 bg-black/50 flex justify-center items-center z-10">
            <!-- Modal Content -->
            <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm text-center">
                <h2 class="text-xl font-bold">Laporan Berhasil Dikirim!</h2>
                <h3 class="mt-4 mb-1 text-md">Nomor tiket Anda:</h3>
                <input type="text" value="{{ session('success') }}" readonly
                    class="p-1 bg-[#E9F0FF] border rounded-lg text-center focus:outline-none">
                <p class="text-sm mt-4">Simpan nomor ini untuk memeriksa status laporan Anda.</p>

                <!-- Tombol Tutup -->
                <button @click="open = false"
                    class="mt-4 px-4 py-2 bg-green-700 text-white rounded-md hover:bg-green-800">
                    Tutup
                </button>
            </div>
        </div>
    </div>

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
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                    <option selected disabled>Pilih jenis kekerasan</option>
                                    @foreach (['Kekerasan Fisik', 'Kekerasan Psikis', 'Kekerasan Seksual', 'Penelantaran Anak', 'Eksploitasi Anak'] as $category)
                                        <option value="{{ $category }}"
                                            {{ old('violence_category') == $category ? 'selected' : '' }}>
                                            {{ $category }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('violence_category')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Tanggal Kejadian -->
                            <label for="date" class="block text-sm font-medium text-left">
                                Tanggal Kejadian <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="date" id="date" name="date" value="{{ old('date') }}"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                @error('date')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Detail Tempat Kejadian -->
                            <label for="scene" class="block text-sm font-medium text-left">
                                Detail Tempat Kejadian <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="scene" name="scene" rows="4" class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">{{ old('scene') }}</textarea>
                                @error('scene')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Bukti Pendukung -->
                            <label for="evidence" class="block text-sm font-medium text-left">Bukti Pendukung</label>
                            <div class="md:col-span-1 mb-5">
                                <div x-data="{ files: null, previewUrl: null }"
                                    class="border-4 p-6 text-center bg-white rounded-md border-[#DCE8FF]"
                                    x-on:dragover.prevent="isDropping = true"
                                    x-on:dragleave.prevent="isDropping = false"
                                    x-on:drop.prevent="files = $event.dataTransfer.files; previewUrl = URL.createObjectURL(files[0]);">
                                    <input type="file" id="evidence" name="evidence" class="hidden"
                                        accept="image/png, image/jpeg, image/jpg" x-ref="file"
                                        x-on:change="files = $event.target.files; previewUrl = URL.createObjectURL(files[0]);">
                                    <div x-show="!previewUrl" x-on:click="$refs.file.click()"
                                        class="cursor-pointer inline">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                            class="size-8 mx-auto text-gray-500">
                                            <path fill-rule="evenodd"
                                                d="M1.5 6a2.25 2.25 0 0 1 2.25-2.25h16.5A2.25 2.25 0 0 1 22.5 6v12a2.25 2.25 0 0 1-2.25 2.25H3.75A2.25 2.25 0 0 1 1.5 18V6ZM3 16.06V18c0 .414.336.75.75.75h16.5A.75.75 0 0 0 21 18v-1.94l-2.69-2.689a1.5 1.5 0 0 0-2.12 0l-.88.879.97.97a.75.75 0 1 1-1.06 1.06l-5.16-5.159a1.5 1.5 0 0 0-2.12 0L3 16.061Zm10.125-7.81a1.125 1.125 0 1 1 2.25 0 1.125 1.125 0 0 1-2.25 0Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                        <p class="text-gray-500 text-xl font-bold">Gambar</p>
                                        <p class="text-gray-500 font-semibold"
                                            x-text="files ? files[0].name : 'Klik atau seret gambar'"></p>
                                        <p class="text-xs text-red-500 mt-1">JPG/JPEG/PNG</p>
                                        <p class="text-xs text-red-500 mt-1">Ukuran File 40 KB - 3072 KB</p>
                                    </div>
                                    <template x-if="previewUrl">
                                        <div class="mt-1">
                                            <p class="text-gray-500 font-semibold mb-1">Preview Gambar:</p>
                                            <img :src="previewUrl" alt="Image Preview"
                                                class="w-48 h-48 object-cover mx-auto rounded-md">
                                        </div>
                                    </template>
                                </div>
                                @error('evidence')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
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
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                @error('victim_name')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telepon Korban -->
                            <label for="victim_phone" class="block text-sm font-medium text-left">
                                No. Telepon Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <input type="number" id="victim_phone" name="victim_phone"
                                    value="{{ old('victim_phone') }}" placeholder="08XXXXXXXXXX"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                @error('victim_phone')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin Korban -->
                            <label for="victim_gender" class="block text-sm font-medium text-left">
                                Jenis Kelamin Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <select id="victim_gender" name="victim_gender"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                    <option selected disabled>Pilih jenis kelamin korban</option>
                                    <option value="Pria" {{ old('victim_gender') == 'Pria' ? 'selected' : '' }}>Pria
                                    </option>
                                    <option value="Wanita" {{ old('victim_gender') == 'Wanita' ? 'selected' : '' }}>
                                        Wanita</option>
                                </select>
                                @error('victim_gender')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi Tambahan Mengenai Korban -->
                            <label for="victim_description" class="block text-sm font-medium text-left">
                                Deskripsi Tambahan Mengenai Korban
                            </label>
                            <div class="md:col-span-2">
                                <textarea id="victim_description" name="victim_description" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">{{ old('victim_description') }}</textarea>
                                @error('victim_description')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 3: Data Pelaku -->
                    <div x-cloak x-show="step === 3">
                        <h2 class="text-lg font-bold mb-6">Formulir Data Pelaku</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
                            <!-- Nama Pelaku -->
                            <label for="perpetrator_name" class="block text-sm font-medium text-left">Nama
                                Pelaku</label>
                            <div class="md:col-span-2">
                                <input type="text" id="perpetrator_name" name="perpetrator_name"
                                    value="{{ old('perpetrator_name') }}" placeholder="Masukkan nama pelaku"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                @error('perpetrator_name')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin Pelaku -->
                            <label for="perpetrator_gender" class="block text-sm font-medium text-left">Jenis Kelamin
                                Pelaku <span class="text-red-500">*</span></label>
                            <div class="md:col-span-2">
                                <select id="perpetrator_gender" name="perpetrator_gender"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                    <option selected disabled>Pilih jenis kelamin pelaku</option>
                                    <option value="Pria"
                                        {{ old('perpetrator_gender') == 'Pria' ? 'selected' : '' }}>Pria</option>
                                    <option value="Wanita"
                                        {{ old('perpetrator_gender') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                                </select>
                                @error('perpetrator_gender')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Deskripsi Tambahan Mengenai Pelaku -->
                            <label for="perpetrator_description" class="block text-sm font-medium text-left">Deskripsi
                                Tambahan Mengenai Pelaku</label>
                            <div class="md:col-span-2">
                                <textarea id="perpetrator_description" name="perpetrator_description" rows="4"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">{{ old('perpetrator_description') }}</textarea>
                                @error('perpetrator_description')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Step 4: Data Pelapor -->
                    <div x-cloak x-show="step === 4">
                        <h2 class="text-lg font-bold mb-6">Formulir Data Pelapor</h2>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">

                            <!-- Nama Pelapor -->
                            <label for="reporter_name" class="block text-sm font-medium">Nama Pelapor <span
                                    class="text-red-500">*</span></label>
                            <div class="md:col-span-2">
                                <input type="text" id="reporter_name" name="reporter_name"
                                    value="{{ old('reporter_name') }}" placeholder="Masukkan nama pelapor"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                @error('reporter_name')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Telepon Pelapor -->
                            <label for="reporter_phone" class="block text-sm font-medium">No. Telepon Pelapor <span
                                    class="text-red-500">*</span></label>
                            <div class="md:col-span-2">
                                <input type="number" id="reporter_phone" name="reporter_phone"
                                    value="{{ old('reporter_phone') }}" placeholder="08XXXXXXXXXX"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                @error('reporter_phone')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Jenis Kelamin Pelapor -->
                            <label for="reporter_gender" class="block text-sm font-medium text-left">Jenis Kelamin
                                Pelapor <span class="text-red-500">*</span></label>
                            <div class="md:col-span-2">
                                <select id="reporter_gender" name="reporter_gender"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                    <option selected disabled>Pilih jenis kelamin Pelapor</option>
                                    <option value="Pria" {{ old('reporter_gender') == 'Pria' ? 'selected' : '' }}>
                                        Pria</option>
                                    <option value="Wanita" {{ old('reporter_gender') == 'Wanita' ? 'selected' : '' }}>
                                        Wanita</option>
                                </select>
                                @error('reporter_gender')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Hubungan Pelapor Dengan Korban -->
                            <label for="reporter_relationship_between" class="block text-sm font-medium">
                                Hubungan Dengan Korban <span class="text-red-500">*</span>
                            </label>
                            <div class="md:col-span-2">
                                <select id="reporter_relationship_between" name="reporter_relationship_between"
                                    class="w-full p-2 bg-[#DCE8FF] rounded-lg border-[#DCE8FF]">
                                    <option selected disabled>Pilih hubungan pelapor dengan korban</option>
                                    @foreach (['Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya'] as $option)
                                        <option value="{{ $option }}"
                                            {{ old('reporter_relationship_between') == $option ? 'selected' : '' }}>
                                            {{ $option }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('reporter_relationship_between')
                                    <p class="text-red-500 text-sm">{{ $message }}</p>
                                @enderror
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
                            aria-label="Tombol Kembali"
                            class="bg-gray-800 text-white py-2 px-6 rounded-md font-semibold hover:bg-gray-700 transition">
                            KEMBALI
                        </button>

                        <button type="button" x-cloak x-show="step <= 4" @click="step++"
                            aria-label="Tombol Kembali"
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
