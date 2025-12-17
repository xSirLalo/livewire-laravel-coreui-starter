@props([
    'route' => '#',
    'title' => '',
    'icon' => 'fas fa-link',
    'theme' => 'dark',
])

<a data-coreui-toggle="tooltip" href="{{ $route }}" title="{{ $title }}" {{ $attributes->merge(['class' => "btn btn-$theme btn-sm text-uppercase"]) }}>
    <i class="{{ $icon }} fa-fw"></i>
    {{ $slot }}
</a>
