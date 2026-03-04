@props(['href', 'active' => false])
@php
$classes = $active
    ? 'inline-block px-4 py-2 text-blue-600 border-b-2 border-blue-600 font-semibold'
    : 'inline-block px-4 py-2 text-gray-700 hover:text-blue-600';
@endphp
<a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
