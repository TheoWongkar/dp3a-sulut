<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Tambah Laporan</x-slot>

    {{-- Modal Nomor Tiket --}}
    @if (session('ticket_number'))
        <div x-data="{ open: true }" x-show="open" x-transition x-cloak
            class="fixed inset-0 z-30 flex items-center justify-center px-5 bg-black/70">
            <div class="bg-gray-100 rounded-lg shadow-lg p-6 w-full max-w-md text-center">
                <h2 class="text-2xl font-semibold text-green-600 mb-5">Laporan Terkirim</h2>

                <label for="ticket_number" class="block text-gray-700 mb-1">
                    Nomor Tiket Anda:
                </label>

                <x-forms.input id="ticket_number" name="ticket_number" value="{{ session('ticket_number') }}"
                    class="text-center" readonly />

                <p class="text-sm text-gray-500 mt-2">
                    Simpan nomor ini dan cek perkembangan laporan
                    <a href="{{ route('report.check-status') }}" class="text-blue-600 hover:underline">
                        di sini
                    </a>
                </p>

                <div class="mt-2">
                    <x-buttons.primary-button type="button" @click="open = false">Tutup</x-buttons.primary-button>
                </div>
            </div>
        </div>
    @endif

    {{-- Bagian Tambah Laporan --}}
    <section class="space-y-2">

        {{-- Flash Message --}}
        <x-alerts.flash-message />

        {{-- Form Tambah Laporan --}}
        <div class="p-4 bg-white rounded-lg border border-gray-300 shadow">
            <form action="{{ route('dashboard.report.store') }}" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Data Pelapor</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-forms.input name="reporter_name" label="Nama Pelapor" />
                        </div>
                        <x-forms.input name="reporter_nik" label="NIK (Opsional)" type="number" />
                        <x-forms.select name="reporter_gender" label="Jenis Kelamin" :options="['Laki-laki', 'Perempuan']" />
                        <x-forms.input name="reporter_phone" label="No. Telepon" />
                        <x-forms.input name="reporter_age" label="Usia" type="number" />
                        <x-forms.select name="reporter_relationship_between" label="Hubungan dengan Korban"
                            :options="['Diri Sendiri', 'Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']" />
                        <x-forms.textarea name="reporter_address" label="Alamat" />
                    </div>
                </div>

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Data Korban</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-forms.input name="victim_name" label="Nama Korban" />
                        </div>
                        <x-forms.input name="victim_nik" label="NIK (Opsional)" type="number" />
                        <x-forms.select name="victim_gender" label="Jenis Kelamin" :options="['Laki-laki', 'Perempuan']" />
                        <x-forms.input name="victim_phone" label="No. Telepon" />
                        <x-forms.input name="victim_age" label="Usia" type="number" />
                        <x-forms.textarea name="victim_address" label="Alamat" />
                        <x-forms.textarea name="victim_description" label="Keterangan Tambahan (Opsional)" />
                    </div>
                </div>

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Data Terduga</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-forms.input name="suspect_name" label="Nama Terduga (Opsional)" />
                        </div>
                        <x-forms.input name="suspect_nik" label="NIK (Opsional)" type="number" />
                        <x-forms.select name="suspect_gender" label="Jenis Kelamin (Opsional)" :options="['Laki-laki', 'Perempuan']" />
                        <x-forms.input name="suspect_phone" label="No. Telepon (Opsional)" />
                        <x-forms.input name="suspect_age" label="Usia (Opsional)" type="number" />
                        <x-forms.textarea name="suspect_address" label="Alamat (Opsional)" />
                        <x-forms.textarea name="suspect_description" label="Keterangan Tambahan (Opsional)" />
                    </div>
                </div>

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Informasi Kasus</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-forms.select name="violence_category" label="Kategori Kekerasan" :options="['Fisik', 'Psikis', 'Seksual', 'Penelantaran', 'Eksploitasi', 'Lainnya']" />
                        <x-forms.input name="incident_date" label="Tanggal Kejadian" type="date" />
                        <x-forms.select name="regency" label="Kabupaten/Kota" id="regency">
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                        </x-forms.select>
                        <x-forms.select name="district" label="Kecamatan" id="district" disabled>
                            <option value="">-- Pilih Kecamatan --</option>
                        </x-forms.select>
                        <x-forms.input name="scene" label="Tempat Kejadian" />
                        <div>
                            <x-forms.input name="evidence" label="Bukti (Opsional)" type="file"
                                accept="application/pdf,image/jpeg,image/png,video/mp4,video/webm"
                                class="file:mr-4 file:px-3 file:text-xs file:text-white file:rounded-xs file:bg-gray-600" />
                            <p class="mt-1 text-xs text-gray-600">Format: PDF, JPG, JPEG, PNG, MP4, WEBM. Max 50MB.</p>
                        </div>
                        <x-forms.textarea name="chronology" label="Kronologi" class="md:col-span-2" />
                    </div>
                </div>

                <div class="space-y-2">
                    <h2 class="mb-5 font-semibold text-gray-700">Pernyataan</h2>

                    <p class="text-sm text-gray-700 leading-relaxed">Data yang Anda berikan bersifat rahasia dan
                        tidak akan disebarluaskan.</p>
                    <p class="text-sm text-gray-700 leading-relaxed">
                        Dengan mengisi form ini saya menyatakan SETUJU untuk dilakukan penanganan dan
                        pendampingan
                        oleh UPTD-PPA Provinsi Sulawesi Utara.
                    </p>

                    <div class="flex items-start gap-2">
                        <input type="checkbox" name="agree" id="agree" required
                            class="mt-1 border-gray-300 rounded shadow-sm focus:ring focus:ring-blue-200" />
                        <label for="agree" class="text-sm text-gray-700">
                            Saya menyetujui pernyataan di atas
                        </label>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <x-buttons.primary-button type="submit">Simpan</x-buttons.primary-button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const regencySelect = document.getElementById('regency');
            const districtSelect = document.getElementById('district');

            const oldRegency = "{{ old('regency') }}";
            const oldDistrict = "{{ old('district') }}";

            // Utility: Capitalize Each Word
            function capitalizeEachWord(str) {
                return str
                    .toLowerCase()
                    .replace(/\b\w/g, char => char.toUpperCase());
            }

            // Load Kabupaten
            async function loadRegencies() {
                try {
                    const res = await fetch('https://ibnux.github.io/data-indonesia/kabupaten/71.json');
                    const data = await res.json();

                    const sorted = data.sort((a, b) => a.nama.localeCompare(b.nama));

                    sorted.forEach(kab => {
                        const nama = capitalizeEachWord(kab.nama);
                        const option = document.createElement('option');
                        option.value = nama; // kirim NAMA, bukan ID
                        option.textContent = nama;
                        if (nama === oldRegency) option.selected = true;
                        regencySelect.appendChild(option);
                    });

                    // Load kecamatan jika ada old kabupaten
                    if (oldRegency) {
                        const kabupaten = sorted.find(k => capitalizeEachWord(k.nama) === oldRegency);
                        if (kabupaten) {
                            await loadDistricts(kabupaten.id);
                        }
                    }

                } catch (err) {
                    console.error('Gagal memuat kabupaten:', err);
                }
            }

            // Load Kecamatan berdasarkan ID kabupaten
            async function loadDistricts(regencyId) {
                try {
                    districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                    districtSelect.disabled = true;

                    const res = await fetch(
                        `https://ibnux.github.io/data-indonesia/kecamatan/${regencyId}.json`);
                    const data = await res.json();

                    const sorted = data.sort((a, b) => a.nama.localeCompare(b.nama));

                    sorted.forEach(kec => {
                        const nama = capitalizeEachWord(kec.nama);
                        const option = document.createElement('option');
                        option.value = nama; // kirim NAMA, bukan ID
                        option.textContent = nama;
                        if (nama === oldDistrict) option.selected = true;
                        districtSelect.appendChild(option);
                    });

                    districtSelect.disabled = false;
                } catch (err) {
                    console.error('Gagal memuat kecamatan:', err);
                }
            }

            // Saat Kabupaten dipilih
            regencySelect.addEventListener('change', async (e) => {
                const selectedNama = e.target.value;

                districtSelect.innerHTML = '<option value="">-- Pilih Kecamatan --</option>';
                districtSelect.disabled = true;

                if (!selectedNama) return;

                try {
                    const res = await fetch(
                        'https://ibnux.github.io/data-indonesia/kabupaten/71.json');
                    const data = await res.json();
                    const selectedKab = data.find(k => capitalizeEachWord(k.nama) === selectedNama);
                    if (selectedKab) {
                        await loadDistricts(selectedKab.id);
                    }
                } catch (err) {
                    console.error('Gagal mendapatkan ID kabupaten dari nama:', err);
                }
            });

            // Mulai
            await loadRegencies();
        });
    </script>

</x-app-layout>
