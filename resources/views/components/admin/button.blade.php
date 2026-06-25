@props([
    'theme' => 'dark',
])

<button {{ $attributes->merge(['type' => 'submit', 'class' => "btn btn-$theme btn-sm text-uppercase"]) }}>
    {{ $slot }}
</button>
