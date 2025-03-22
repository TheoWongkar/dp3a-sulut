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

            <!-- Form Tambah Laporan -->
            <form action="{{ route('dashboard.reports.update', $report->ticket_number) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Informasi Laporan -->
                <div class="border-b mb-6">
                    <h2 class="text-xl font-semibold mb-2 text-black">Formulir Laporan Kekerasan</h2>
                </div>

                <!-- Pesan Status -->
                @if (session('success'))
                    <div class="bg-green-100 border border-green-500 text-green-800 px-4 py-3 rounded relative mb-3">
                        {{ session('success') }}</div>
                @elseif (session('error'))
                    <div class="bg-red-100 border border-red-500 text-red-800 px-4 py-3 rounded relative mb-3">
                        {{ session('error') }}</div>
                @endif

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
                                    {{ old('violence_category', $report->violence_category) == $category ? 'selected' : '' }}>
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
                            value="{{ old('date', $report->date) }}">
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
                            placeholder="Masukkan detail tempat kejadian">{{ old('scene', $report->scene) }}</textarea>
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
                            placeholder="Masukkan kronologi kejadian">{{ old('chronology', $report->chronology) }}</textarea>
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
                        <label for="victim_nik" class="text-sm font-medium text-black">NIK Korban<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="victim_nik" name="victim_nik"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nik korban" value="{{ old('victim_nik', $report->victim->nik) }}">
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
                            placeholder="Masukkan nama korban" value="{{ old('victim_name', $report->victim->name) }}">
                        @error('victim_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usia Korban -->
                    <div>
                        <label for="victim_age" class="text-sm font-medium text-black">Usia Korban<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="victim_age" name="victim_age"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan usia korban" value="{{ old('victim_age', $report->victim->age) }}">
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
                            <option value="Pria"
                                {{ old('victim_gender', $report->victim->gender) == 'Pria' ? 'selected' : '' }}>Pria
                            </option>
                            <option value="Wanita"
                                {{ old('victim_gender', $report->victim->gender) == 'Wanita' ? 'selected' : '' }}>
                                Wanita
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
                            placeholder="Masukkan nomor telepon korban"
                            value="{{ old('victim_phone', $report->victim->phone) }}">
                        @error('victim_phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>

                    <!-- Alamat Korban -->
                    <div>
                        <label for="victim_address" class="text-sm font-medium text-black">Alamat Korban<span
                                class="ml-1 text-red-500">*</span>
                        </label>
                        <textarea id="victim_address" name="victim_address" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan alamat korban">{{ old('victim_address', $report->victim->address) }}</textarea>
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
                            placeholder="Masukkan deskripsi tambahan">{{ old('victim_description', $report->victim->description) }}</textarea>
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
                        <label for="suspect_nik" class="text-sm font-medium text-black">NIK Terduga<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="suspect_nik" name="suspect_nik"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nik terduga"
                            value="{{ old('suspect_nik', $report->suspect->nik) }}">
                        @error('suspect_nik')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Terduga -->
                    <div>
                        <label for="suspect_name" class="text-sm font-medium text-black">Nama Terduga<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="text" id="suspect_name" name="suspect_name"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nama terduga"
                            value="{{ old('suspect_name', $report->suspect->name) }}">
                        @error('suspect_name')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Usia Terduga -->
                    <div>
                        <label for="suspect_age" class="text-sm font-medium text-black">Usia Terduga<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="suspect_age" name="suspect_age"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan usia terduga"
                            value="{{ old('suspect_age', $report->suspect->age) }}">
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
                            <option value="Pria"
                                {{ old('suspect_gender', $report->suspect->gender) == 'Pria' ? 'selected' : '' }}>Pria
                            </option>
                            <option value="Wanita"
                                {{ old('suspect_gender', $report->suspect->gender) == 'Wanita' ? 'selected' : '' }}>
                                Wanita
                            </option>
                        </select>
                        @error('suspect_gender')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon Terduga -->
                    <div>
                        <label for="suspect_phone" class="text-sm font-medium text-black">Nomor Telepon
                            Terduga<span class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="suspect_phone" name="suspect_phone"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nomor telepon terduga"
                            value="{{ old('suspect_phone', $report->suspect->phone) }}">
                        @error('suspect_phone')
                            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div></div>

                    <!-- Alamat Terduga -->
                    <div>
                        <label for="suspect_address" class="text-sm font-medium text-black">Alamat Terduga<span
                                class="ml-1 text-red-500">*</span></label>
                        <textarea id="suspect_address" name="suspect_address" rows="3"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan alamat terduga">{{ old('suspect_address', $report->suspect->address) }}</textarea>
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
                            placeholder="Masukkan deskripsi tambahan">{{ old('suspect_description', $report->suspect->description) }}</textarea>
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
                        <label for="reporter_nik" class="text-sm font-medium text-black">NIK Pelapor<span
                                class="ml-1 text-red-500">*</span></label>
                        <input type="number" id="reporter_nik" name="reporter_nik"
                            class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black"
                            placeholder="Masukkan nik pelapor"
                            value="{{ old('reporter_nik', $report->reporter->nik) }}">
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
                            placeholder="Masukkan nama pelapor"
                            value="{{ old('reporter_name', $report->reporter->name) }}">
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
                            placeholder="Masukkan usia pelapor"
                            value="{{ old('reporter_age', $report->reporter->age) }}">
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
                            <option value="Pria"
                                {{ old('reporter_gender', $report->reporter->gender) == 'Pria' ? 'selected' : '' }}>
                                Pria
                            </option>
                            <option value="Wanita"
                                {{ old('reporter_gender', $report->reporter->gender) == 'Wanita' ? 'selected' : '' }}>
                                Wanita
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
                            placeholder="Masukkan nomor telepon pelapor"
                            value="{{ old('reporter_phone', $report->reporter->phone) }}">
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
                                    {{ old('reporter_relationship_between', $report->reporter->relationship_between) == $option ? 'selected' : '' }}>
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
                            placeholder="Masukkan alamat pelapor">{{ old('reporter_address', $report->reporter->address) }}</textarea>
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
            let selectedRegencyName = "{{ $report->regency }}"; // Nama Kabupaten/Kota dari DB
            let selectedDistrictName = "{{ $report->district }}"; // Nama Kecamatan dari DB
            let selectedRegencyId = null;
            let selectedDistrictId = null;

            // Load Kabupaten/Kota
            $.getJSON("https://ibnux.github.io/data-indonesia/kabupaten/71.json", function(data) {
                data.sort((a, b) => a.nama.localeCompare(b.nama)); // Urutkan nama

                $.each(data, function(index, item) {
                    let formattedName = capitalizeEachWord(item.nama);
                    let selected = "";

                    if (formattedName === selectedRegencyName) {
                        selectedRegencyId = item.id; // Simpan ID yang cocok
                        selected = "selected";
                    }

                    $("#regency").append(
                        `<option value="${item.id}" ${selected}>${formattedName}</option>`);
                });

                // Jika ID ditemukan, load Kecamatan langsung
                if (selectedRegencyId) {
                    loadDistricts(selectedRegencyId);
                }
            });

            // Load Kecamatan setelah memilih Kabupaten/Kota
            $("#regency").change(function() {
                let regencyId = $(this).val();
                loadDistricts(regencyId);
            });

            function loadDistricts(regencyId) {
                $("#district").empty().append(`<option selected disabled>Pilih Kecamatan</option>`);

                $.getJSON(`https://ibnux.github.io/data-indonesia/kecamatan/${regencyId}.json`, function(data) {
                    data.sort((a, b) => a.nama.localeCompare(b.nama));

                    $.each(data, function(index, item) {
                        let formattedName = capitalizeEachWord(item.nama);
                        let selected = "";

                        if (formattedName === selectedDistrictName) {
                            selectedDistrictId = item.id; // Simpan ID yang cocok
                            selected = "selected";
                        }

                        $("#district").append(
                            `<option value="${item.id}" ${selected}>${formattedName}</option>`);
                    });
                });
            }

            function capitalizeEachWord(text) {
                return text.toLowerCase().replace(/\b\w/g, char => char.toUpperCase());
            }
        });
    </script>

</x-app-layout>
