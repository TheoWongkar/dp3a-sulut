<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Detail Karyawan -->
    <section class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
        <!-- Header: Foto & Identitas Karyawan -->
        <div class="flex items-center space-x-4 border-b pb-4 mb-6">
            <img src="{{ $employee->avatar ? asset('storage/' . $employee->avatar) : asset('img/placeholder-profile.webp') }}"
                alt="Foto {{ $employee->name }}" class="w-24 h-24 rounded-full object-cover shadow-md">
            <div>
                <h1 class="text-2xl font-bold">{{ $employee->name }}</h1>
                <p class="text-sm">NIP: {{ $employee->nip }}</p>
            </div>
        </div>

        <!-- Data Karyawan & Informasi User -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <!-- Informasi Karyawan -->
            <div>
                <h2 class="text-lg font-semibold mb-2">Informasi Karyawan</h2>
                <ul class="text-sm space-y-2">
                    @foreach (['Nama' => 'name', 'Jenis Kelamin' => 'gender', 'Jabatan' => 'position', 'Tanggal Lahir' => 'date_of_birth', 'Alamat' => 'address', 'Nomor Handphone' => 'phone'] as $label => $field)
                        <li>
                            <strong>{{ $label }}:</strong>
                            @if ($field === 'date_of_birth')
                                {{ \Carbon\Carbon::parse($employee->$field)->translatedFormat('d F Y') }}
                            @else
                                {{ $employee->$field }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Informasi User -->
            <div>
                <h2 class="text-lg font-semibold mb-2">Informasi User</h2>
                <ul class="text-sm space-y-2">
                    @foreach (['Username' => 'username', 'Email' => 'email', 'Role' => 'role'] as $label => $field)
                        <li><strong>{{ $label }}:</strong> {{ $employee->user->$field }}</li>
                    @endforeach
                    <li>
                        <strong>Status:</strong>
                        <span
                            class="inline-block px-3 py-1 rounded-full text-xs shadow-md text-white transition duration-200 
                            {{ $employee->status === 'Aktif' ? 'bg-green-500 hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600' }}">
                            {{ $employee->status }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Statistik -->
        <div class="mt-6">
            <h2 class="text-lg font-semibold">Statistik</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach ([['label' => 'Berita Diterbitkan', 'count' => $employee->user->posts->count()], ['label' => 'Laporan Ditangani', 'count' => $employee->user->reports->count()]] as $stat)
                    <div class="bg-gray-100 rounded-lg p-4 shadow">
                        <h3 class="text-sm font-medium">{{ $stat['label'] }}</h3>
                        <p class="text-2xl font-bold">{{ $stat['count'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tombol Kembali -->
        <div class="mt-6 flex justify-end gap-2">
            <a href="{{ route('dashboard.employees.index') }}"
                class="bg-gray-700 text-white py-2 px-6 rounded-md hover:bg-gray-800">
                Kembali
            </a>
            <a href="{{ route('dashboard.employees.edit', $employee->nip) }}"
                class="bg-green-700 text-white py-2 px-6 rounded-md hover:bg-green-800">
                Ubah Profil
            </a>
        </div>
    </section>

</x-app-layout>
