<x-app-layout>

    <!-- Judul Halaman -->
    <x-title :title=$title></x-title>

    <!-- Bagian Ubah Karyawan -->
    <section>
        <div class="bg-white p-6 shadow-lg rounded-lg hover:shadow-xl transition-shadow">
            <div class="flex items-center space-x-4 border-b pb-4 mb-6">
                <h1 class="text-2xl font-bold">Ubah Karyawan</h1>
            </div>
            <!-- Form Ubah Karyawan -->
            <form action="{{ route('dashboard.employees.update', $employee->nip) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <h2 class="text-lg font-semibold mb-2">Informasi Karyawan</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Informasi Utama Karyawan (Kiri) -->
                    <div>
                        <div class="space-y-2">
                            <!-- NIP -->
                            <div>
                                <label for="nip" class="block font-medium text-sm">NIP</label>
                                <input id="nip" name="nip" type="number"
                                    value="{{ old('nip', $employee->nip) }}" required
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                @error('nip')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Nama -->
                            <div>
                                <label for="name" class="block font-medium text-sm">Nama</label>
                                <input id="name" name="name" type="text"
                                    value="{{ old('name', $employee->name) }}" required
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                @error('name')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Jenis Kelamin -->
                            <div>
                                <label for="gender" class="block font-medium text-sm">Jenis
                                    Kelamin</label>
                                <select id="gender" name="gender" required
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                    <option value="Pria"
                                        {{ old('gender', $employee->gender) == 'Pria' ? 'selected' : '' }}>Pria
                                    </option>
                                    <option value="Wanita"
                                        {{ old('gender', $employee->gender) == 'Wanita' ? 'selected' : '' }}>Wanita
                                    </option>
                                </select>
                                @error('gender')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Jabatan -->
                            <div>
                                <label for="position" class="block font-medium text-sm">Jabatan</label>
                                <input id="position" name="position" type="text"
                                    value="{{ old('position', $employee->position) }}" required
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                @error('position')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Tanggal Lahir -->
                            <div>
                                <label for="date_of_birth" class="block font-medium text-sm text-gray-700">Tanggal
                                    Lahir</label>
                                <input id="date_of_birth" name="date_of_birth" type="date"
                                    value="{{ old('date_of_birth', $employee->date_of_birth) }}" required
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                @error('date_of_birth')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Status -->
                            <div>
                                <label for="status" class="block font-medium text-sm">Status Karyawan</label>
                                <select id="status" name="status" required
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                    <option value="1"
                                        {{ old('status', $employee->status) == '1' ? 'selected' : '' }}>Aktif
                                    </option>
                                    <option value="0"
                                        {{ old('status', $employee->status) == '0' ? 'selected' : '' }}>Non Aktif
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Utama Karyawan (Kanan) -->
                    <div>
                        <div class="space-y-2">
                            <!-- Alamat -->
                            <div>
                                <label for="address" class="block font-medium text-sm">Alamat</label>
                                <textarea id="address" name="address" rows="4" required
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">{{ old('address', $employee->address) }}</textarea>
                                @error('address')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Telepon -->
                            <div>
                                <label for="phone" class="block font-medium text-sm">No. Telepon</label>
                                <input id="phone" name="phone" type="number"
                                    value="{{ old('phone', $employee->phone) }}"
                                    class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                @error('phone')
                                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <!-- Gambar -->
                            <div x-data="{ imagePreview: '{{ $employee->picture ? asset('storage/' . $employee->picture) : null }}' }">
                                <label for="picture" class="block text-sm font-medium">Foto Profil</label>
                                <input id="picture" type="file" name="picture"
                                    class="mt-1 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652] file:mr-4 file:py-2.5 file:px-4 file:font-medium file:border-0 file:text-sm file:bg-[#141652] file:text-white hover:file:bg-blue-800 transition ease-in-out duration-200"
                                    @change="if ($event.target.files.length) { 
                                            const file = $event.target.files[0]; 
                                            const reader = new FileReader(); 
                                            reader.onload = (e) => { imagePreview = e.target.result; }; 
                                            reader.readAsDataURL(file); 
                                        } else { imagePreview = null; }">
                                <!-- Preview Gambar -->
                                <div class="mt-4" x-show="imagePreview" style="display: none;">
                                    <div
                                        class="overflow-auto max-w-full h-64 rounded-md shadow-md border border-gray-300">
                                        <img :src="imagePreview" class="w-full h-auto" alt="Image Preview">
                                    </div>
                                </div>
                                @error('picture')
                                    <p class="text-red-500 text-md mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Informasi User -->
                <div class="mt-6">
                    <h2 class="text-lg font-semibold mb-2">Informasi User</h2>
                    <div class="space-y-2">
                        <!-- Role User -->
                        <div>
                            <label for="role" class="block font-medium text-sm">Role</label>
                            <select id="role" name="role" required
                                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                                <option value="Petugas"
                                    {{ old('role', $employee->user->role) === 'Petugas' ? 'selected' : '' }}>Petugas
                                </option>
                                <option value="Admin"
                                    {{ old('role', $employee->user->role) === 'Admin' ? 'selected' : '' }}>Admin
                                </option>
                                <option value="Developer"
                                    {{ old('role', $employee->user->role) === 'Developer' ? 'selected' : '' }}>
                                    Developer
                                </option>
                            </select>
                            @error('role')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Name User -->
                        <div>
                            <label for="username" class="block font-medium text-sm">Username</label>
                            <input id="username" name="username" type="text"
                                value="{{ old('username', $employee->user->name) }}" required
                                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                            @error('username')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Email User -->
                        <div>
                            <label for="email" class="block font-medium text-sm">Email</label>
                            <input id="email" name="email" type="email"
                                value="{{ old('email', $employee->user->email) }}" required
                                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                            @error('email')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Password User -->
                        <div>
                            <label for="password" class="block font-medium text-sm">Password</label>
                            <input id="password" name="password" type="password"
                                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                            @error('password')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Konfirmasi Password -->
                        <div>
                            <label for="password_confirmation" class="block font-medium text-sm">Konfirmasi
                                Password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password"
                                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
                            @error('password_confirmation')
                                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
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
        </div>
    </section>

</x-app-layout>
