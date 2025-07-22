@props([
    'type' => session('flash.type', 'info'),
    'message' => session('flash.message'),
])

@if ($message)
    @php
        $colors = [
            'success' => 'green',
            'error' => 'red',
            'warning' => 'yellow',
            'info' => 'blue',
        ];
        $color = $colors[$type] ?? 'blue';
    @endphp

    <div x-data="{ show: true }" x-show="show" x-transition
        class="mb-4 rounded-lg border border-{{ $color }}-300 bg-{{ $color }}-100 px-4 py-3 text-{{ $color }}-800 relative"
        role="alert">
        <span class="block text-sm font-medium">{{ $message }}</span>
        <button type="button"
            class="absolute top-2 right-2 text-{{ $color }}-800 hover:text-{{ $color }}-900"
            @click="show = false">
            &times;
        </button>
    </div>
@endif
