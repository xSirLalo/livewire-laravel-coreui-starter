@props([
    'center' => false,
    'theme' => 'dark',
])

@php
$theme = [
    'light' => ' table-light',
    'none' => '',
    'dark' => ' table-dark',
][$theme ?? 'dark'];
@endphp

<div class="table-responsive">
    <table {{ $attributes->merge(['class' => 'table table-hover table-sm' . ($center ? ' align-middle text-center' : '')]) }}>
        <thead class="text-uppercase{{ $theme }}">
            {{ $thead }}
        </thead>
        <tbody>
            {{ $tbody }}
        </tbody>
    </table>
</div>
