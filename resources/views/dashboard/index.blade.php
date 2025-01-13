<x-app-layout>

    @section('title')
        @isset($title)
            | {{ $title }}
        @endisset
    @endsection

</x-app-layout>
