<section>

    <!-- Header -->
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Informasi Profil
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Perbarui informasi profil akun dan alamat email Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="#">
        @csrf
    </form>

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
        @csrf
        @method('PUT')

        <!-- Nama -->
        <div>
            <label for="username" class="text-sm font-medium text-gray-800">Username</label>
            <input id="username" name="username" type="text"
                value="{{ old('username', $employee->user->username) }}" required
                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
            @error('username')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="text-sm font-medium text-gray-800">Email</label>
            <input id="email" name="email" type="text" value="{{ old('email', $employee->user->email) }}"
                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
            @error('email')
                <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Gambar -->
        <div x-data="{ imagePreview: '{{ $employee->avatar ? asset('storage/' . $employee->avatar) : asset('img/placeholder-profile.webp') }}' }">
            <label for="avatar" class="text-sm font-medium text-gray-800">Foto Profil</label>
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

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-green-700 text-white py-2 px-6 rounded-md hover:bg-green-800">Simpan</button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>

</section>
