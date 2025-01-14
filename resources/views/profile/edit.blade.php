<x-app-layout>

    <!-- Bagian Title -->
    @section('title')
        @isset($title)
            | {{ $title }}
        @endisset
    @endsection

    <div class="py-5 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Flexbox untuk menata dua kartu dengan responsif -->
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
        </div>
    </div>

</x-app-layout>
