<x-app-layout>

    {{-- Judul Halaman --}}
    <x-slot name="title">Lengkapi Berkas</x-slot>

    {{-- Bagian Lengkapi Berkas --}}
    <section class="space-y-2">

        {{-- Flash Message --}}
        <x-alerts.flash-message />

        {{-- Form Lengkapi Berkas --}}
        <div class="p-4 bg-white rounded-lg border border-gray-300 shadow">
            <form action="{{ route('dashboard.report.received.update', ['diterima', $report->ticket_number]) }}"
                method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <x-buttons.primary-button type="button"
                        class="bg-gray-600 font-bold hover:bg-gray-700">{{ $report->ticket_number }}</x-buttons.primary-button>
                </div>

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Data Pelapor</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-forms.input name="reporter_name" label="Nama Pelapor" :value="old('reporter_name', $report->reporter->name)" />
                        </div>
                        <x-forms.input name="reporter_nik" label="NIK" type="number" :value="old('reporter_nik', $report->reporter->nik)" />
                        <x-forms.select name="reporter_gender" label="Jenis Kelamin" :options="['Laki-laki', 'Perempuan']"
                            :selected="old('reporter_gender', $report->reporter->gender)" />
                        <x-forms.input name="reporter_phone" label="No. Telepon" :value="old('reporter_phone', $report->reporter->phone)" />
                        <x-forms.input name="reporter_age" label="Usia" type="number" :value="old('reporter_age', $report->reporter->age)" />
                        <x-forms.select name="reporter_relationship_between" label="Hubungan dengan Korban"
                            :options="['Diri Sendiri', 'Orang Tua', 'Saudara', 'Guru', 'Teman', 'Lainnya']" :selected="old('reporter_relationship_between', $report->reporter->relationship_between)" />
                        <x-forms.textarea name="reporter_address" label="Alamat" :value="old('reporter_address', $report->reporter->address)"></x-forms.textarea>
                    </div>
                </div>

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Data Korban</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-forms.input name="victim_name" label="Nama Korban" :value="old('victim_name', $report->victim->name)" />
                        </div>
                        <x-forms.input name="victim_nik" label="NIK" type="number" :value="old('victim_nik', $report->victim->nik)" />
                        <x-forms.select name="victim_gender" label="Jenis Kelamin" :options="['Laki-laki', 'Perempuan']"
                            :selected="old('victim_gender', $report->victim->gender)" />
                        <x-forms.input name="victim_phone" label="No. Telepon" :value="old('victim_phone', $report->victim->phone)" />
                        <x-forms.input name="victim_age" label="Usia" type="number" :value="old('victim_age', $report->victim->age)" />
                        <x-forms.textarea name="victim_address" label="Alamat" :value="old('victim_address', $report->victim->address)" />
                        <x-forms.textarea name="victim_description" label="Keterangan Tambahan (Opsional)"
                            :value="old('victim_description', $report->victim->description)" />
                    </div>
                </div>

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Data Terduga</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <x-forms.input name="suspect_name" label="Nama Terduga" :value="old('suspect_name', $report->suspect->name)" />
                        </div>
                        <x-forms.input name="suspect_nik" label="NIK" type="number" :value="old('suspect_nik', $report->suspect->nik)" />
                        <x-forms.select name="suspect_gender" label="Jenis Kelamin" :options="['Laki-laki', 'Perempuan']"
                            :selected="old('suspect_gender', $report->suspect->gender)" />
                        <x-forms.input name="suspect_phone" label="No. Telepon" :value="old('suspect_phone', $report->suspect->phone)" />
                        <x-forms.input name="suspect_age" label="Usia" type="number" :value="old('suspect_age', $report->suspect->age)" />
                        <x-forms.textarea name="suspect_address" label="Alamat" :value="old('suspect_address', $report->suspect->address)" />
                        <x-forms.textarea name="suspect_description" label="Keterangan Tambahan (Opsional)"
                            :value="old('suspect_description', $report->suspect->description)" />
                    </div>
                </div>

                <div>
                    <h2 class="mb-5 font-semibold text-gray-700">Informasi Kasus</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-forms.select name="violence_category" label="Kategori Kekerasan" :options="['Fisik', 'Psikis', 'Seksual', 'Penelantaran', 'Eksploitasi', 'Lainnya']"
                            :selected="old('violence_category', $report->violence_category)" />
                        <x-forms.input name="incident_date" label="Tanggal Kejadian" type="date"
                            :value="old('incident_date', $report->incident_date)" />
                        <x-forms.select name="regency" label="Kabupaten/Kota" id="regency">
                            <option value="">-- Pilih Kabupaten/Kota --</option>
                            @if (old('regency', $report->regency))
                                <option value="{{ old('regency', $report->regency) }}" selected>
                                    {{ old('regency', $report->regency) }}
                                </option>
                            @endif
                        </x-forms.select>
                        <x-forms.select name="district" label="Kecamatan" id="district" :disabled="!old('district', $report->district)">
                            <option value="">-- Pilih Kecamatan --</option>
                            @if (old('district', $report->district))
                                <option value="{{ old('district', $report->district) }}" selected>
                                    {{ old('district', $report->district) }}
                                </option>
                            @endif
                        </x-forms.select>
                        <x-forms.input name="scene" label="Tempat Kejadian" :value="old('scene', $report->scene)" />
                        <div>
                            <x-forms.input name="evidence" label="Bukti (Opsional)" type="file"
                                accept="application/pdf,image/jpeg,image/png,video/mp4,video/webm"
                                class="file:mr-4 file:px-3 file:text-xs file:text-white file:rounded-xs file:bg-gray-600" />
                            <p class="mt-1 text-xs text-gray-600">Format: PDF, JPG, JPEG, PNG, MP4, WEBM. Max 50MB.</p>
                            @if ($report->evidence)
                                <p class="text-xs">
                                    Saat ini:
                                    <a href="{{ asset('storage/' . $report->evidence) }}" target="_blank"
                                        class="text-blue-600 underline">
                                        Lihat File
                                    </a>
                                </p>
                            @endif
                        </div>
                        <x-forms.textarea name="chronology" label="Kronologi" class="md:col-span-2"
                            :value="old('chronology', $report->chronology)" />
                    </div>
                </div>

                <div class="mt-4 flex items-center justify-end gap-2">
                    <x-buttons.primary-button href="{{ route('dashboard.report.index', 'diterima') }}"
                        class="bg-gray-600 hover:bg-gray-700">Kembali</x-buttons.primary-button>
                    <x-buttons.primary-button type="submit" name="action" value="cancel"
                        onclick="return confirm('Yakin ingin membatalkan?')"
                        class="bg-red-600 hover:bg-red-700">Batalkan</x-buttons.primary-button>
                    <x-buttons.primary-button type="submit"
                        class="bg-green-600 hover:bg-green-700">Simpan</x-buttons.primary-button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', async () => {
            const regencySelect = document.getElementById('regency');
            const districtSelect = document.getElementById('district');

            const oldRegency = "{{ old('regency', $report->regency) }}";
            const oldDistrict = "{{ old('district', $report->district) }}";

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
