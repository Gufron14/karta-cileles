@props(['active' => false])

@php
    $classes = $active ?? false ? 'nav-link active fw-bold text-light' : 'nav-link';
@endphp

<li class="nav-item">
    <a wire:navigate {{ $attributes->merge(['class' => $classes]) }}> {{ $slot }} </a>
</li> 