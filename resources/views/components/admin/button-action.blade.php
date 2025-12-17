@props([
    'title' => '',
    'wireAction' => '',
    'theme' => 'dark',
    'icon' => 'fas fa-cube',
])

<button data-coreui-toggle="tooltip" title="{{ $title }}" {{ $attributes->merge(['type' => 'submit', 'class' => "btn btn-$theme btn-sm text-uppercase"]) }}>
    <i class="{{ $icon }} fa-fw" wire:loading.remove wire:target="{{ $wireAction }}"></i>
    <span wire:loading wire:target="{{ $wireAction }}">
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
    </span>
    {{ $slot }}
</button>
