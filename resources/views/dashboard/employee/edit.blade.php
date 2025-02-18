<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Ubah Karyawan -->
    <section class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
        <div class="border-b mb-6">
            <h2 class="text-xl font-semibold mb-2 text-black">Ubah Karyawan</h2>
        </div>

        <!-- Form Ubah Karyawan -->
        <form action="{{ route('dashboard.employees.update', $employee->nip) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h3 class="text-lg font-semibold mb-2">Informasi Karyawan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Informasi Utama Karyawan (Kiri) -->
                <div>
                    <div class="space-y-2">
                        <!-- NIP -->
                        <div>
                            <label for="nip" class="text-sm font-medium text-gray-800">NIP</label>
                            <input id="nip" name="nip" type="number" value="{{ old('nip', $employee->nip) }}"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                            @error('nip')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Nama -->
                        <div>
                            <label for="name" class="text-sm font-medium text-gray-800">Nama</label>
                            <input id="name" name="name" type="text"
                                value="{{ old('name', $employee->name) }}"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                            @error('name')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="text-sm font-medium text-gray-800">Jenis Kelamin</label>
                            <select id="gender" name="gender"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                                <option value="Pria"
                                    {{ old('gender', $employee->gender) == 'Pria' ? 'selected' : '' }}>Pria</option>
                                <option value="Wanita"
                                    {{ old('gender', $employee->gender) == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                            </select>
                            @error('gender')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Jabatan -->
                        <div>
                            <label for="position" class="text-sm font-medium text-gray-800">Jabatan</label>
                            <input id="position" name="position" type="text"
                                value="{{ old('position', $employee->position) }}"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                            @error('position')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="date_of_birth" class="text-sm font-medium text-gray-800">Tanggal Lahir</label>
                            <input id="date_of_birth" name="date_of_birth" type="date"
                                value="{{ old('date_of_birth', $employee->date_of_birth) }}"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                            @error('date_of_birth')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Status -->
                        <div>
                            <label for="status" class="text-sm font-medium text-gray-800">Status Karyawan</label>
                            <select id="status" name="status"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                                <option value="1" {{ old('status', $employee->status) == 1 ? 'selected' : '' }}>
                                    Aktif</option>
                                <option value="0" {{ old('status', $employee->status) == 0 ? 'selected' : '' }}>
                                    Non Aktif
                                </option>
                            </select>
                            @error('status')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Informasi Utama Karyawan (Kanan) -->
                <div>
                    <div class="space-y-2">
                        <!-- Alamat -->
                        <div>
                            <label for="address" class="text-sm font-medium text-gray-800">Alamat</label>
                            <textarea id="address" name="address" rows="4"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">{{ old('address', $employee->address) }}</textarea>
                            @error('address')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Telepon -->
                        <div>
                            <label for="phone" class="text-sm font-medium text-gray-800">No. Telepon</label>
                            <input id="phone" name="phone" type="number"
                                value="{{ old('phone', $employee->phone) }}"
                                class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                            @error('phone')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Upload dan Preview Gambar -->
                        <div x-data="{ imagePreview: '{{ asset('storage/' . $employee->picture) }}' }">
                            <label for="picture" class="text-sm font-medium text-gray-800">Gambar</label>
                            <input id="picture" type="file" name="picture"
                                class="mt-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring file:mr-4 file:py-2.5 file:px-4 file:font-medium file:border-0 file:text-sm file:bg-[#141652] file:text-white hover:file:bg-blue-800 transition ease-in-out duration-200"
                                @change="imagePreview = $event.target.files.length ? URL.createObjectURL($event.target.files[0]) : '{{ asset('storage/' . $employee->picture) }}'">

                            <!-- Tampilkan Preview Gambar -->
                            <div class="mt-4" x-show="imagePreview" style="display: none;">
                                <div class="overflow-auto max-w-full h-64 rounded-md border border-gray-300">
                                    <img :src="imagePreview" class="w-full h-auto" alt="Image Preview">
                                </div>
                            </div>
                            @error('picture')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi User -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-2">Informasi User</h3>
                <div class="space-y-2">
                    <!-- Role User -->
                    <div>
                        <label for="role" class="text-sm font-medium text-gray-800">Role</label>
                        <select id="role" name="role"
                            class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                            <option value="Petugas"
                                {{ old('role', $employee->user->role) == 'Petugas' ? 'selected' : '' }}>
                                Petugas</option>
                            <option value="Admin"
                                {{ old('role', $employee->user->role) == 'Admin' ? 'selected' : '' }}>
                                Admin</option>
                            <option value="Developer"
                                {{ old('role', $employee->user->role) == 'Developer' ? 'selected' : '' }}>
                                Developer</option>
                        </select>
                        @error('role')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Name User -->
                    <div>
                        <label for="username" class="text-sm font-medium text-gray-800">Username</label>
                        <input id="username" name="username" type="text"
                            value="{{ old('username', $employee->user->name) }}"
                            class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                        @error('username')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Email User -->
                    <div>
                        <label for="email" class="text-sm font-medium text-gray-800">Email</label>
                        <input id="email" name="email" type="email"
                            value="{{ old('email', $employee->user->email) }}"
                            class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                        @error('email')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Password User -->
                    <div>
                        <label for="password" class="text-sm font-medium text-gray-800">Password</label>
                        <input id="password" name="password" type="password"
                            class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                        @error('password')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation" class="text-sm font-medium text-gray-800">Konfirmasi
                            Password</label>
                        <input id="password_confirmation" name="password_confirmation" type="password"
                            class="mt-1 p-1 w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                        @error('password_confirmation')
                            <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Tombol Kembali & Simpan -->
            <div class="flex justify-end space-x-2 mt-5">
                <a href="{{ route('dashboard.employees.index') }}"
                    class="bg-gray-700 hover:bg-gray-800 text-white px-6 py-2 rounded-lg transition duration-200">
                    Kembali
                </a>
                <button type="submit"
                    class="bg-[#141652] hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </section>

</x-app-layout>
