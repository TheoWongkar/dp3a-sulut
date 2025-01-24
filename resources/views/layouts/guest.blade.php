<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="{{ asset('img/app-logo.svg') }}" type="image/x-icon">

    <title>
        DP3A Sulut -
        @yield('title')
    </title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="font-sans text-[#141652]">

    @include('layouts.navigation-guest')

    <main>
        <!-- Chat Container -->
        <x-chatbot></x-chatbot>

        {{ $slot }}
    </main>

    @include('layouts.footer-guest')

    <script>
        $(document).ready(function() {
            const chatContainer = $('#chat-container');
            const chatForm = $('#chat-form');

            // Fungsi Scroll Otomatis Ke Bawah
            function scrollToBottom() {
                chatContainer.scrollTop(chatContainer[0].scrollHeight);
            }

            // Handle Form
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                const message = $('#message').val();
                if (!message) return;

                // Apend Pesan
                chatContainer.append(`
                    <div class="text-right">
                        <div class="inline-block bg-blue-600 text-white text-sm px-4 py-2 rounded-lg max-w-[80%] break-words">
                            ${message}
                        </div>
                    </div>
                `);

                // Clear Input
                $('#message').val('');

                // Scroll ke Bawah
                scrollToBottom();

                // Kirim Pesan Ke Server
                $.ajax({
                    url: "{{ route('chatbot.send') }}",
                    method: "POST",
                    data: {
                        message: message,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        chatContainer.append(`
                            <div class="text-left">
                                <div class="inline-block bg-gray-200 text-sm px-4 py-2 rounded-lg">
                                    ${response.bot_response}
                                </div>
                            </div>
                        `);
                        chatContainer.scrollTop(chatContainer[0].scrollHeight);
                    },
                    error: function() {
                        chatContainer.append(`
                            <div class="text-left">
                                <div class="inline-block bg-red-200 text-red-600 text-sm px-4 py-2 rounded-lg">
                                    Maaf, terjadi kesalahan saat menghubungi bot.
                                </div>
                            </div>
                        `);
                    }
                });
            });
        });
    </script>

</body>

</html>
