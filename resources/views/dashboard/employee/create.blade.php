<x-app-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Tambah Karyawan -->
    <section class="bg-white p-6 shadow-lg rounded-lg">
        <div class="border-b mb-6">
            <h2 class="text-xl font-semibold mb-2 text-black">Tambah Karyawan</h2>
        </div>

        <!-- Form Tambah Karyawan -->
        <form action="{{ route('dashboard.employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <h3 class="text-lg font-semibold mb-2">Informasi Karyawan</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                <!-- Informasi Utama Karyawan (Kiri) -->
                <div>
                    <div class="space-y-2">
                        <!-- NIP -->
                        <div>
                            <label for="nip" class="text-sm font-medium text-black">NIP</label>
                            <input id="nip" name="nip" type="number" value="{{ old('nip') }}"
                                placeholder="Masukkan nip"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('nip')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Nama -->
                        <div>
                            <label for="name" class="text-sm font-medium text-black">Nama</label>
                            <input id="name" name="name" type="text" value="{{ old('name') }}"
                                placeholder="Masukkan nama"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('name')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Jenis Kelamin -->
                        <div>
                            <label for="gender" class="text-sm font-medium text-black">Jenis Kelamin</label>
                            <select id="gender" name="gender"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                                <option value="" disabled selected>Pilih</option>
                                <option value="Pria" {{ old('gender') == 'Pria' ? 'selected' : '' }}>Pria</option>
                                <option value="Wanita" {{ old('gender') == 'Wanita' ? 'selected' : '' }}>Wanita</option>
                            </select>
                            @error('gender')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Jabatan -->
                        <div>
                            <label for="position" class="text-sm font-medium text-black">Jabatan</label>
                            <input id="position" name="position" type="text" value="{{ old('position') }}"
                                placeholder="Masukkan jabatan"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('position')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Tanggal Lahir -->
                        <div>
                            <label for="date_of_birth" class="text-sm font-medium text-black">Tanggal Lahir</label>
                            <input id="date_of_birth" name="date_of_birth" type="date"
                                value="{{ old('date_of_birth') }}"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('date_of_birth')
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
                            <label for="address" class="text-sm font-medium text-black">Alamat</label>
                            <textarea id="address" name="address" rows="4"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">{{ old('address') }}</textarea>
                            @error('address')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Telepon -->
                        <div>
                            <label for="phone" class="text-sm font-medium text-black">No. Telepon</label>
                            <input id="phone" name="phone" type="number" value="{{ old('phone') }}"
                                placeholder="08XXXXXXXXXX"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('phone')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Gambar -->
                        <div x-data="{ imagePreview: null }">
                            <label for="avatar" class="text-sm font-medium text-black">Foto Profil</label>
                            <input id="avatar" type="file" name="avatar" accept="image/jpeg, image/png"
                                class="mt-1 w-full border border-gray-200 rounded-md shadow-sm focus:outline-black file:mr-4 file:py-2 file:px-4 file:text-sm file:bg-gray-700 file:text-white hover:file:bg-gray-800"
                                @change="if ($event.target.files.length) { 
                                               const file = $event.target.files[0]; 
                                               const reader = new FileReader(); 
                                               reader.onload = (e) => { imagePreview = e.target.result; }; 
                                               reader.readAsDataURL(file); 
                                           } else { imagePreview = null; }">
                            <!-- Preview Gambar -->
                            <div class="mt-4" x-show="imagePreview" style="display: none;">
                                <div class="overflow-auto max-w-full h-64 rounded-md border border-gray-300">
                                    <img :src="imagePreview" class="w-full h-auto" alt="Image Preview">
                                </div>
                            </div>
                            @error('avatar')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi User -->
            <div class="mt-6 w-full">
                <h3 class="text-lg font-semibold mb-2">Informasi User</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Kolom Kiri -->
                    <div class="space-y-2">
                        <!-- Role User -->
                        <div>
                            <label for="role" class="text-sm font-medium text-black">Role</label>
                            <select id="role" name="role"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                                <option value="" selected disabled>Pilih</option>
                                <option value="Petugas" {{ old('role') == 'Petugas' ? 'selected' : '' }}>Petugas
                                </option>
                                <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                            @error('role')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Username -->
                        <div>
                            <label for="username" class="text-sm font-medium text-black">Username</label>
                            <input id="username" name="username" type="text" value="{{ old('username') }}"
                                placeholder="Masukkan username"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('username')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Email -->
                        <div>
                            <label for="email" class="text-sm font-medium text-black">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}"
                                placeholder="Masukkan email"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('email')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kolom Kanan -->
                    <div class="space-y-2">
                        <!-- Password -->
                        <div>
                            <label for="password" class="text-sm font-medium text-black">Password</label>
                            <input id="password" name="password" type="password" placeholder="Masukkan password"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('password')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="text-sm font-medium text-black">Konfirmasi
                                Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                placeholder="Masukkan ulang password"
                                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
                            @error('password_confirmation')
                                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Batal & Simpan -->
            <div class="flex justify-end space-x-2 mt-6">
                <a href="{{ route('dashboard.employees.index') }}"
                    class="bg-gray-700 text-white py-2 px-6 rounded-md hover:bg-gray-800">
                    Batal
                </a>
                <button type="submit" class="bg-green-700 text-white py-2 px-6 rounded-md hover:bg-green-800">
                    Simpan
                </button>
            </div>
        </form>
    </section>

</x-app-layout>
