<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Script Tambahan -->
    <x-slot name="script">
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    </x-slot>

    <section>
        <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">

            <!-- Bagian Pesan Success -->
            <div x-data="{ open: @json(session('success') ? true : false) }">
                <div x-show="open" x-cloak class="fixed inset-0 bg-black/50 flex justify-center items-center z-10">
                    <!-- Modal Content -->
                    <div class="bg-white p-6 rounded-lg shadow-lg max-w-sm text-center">
                        <h2 class="text-xl font-bold">Laporan Berhasil Dikirim!</h2>
                        <h3 class="mt-4 mb-1 text-md">Nomor tiket Anda</h3>
                        <input type="text" value="{{ session('success') }}" readonly
                            class="p-1 bg-[#E9F0FF] border rounded-lg text-center focus:outline-none">
                        <p class="text-sm mt-4">Simpan dan berikan nomor ini kepada pelapor untuk memeriksa status
                            laporan Anda.</p>

                        <!-- Tombol Tutup -->
                        <button @click="open = false"
                            class="mt-4 px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-800">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Laporan -->
            <form action="{{ route('dashboard.reports.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Informasi Laporan -->
                <div class="border-b mb-6">
                    <h2 class="text-xl font-semibold mb-2 text-black">Formulir Laporan Kekerasan</h2>
                </div>

                <h2 class="text-lg font-semibold mb-4 text-black">Informasi Laporan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-black">

                    <!-- Jenis Kekerasan -->
                    <div>
                        <label for="violence_category" class="text-sm font-medium text-black">Jenis Kekerasan<span
                                class="ml-1 text-red-500">*</span></label>
                        <select id="violence_category" name="violence_category"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            <option selected disabled>Pilih jenis kekerasan</option>
                            @foreach (['Kekerasan Fisik', 'Kekerasan Psikis', 'Kekerasan Seksual', 'Penelantaran Anak', 'Eksploitasi Anak'] as $category)
                                <option value="{{ $category }}"
                                    {{ old('violence_category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        @error('violence_category')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Kejadian -->
                    <div>
                        <label for="date" class="text-sm font-medium text-black">Tanggal Kejadian<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="date" id="date" name="date"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            value="{{ old('date') }}">
                        @error('date')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tempat Kejadian -->
                    <div>
                        <label for="regency" class="text-sm font-medium text-black">Kota/Kabupaten<span
                                class="ml-1 text-red-500">*</span></label>
                        <!-- Kabupaten/Kota -->
                        <select id="regency" name="regency"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            <option selected disabled>Pilih Kota/Kabupaten</option>
                        </select>
                        @error('regency')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tempat Kejadian -->
                    <div>
                        <label for="regency" class="text-sm font-medium text-black">Kecamatan<span
                                class="ml-1 text-red-500">*</span></label>
                        <!-- Kecamatan -->
                        <select id="district" name="district"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            <option selected disabled>Pilih Kecamatan</option>
                        </select>
                        @error('district')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Detail Tempat Kejadian -->
                    <div class="md:col-span-2">
                        <label for="scene" class="text-sm font-medium text-black">Detail Tempat Kejadian<span
                                class="ml-1 text-red-500">*</span></label>
                        <textarea id="scene" name="scene" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan detail tempat kejadian">{{ old('scene') }}</textarea>
                        @error('scene')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kronologi Kejadian -->
                    <div class="md:col-span-2">
                        <label for="chronology" class="text-sm font-medium text-black">Kronologi Kejadian<span
                                class="ml-1 text-red-500">*</span></label>
                        <textarea id="chronology" name="chronology" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan kronologi kejadian">{{ old('chronology') }}</textarea>
                        @error('chronology')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bukti Pendukung -->
                    <div x-data="{ imagePreview: null }">
                        <label for="evidence" class="block text-sm font-medium">Bukti Pendukung (Opsional)</label>
                        <input id="evidence" type="file" name="evidence" accept="image/png, image/jpeg"
                            class="mt-1 w-full border border-gray-200 rounded-md shadow-sm focus:outline-black file:mr-4 file:py-2 file:px-4 file:text-sm file:bg-gray-700 file:text-white hover:file:bg-gray-800"
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

                    <!-- NIK Korban -->
                    <div>
                        <label for="victim_nik" class="text-sm font-medium text-black">NIK Korban</label>
                        <input type="number" id="victim_nik" name="victim_nik"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nik korban" value="{{ old('victim_nik') }}">
                        @error('victim_nik')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Korban -->
                    <div>
                        <label for="victim_name" class="text-sm font-medium text-black">Nama Korban<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="text" id="victim_name" name="victim_name"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nama korban" value="{{ old('victim_name') }}">
                        @error('victim_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usia Korban -->
                    <div>
                        <label for="victim_age" class="text-sm font-medium text-black">Usia Korban</label>
                        <input type="number" id="victim_age" name="victim_age"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan usia korban" value="{{ old('victim_age') }}">
                        @error('victim_age')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin Korban -->
                    <div>
                        <label for="victim_gender" class="text-sm font-medium text-black">Jenis Kelamin
                            Korban<span class="ml-1 text-red-500">*</span></label>
                        <select id="victim_gender" name="victim_gender"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            <option selected disabled>Pilih jenis kelamin korban</option>
                            <option value="Pria" {{ old('victim_gender') == 'Pria' ? 'selected' : '' }}>Pria
                            </option>
                            <option value="Wanita" {{ old('victim_gender') == 'Wanita' ? 'selected' : '' }}>Wanita
                            </option>
                        </select>
                        @error('victim_gender')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon Korban -->
                    <div>
                        <label for="victim_phone" class="text-sm font-medium text-black">Nomor Telepon
                            Korban<span class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="victim_phone" name="victim_phone"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nomor telepon korban" value="{{ old('victim_phone') }}">
                        @error('victim_phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>

                    <!-- Alamat Korban -->
                    <div>
                        <label for="victim_address" class="text-sm font-medium text-black">Alamat Korban
                        </label>
                        <textarea id="victim_address" name="victim_address" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan alamat korban">{{ old('victim_address') }}</textarea>
                        @error('victim_address')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Korban -->
                    <div>
                        <label for="victim_description" class="text-sm font-medium text-black">Deskripsi
                            Korban</label>
                        <textarea id="victim_description" name="victim_description" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan deskripsi tambahan">{{ old('victim_description') }}</textarea>
                        @error('victim_description')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Terduga -->
                <h2 class="text-lg font-semibold mb-4 text-black">Informasi Terduga</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-black">

                    <!-- NIK Terduga -->
                    <div>
                        <label for="suspect_nik" class="text-sm font-medium text-black">NIK Terduga</label>
                        <input type="number" id="suspect_nik" name="suspect_nik"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nik terduga" value="{{ old('suspect_nik') }}">
                        @error('suspect_nik')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Terduga -->
                    <div>
                        <label for="suspect_name" class="text-sm font-medium text-black">Nama Terduga</label>
                        <input type="text" id="suspect_name" name="suspect_name"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nama terduga" value="{{ old('suspect_name') }}">
                        @error('suspect_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usia Terduga -->
                    <div>
                        <label for="suspect_age" class="text-sm font-medium text-black">Usia Terduga</label>
                        <input type="number" id="suspect_age" name="suspect_age"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan usia terduga" value="{{ old('suspect_age') }}">
                        @error('suspect_age')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin Terduga -->
                    <div>
                        <label for="suspect_gender" class="text-sm font-medium text-black">Jenis Kelamin
                            Terduga<span class="ml-1 text-red-500">*</span></label>
                        <select id="suspect_gender" name="suspect_gender"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            <option selected disabled>Pilih jenis kelamin terduga</option>
                            <option value="Pria" {{ old('suspect_gender') == 'Pria' ? 'selected' : '' }}>Pria
                            </option>
                            <option value="Wanita" {{ old('suspect_gender') == 'Wanita' ? 'selected' : '' }}>Wanita
                            </option>
                        </select>
                        @error('suspect_gender')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon Terduga -->
                    <div>
                        <label for="suspect_phone" class="text-sm font-medium text-black">Nomor Telepon
                            Terduga</label>
                        <input type="number" id="suspect_phone" name="suspect_phone"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nomor telepon terduga" value="{{ old('suspect_phone') }}">
                        @error('suspect_phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>

                    <!-- Alamat Terduga -->
                    <div>
                        <label for="suspect_address" class="text-sm font-medium text-black">Alamat Terduga</label>
                        <textarea id="suspect_address" name="suspect_address" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan alamat terduga">{{ old('suspect_address') }}</textarea>
                        @error('suspect_address')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Deskripsi Terduga -->
                    <div>
                        <label for="suspect_description" class="text-sm font-medium text-black">Deskripsi
                            Terduga</label>
                        <textarea id="suspect_description" name="suspect_description" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan deskripsi tambahan">{{ old('suspect_description') }}</textarea>
                        @error('suspect_description')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Informasi Pelapor -->
                <h2 class="text-lg font-semibold mb-4 text-black">Informasi Pelapor</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6 text-black">

                    <!-- NIK Pelapor -->
                    <div>
                        <label for="reporter_nik" class="text-sm font-medium text-black">NIK Pelapor</label>
                        <input type="number" id="reporter_nik" name="reporter_nik"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nik pelapor" value="{{ old('reporter_nik') }}">
                        @error('reporter_nik')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Pelapor -->
                    <div>
                        <label for="reporter_name" class="text-sm font-medium text-black">Nama Pelapor<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="text" id="reporter_name" name="reporter_name"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nama pelapor" value="{{ old('reporter_name') }}">
                        @error('reporter_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usia Pelapor -->
                    <div>
                        <label for="reporter_age" class="text-sm font-medium text-black">Usia Pelapor<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="reporter_age" name="reporter_age"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan usia pelapor" value="{{ old('reporter_age') }}">
                        @error('reporter_age')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Kelamin Pelapor -->
                    <div>
                        <label for="reporter_gender" class="text-sm font-medium text-black">Jenis Kelamin
                            Pelapor<span class="ml-1 text-red-500">*</span></label>
                        <select id="reporter_gender" name="reporter_gender"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            <option selected disabled>Pilih jenis kelamin pelapor</option>
                            <option value="Pria" {{ old('reporter_gender') == 'Pria' ? 'selected' : '' }}>Pria
                            </option>
                            <option value="Wanita" {{ old('reporter_gender') == 'Wanita' ? 'selected' : '' }}>Wanita
                            </option>
                        </select>
                        @error('reporter_gender')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon Pelapor -->
                    <div>
                        <label for="reporter_phone" class="text-sm font-medium text-black">Nomor Telepon
                            Pelapor<span class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="reporter_phone" name="reporter_phone"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nomor telepon pelapor" value="{{ old('reporter_phone') }}">
                        @error('reporter_phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Hubungan Dengan Pelapor -->
                    <div>
                        <label for="reporter_relationship_between" class="text-sm font-medium text-black">Hubungan
                            Dengan
                            Korban<span class="ml-1 text-red-500">*</span></label>
                        <select id="reporter_relationship_between" name="reporter_relationship_between"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            <option selected disabled>Pilih hubungan pelapor dengan korban</option>
                            @foreach (['Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya'] as $option)
                                <option value="{{ $option }}"
                                    {{ old('reporter_relationship_between') == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                        @error('reporter_relationship_between')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Alamat Pelapor -->
                    <div>
                        <label for="reporter_address" class="text-sm font-medium text-black">Alamat Pelapor<span
                                class="ml-1 text-red-500">*</span></label>
                        <textarea id="reporter_address" name="reporter_address" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan alamat pelapor">{{ old('reporter_address') }}</textarea>
                        @error('reporter_address')
                            <p class="text-sm text-red-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Tombol Batal & Simpan -->
                <div class="flex justify-end space-x-2">
                    <button type="submit" class="bg-green-700 text-white py-2 px-6 rounded-md hover:bg-green-800">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            let oldRegency = "{{ old('regency') }}";
            let oldDistrict = "{{ old('district') }}";

            // Load Kabupaten/Kota
            $.getJSON("https://ibnux.github.io/data-indonesia/kabupaten/71.json", function(data) {
                // Urutkan data berdasarkan nama
                data.sort((a, b) => a.nama.localeCompare(b.nama));

                $.each(data, function(index, item) {
                    let formattedName = capitalizeEachWord(item.nama);
                    let selected = item.id == oldRegency ? "selected" : "";
                    $("#regency").append(
                        `<option value="${item.id}" ${selected}>${formattedName}</option>`);
                });

                if (oldRegency) {
                    $("#regency").trigger("change");
                }
            });

            // Load Kecamatan
            $("#regency").change(function() {
                var regencyId = $(this).val();
                $("#district").empty().append(`<option selected disabled>Pilih Kecamatan</option>`);

                $.getJSON(`https://ibnux.github.io/data-indonesia/kecamatan/${regencyId}.json`, function(
                    data) {
                    // Urutkan data berdasarkan nama
                    data.sort((a, b) => a.nama.localeCompare(b.nama));

                    $.each(data, function(index, item) {
                        let formattedName = capitalizeEachWord(item.nama);
                        let selected = item.id == oldDistrict ? "selected" : "";
                        $("#district").append(
                            `<option value="${item.id}" ${selected}>${formattedName}</option>`
                        );
                    });
                });
            });

            // Ubah teks menjadi Capital Each Word
            function capitalizeEachWord(text) {
                return text.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
            }
        });
    </script>

</x-app-layout>
