<x-app-layout>

    <!-- Judul Halaman -->
    <x-title :title=$title></x-title>

    <!-- Detail Karyawan -->
    <section>
        <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
            <!-- Header -->
            <div class="flex items-center space-x-4 border-b pb-4 mb-6">
                <img src="{{ $employee->picture ? asset('storage/' . $employee->picture) : asset('img/profile-placeholder.jpg') }}"
                    alt="Foto {{ $employee->name }}" class="w-24 h-24 rounded-full object-cover shadow-md">
                <div>
                    <h1 class="text-2xl font-bold">{{ $employee->name }}</h1>
                    <p class="text-sm">NIP: {{ $employee->nip }}</p>
                </div>
            </div>

            <!-- Data Karyawan -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Informasi Utama -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Informasi Karyawan</h2>
                    <ul class="text-sm space-y-2">
                        <li><strong>Nama:</strong> {{ $employee->name }}</li>
                        <li><strong>Jenis Kelamin:</strong> {{ $employee->gender }}</li>
                        <li><strong>Jabatan:</strong> {{ $employee->position }}</li>
                        <li><strong>Tanggal Lahir:</strong> {{ $employee->date_of_birth }}</li>
                        <li><strong>Alamat:</strong> {{ $employee->address }}</li>
                        <li><strong>Nomor Handphone:</strong> {{ $employee->phone }}</li>
                    </ul>
                </div>

                <!-- Informasi User -->
                <div>
                    <h2 class="text-lg font-semibold mb-2">Informasi User</h2>
                    <ul class="text-sm space-y-2">
                        <li><strong>Username:</strong> {{ $employee->user->name }}</li>
                        <li><strong>Email:</strong> {{ $employee->user->email }}</li>
                        <li><strong>Role:</strong> {{ $employee->user->role }}</li>
                        <li>
                            <strong>Status:</strong>
                            <span
                                class="inline-block px-3 py-1 rounded-full text-xs shadow-md {{ $employee->status ? 'bg-green-500 hover:bg-green-600' : 'bg-orange-500 hover:bg-orange-600' }} text-white transition duration-200">
                                {{ $employee->status ? 'Aktif' : 'Non Aktif' }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Statistik -->
            <div class="mt-6">
                <h2 class="text-lg font-semibold mb-4">Statistik</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="bg-gray-100 rounded-lg p-4 shadow">
                        <h3 class="text-sm font-medium">Berita Diterbitkan</h3>
                        <p class="text-2xl font-bold">{{ $employee->posts->count() }}</p>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-4 shadow">
                        <h3 class="text-sm font-medium">Laporan Ditangani</h3>
                        <p class="text-2xl font-bold">{{ $employee->reports->count() }}</p>
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('dashboard.employees.index') }}"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition duration-200">
                    Kembali
                </a>
            </div>
        </div>
    </section>

</x-app-layout>
