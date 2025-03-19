<x-guest-layout>
    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <x-slot name="script">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    </x-slot>

    <!-- Bagian Login -->
    <section class="min-h-screen flex items-center justify-center">
        <div
            class="bg-[#DCE8FF] mx-5 md:mx-2 mt-25 mb-10 p-6 md:p-8 rounded-lg border border-gray-200 shadow-lg max-w-lg w-full">
            <div class="flex flex-col items-center gap-2 mb-6">
                <!-- Logo -->
                <img src="{{ asset('img/application-logo.svg') }}" alt="Logo DP3A Sulut" class="w-20 h-20">
                <!-- Teks -->
                <h2 class="text-center text-lg font-semibold leading-tight">
                    Dinas Pemberdayaan Perempuan dan Perlindungan Anak
                </h2>
            </div>

            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" autofocus required
                        class="mt-1 p-2 w-full bg-white text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @error('email')
                        <div class="mt-1 text-xs text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 p-2 w-full bg-white text-sm border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <!-- Remember Me & Lupa Password -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="flex items-center text-sm text-gray-600">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="h-4 w-4 text-blue-700 focus:ring-blue-800 border-gray-300 rounded">
                        <span class="ml-2">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-700 hover:underline">Lupa password?</a>
                </div>

                <!-- Google reCAPTCHA -->
                <div>
                    <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                    @error('g-recaptcha-response')
                        <div class="text-xs text-red-500">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-[#141652] text-white text-sm px-4 py-2 rounded-md shadow-sm hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Login
                </button>
            </form>
        </div>
    </section>

</x-guest-layout>
