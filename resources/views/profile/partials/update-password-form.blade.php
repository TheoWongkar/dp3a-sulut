<section>

    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Perbarui Kata Sandi
        </h2>
        <p class="mt-1 text-sm text-gray-600">
            Pastikan akun Anda menggunakan kata sandi yang panjang dan acak agar tetap aman.
        </p>
    </header>

    <form method="POST" action="{{ route('profile.updatePassword') }}" class="mt-6 space-y-6">
        @csrf
        @method('PUT')
        <!-- Kata Sandi Saat Ini -->
        <div>
            <label for="update_password_current_password" class="block font-medium text-sm">Kata Sandi Saat Ini</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
            @error('current_password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Kata Sandi Baru -->
        <div>
            <label for="update_password_password" class="block font-medium text-sm">Kata Sandi
                Baru</label>
            <input id="update_password_password" name="password" type="password"
                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
            @error('password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Konfirmasi Kata Sandi Baru -->
        <div>
            <label for="update_password_password_confirmation" class="block font-medium text-sm">Konfirmasi Kata Sandi
                Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 p-2 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-[#141652]">
            @error('password_confirmation')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <x-save-button type="submit">Simpan</x-save-button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>

</section>
