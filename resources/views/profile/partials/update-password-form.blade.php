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
            <label for="update_password_current_password" class="text-sm font-medium text-gray-800">Kata Sandi Saat
                Ini</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
            @error('current_password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Kata Sandi Baru -->
        <div>
            <label for="update_password_password" class="text-sm font-medium text-gray-800">Kata Sandi
                Baru</label>
            <input id="update_password_password" name="password" type="password"
                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
            @error('password')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Konfirmasi Kata Sandi Baru -->
        <div>
            <label for="update_password_password_confirmation" class="text-sm font-medium text-gray-800">Konfirmasi Kata
                Sandi
                Baru</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="mt-1 p-2 w-full bg-white text-sm border border-gray-200 rounded-md shadow-sm focus:outline-black">
            @error('password_confirmation')
                <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>
        <!-- Tombol Simpan -->
        <div class="flex items-center gap-4">
            <button type="submit"
                class="bg-green-700 text-white py-2 px-6 rounded-md hover:bg-green-800">Simpan</button>
            @if (session('status') === 'password-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">
                    Tersimpan.
                </p>
            @endif
        </div>
    </form>

</section>
