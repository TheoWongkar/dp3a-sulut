<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <section>
        <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
            <!-- Pesan Berhasil -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 rounded relative mb-3"
                    role="alert">
                    <h3 class="mb-1 font-bold text-md sm:text-lg">Laporan Berhasil Dikirim!</h3>
                    <p class="text-sm sm:text-sn">Nomor tiket Anda:
                        <span class="font-bold text-sm sm:text-sm">{{ session('success') }}</span>
                    </p>
                    <p class="text-xs">Simpan nomor ini untuk memeriksa status laporan Anda.</p>
                </div>
            @elseif (session('error'))
                <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 rounded relative mb-3" role="alert">
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Form Tambah Laporan -->
            <form action="{{ route('dashboard.reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Informasi Laporan -->
                <h2 class="text-lg font-semibold mb-4 text-black">Formulir Laporan Kekerasan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-black">
                    <div>
                        <label for="violence_category" class="block text-sm font-medium text-gray-700">Jenis Kekerasan
                            <span class="text-red-500">*</span></label>
                        <select id="violence_category" name="violence_category"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option selected disabled>Pilih</option>
                            <option value="Kekerasan Fisik"
                                {{ old('violence_category') == 'Kekerasan Fisik' ? 'selected' : '' }}>Kekerasan Fisik
                            </option>
                            <option value="Kekerasan Psikis"
                                {{ old('violence_category') == 'Kekerasan Psikis' ? 'selected' : '' }}>Kekerasan Psikis
                            </option>
                            <option value="Kekerasan Seksual"
                                {{ old('violence_category') == 'Kekerasan Seksual' ? 'selected' : '' }}>Kekerasan
                                Seksual</option>
                            <option value="Penelantaran Anak"
                                {{ old('violence_category') == 'Penelantaran Anak' ? 'selected' : '' }}>Penelantaran
                                Anak</option>
                            <option value="Eksploitasi Anak"
                                {{ old('violence_category') == 'Eksploitasi Anak' ? 'selected' : '' }}>Eksploitasi Anak
                            </option>
                        </select>
                        @error('violence_category')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Tanggal Kejadian <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="date" name="date"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            value="{{ old('date') }}">
                        @error('date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="chronology" class="block text-sm font-medium text-gray-700">Kronologi Insiden<span
                                class="text-red-500">*</span></label>
                        <textarea id="chronology" name="chronology" rows="4"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan kronologi kejadian">{{ old('chronology') }}</textarea>
                        @error('chronology')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="scene" class="block text-sm font-medium text-gray-700">Tempat Kejadian <span
                                class="text-red-500">*</span></label>
                        <textarea id="scene" name="scene" rows="4"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan tempat kejadian">{{ old('scene') }}</textarea>
                        @error('scene')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <!-- Gambar -->
                    <div x-data="{ imagePreview: null }">
                        <label for="evidence" class="block text-sm font-medium">Bukti (Opsional)</label>
                        <input id="evidence" type="file" name="evidence"
                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm file:mr-2 file:py-1.5 file:px-4 file:border-0 file:text-sm file:bg-gray-800 file:text-white hover:file:bg-gray-700 transition ease-in-out duration-200"
                            @change="if ($event.target.files.length) { 
                                    const file = $event.target.files[0]; 
                                    const reader = new FileReader(); 
                                    reader.onload = (e) => { imagePreview = e.target.result; }; 
                                    reader.readAsDataURL(file); 
                                } else { imagePreview = null; }">
                        <!-- Preview Gambar -->
                        <div class="mt-4" x-show="imagePreview" style="display: none;">
                            <div class="overflow-auto max-w-full h-64 rounded-md shadow-md border border-gray-300">
                                <img :src="imagePreview" class="w-full h-auto" alt="Image Preview">
                            </div>
                        </div>
                        @error('evidence')
                            <p class="text-red-500 text-md mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Korban -->
                <h2 class="text-lg font-semibold mb-4 text-black">Informasi Korban</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-black">
                    <div>
                        <label for="victim_name" class="block text-sm font-medium text-gray-700">Nama Korban <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="victim_name" name="victim_name"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan nama korban" value="{{ old('victim_name') }}">
                        @error('victim_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="victim_age" class="block text-sm font-medium text-gray-700">Usia Korban <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="victim_age" name="victim_age"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan usia korban" value="{{ old('victim_age') }}">
                        @error('victim_age')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="victim_gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin <span
                                class="text-red-500">*</span></label>
                        <select id="victim_gender" name="victim_gender"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option selected disabled>Pilih</option>
                            <option value="Pria" {{ old('victim_gender') == 'Pria' ? 'selected' : '' }}>Pria</option>
                            <option value="Wanita" {{ old('victim_gender') == 'Wanita' ? 'selected' : '' }}>Wanita
                            </option>
                        </select>
                        @error('victim_gender')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="victim_phone" class="block text-sm font-medium text-gray-700">Nomor Telepon <span
                                class="text-red-500">*</span></label>
                        <input type="number" id="victim_phone" name="victim_phone"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan nomor telepon korban" value="{{ old('victim_phone') }}">
                        @error('victim_phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="victim_address" class="block text-sm font-medium text-gray-700">Alamat Korban
                            <span class="text-red-500">*</span></label>
                        <textarea id="victim_address" name="victim_address" rows="3"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan alamat korban">{{ old('victim_address') }}</textarea>
                        @error('victim_address')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="victim_description" class="block text-sm font-medium text-gray-700">Deskripsi
                            (Opsional)</label>
                        <textarea id="victim_description" name="victim_description" rows="3"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan deskripsi tambahan">{{ old('victim_description') }}</textarea>
                        @error('victim_description')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Pelaku -->
                <h2 class="text-lg font-semibold mb-4 text-black">Informasi Pelaku</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-black">
                    <div>
                        <label for="perpetrator_name" class="block text-sm font-medium text-gray-700">Nama
                            Pelaku</label>
                        <input type="text" id="perpetrator_name" name="perpetrator_name"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan nama pelaku" value="{{ old('perpetrator_name') }}">
                        @error('perpetrator_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="perpetrator_age" class="block text-sm font-medium text-gray-700">Usia
                            Pelaku</label>
                        <input type="number" id="perpetrator_age" name="perpetrator_age"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan usia pelaku" value="{{ old('perpetrator_age') }}">
                        @error('perpetrator_age')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="perpetrator_gender" class="block text-sm font-medium text-gray-700">Jenis Kelamin
                            <span class="text-red-500">*</span></label>
                        <select id="perpetrator_gender" name="perpetrator_gender"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option selected disabled>Pilih</option>
                            <option value="Pria" {{ old('perpetrator_gender') == 'Pria' ? 'selected' : '' }}>Pria
                            </option>
                            <option value="Wanita" {{ old('perpetrator_gender') == 'Wanita' ? 'selected' : '' }}>
                                Wanita</option>
                        </select>
                        @error('perpetrator_gender')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="perpetrator_description" class="block text-sm font-medium text-gray-700">Deskripsi
                            (Opsional)</label>
                        <textarea id="perpetrator_description" name="perpetrator_description" rows="3"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan deskripsi tambahan">{{ old('perpetrator_description') }}</textarea>
                        @error('perpetrator_description')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Pelapor -->
                <h2 class="text-lg font-semibold mb-4">Informasi Pelapor</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div>
                        <label for="reporter_name" class="block text-sm font-medium text-gray-700">Nama
                            Pelapor</label>
                        <input type="text" id="reporter_name" name="reporter_name"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan nama pelapor" value="{{ old('reporter_name') }}">
                        @error('reporter_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="reporter_phone" class="block text-sm font-medium text-gray-700">Nomor
                            Telepon</label>
                        <input type="number" id="reporter_phone" name="reporter_phone"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan nomor telepon pelapor" value="{{ old('reporter_phone') }}">
                        @error('reporter_phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="reporter_address" class="block text-sm font-medium text-gray-700">Alamat
                            Pelapor</label>
                        <textarea id="reporter_address" name="reporter_address" rows="3"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            placeholder="Masukkan alamat pelapor">{{ old('reporter_address') }}</textarea>
                        @error('reporter_address')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label for="reporter_relationship_between"
                            class="block text-sm font-medium text-gray-700">Hubungan dengan Korban <span
                                class="text-red-500">*</span></label>
                        <select id="reporter_relationship_between" name="reporter_relationship_between"
                            class="mt-1 p-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option selected disabled>Pilih</option>
                            <option value="Orang Tua"
                                {{ old('reporter_relationship_between') == 'Orang Tua' ? 'selected' : '' }}>Orang Tua
                            </option>
                            <option value="Saudara"
                                {{ old('reporter_relationship_between') == 'Saudara' ? 'selected' : '' }}>Saudara
                            </option>
                            <option value="Guru"
                                {{ old('reporter_relationship_between') == 'Guru' ? 'selected' : '' }}>Guru</option>
                            <option value="Teman"
                                {{ old('reporter_relationship_between') == 'Teman' ? 'selected' : '' }}>Teman</option>
                            <option value="Lainnya"
                                {{ old('reporter_relationship_between') == 'Lainnya' ? 'selected' : '' }}>Lainnya
                            </option>
                        </select>
                        @error('reporter_relationship_between')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Kembali & Simpan -->
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('dashboard.reports.create') }}"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition duration-200 uppercase">
                        Kembali
                    </a>
                    <button type="submit"
                        class="bg-green-700 hover:bg-green-800 text-white px-6 py-2 rounded-lg transition duration-200 uppercase">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>

</x-app-layout>
