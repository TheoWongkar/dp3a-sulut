<x-app-layout>

    <!-- Judul Halaman -->
    <x-title :title=$title></x-title>

    <!-- Bagian Profil -->
    <section>
        <div class="flex flex-col lg:flex-row gap-6">
            <!-- Update Profile -->
            <div class="w-full lg:w-1/2">
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>
            </div>
            <!-- Update Password -->
            <div class="w-full lg:w-1/2">
                <div class="bg-white shadow-lg rounded-lg p-8">
                    <div class="max-w-xl">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-app-layout>
