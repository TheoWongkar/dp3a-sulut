<x-guest-layout>

    <!-- Judul Halaman -->
    <x-slot name="title">{{ $title }}</x-slot>

    <!-- Bagian Login -->
    <section class="min-h-screen flex items-center justify-center">
        <div class="bg-[#DCE8FF] mx-5 px-5 py-5 md:mt-10 md:px-8 md:py-5 rounded-lg shadow-xl max-w-lg w-full">
            <div class="flex flex-col items-center mb-5">
                <!-- Logo -->
                <x-application-logo class="h-20 mb-1" />
                <!-- Teks -->
                <div class="text-center">
                    <h2 class="text-sm md:text-lg justify-center font-semibold">Dinas Pemberdayaan Perempuan dan
                        Perlindungan Anak</h2>
                </div>
            </div>
            <!-- Form Login -->
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-xs font-medium text-gray-700">Email</label>
                    <input id="email" type="email" name="email" autofocus
                        class="mt-1 p-2 w-full bg-white text-xs border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                    @error('message')
                        <div class="text-xs text-red-500">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Password -->
                <div class="mb-2">
                    <label for="password" class="block text-xs font-medium text-gray-700">Password</label>
                    <input id="password" type="password" name="password"
                        class="mt-1 p-2 w-full bg-white text-xs border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring">
                </div>
                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-2">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember"
                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:underline">Lupa password?</a>
                </div>
                <!-- Google reCAPTCHA dan Login -->
                <div class="space-y-2">
                    <!-- Google reCAPTCHA v2 -->
                    <div>
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @error('g-recaptcha-response')
                            <div class="text-red-500 text-xs">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Login Button -->
                    <div>
                        <button type="submit"
                            class="w-full flex justify-center bg-[#141652] text-white px-4 py-2 rounded-md shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            Login
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </section>

</x-guest-layout>
