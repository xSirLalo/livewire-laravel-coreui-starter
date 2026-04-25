@props([
    'theme' => 'dark',
    'icon' => null,
    'title' => null,
    'route' => null,
    'url' => null,
    'href' => null,
    'click' => null,
    'target' => null,
    'back' => false,
])

@php
    if ($route) $href = route($route);
    else if ($url) $href = url($url);

    $attributes = $attributes->class([
        "btn btn-$theme btn-sm text-uppercase",
    ])->merge([
        'type' => $click ? 'button' : null,
        'title' => $title,
        'href' => $href,
        'wire:click' => $click,
    ]);
@endphp

@if ($back)
    <a data-coreui-toggle="tooltip" title="{{ __('Return Back') }}" class="btn btn-warning btn-sm" onclick="window.history.back();">
        <x-admin.icon name="reply" />
        {{ $slot }}
    </a>
@else
    <{{ $href ? 'a' : 'button' }} {{ $attributes }} @if ($title) data-coreui-toggle="tooltip" @endif>
        @if ($target)
            <x-admin.icon :name="$icon" wire:loading.remove wire:target="{{ $target }}"/>
            <span wire:loading wire:target="{{ $target }}">
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            </span>
        @else
            <x-admin.icon :name="$icon"/>
        @endif
        {{ $slot }}
    </{{ $href ? 'a' : 'button' }}>
@endif
