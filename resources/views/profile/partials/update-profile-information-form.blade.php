<section>

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
            <label for="name" class="block font-medium text-sm">Name</label>
            <input id="name" name="name" type="text" value="{{ old('name', $user->name) }}" required
                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
            @error('name')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Email -->
        <div>
            <label for="email" class="block font-medium text-sm">Email</label>
            <input id="email" name="email" type="text" value="{{ old('email', $user->email) }}"
                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
            @error('email')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Gambar -->
        <div x-data="{ imagePreview: '{{ $user->employee->picture ? asset('storage/' . $user->employee->picture) : null }}' }">
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
                <div class="overflow-auto max-w-full h-64 rounded-md shadow-md border border-gray-300">
                    <img :src="imagePreview" class="w-full h-auto" alt="Image Preview">
                </div>
            </div>
            @error('picture')
                <p class="text-red-500 text-md mt-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-save-button type="submit">Simpan</x-save-button>
            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>

</section>
