@props(['action'])

<input type="hidden" name="recaptcha_token" id="recaptcha_token">

@push('scripts')
    <script src="https://www.google.com/recaptcha/api.js?render={{ env('RECAPTCHA_SITE_KEY') }}"></script>
    <script>
        grecaptcha.ready(function() {
            grecaptcha.execute('{{ env('RECAPTCHA_SITE_KEY') }}', {
                action: '{{ $action ?? 'general' }}'
            }).then(function(token) {
                document.getElementById('recaptcha_token').value = token;
            });
        });
    </script>
@endpush
