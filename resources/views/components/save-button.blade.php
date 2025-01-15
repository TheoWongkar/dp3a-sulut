<button type="{{ $type ?? 'button' }}"
    class="{{ $class ?? 'bg-[#141652] hover:bg-blue-800 text-white px-6 py-2 rounded-lg transition duration-200' }}"
    {{ $attributes }}>
    {{ $slot }}
</button>
