@props(['status'])

@php
    $classes = match ($status) {
        'Aman' => 'bg-green-100 text-green-700',
        'Menipis' => 'bg-yellow-100 text-yellow-700',
        'Habis' => 'bg-red-100 text-red-700',
        default => 'bg-gray-100 text-gray-700',
    };
@endphp

<span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $classes }}">
    {{ $status }}
</span>