@props(['route' => '#', 'icon' => '', 'title' => '', 'type' => ''])

@if ($type)
    <li class="breadcrumb-item active">
        <span>
            @if ($icon)
                <i class="{{ $icon }} icon fa-fw"></i>
            @endif
            {{ __(Str::title($slot)) }}
        </span>
    </li>
@else
    <li class="breadcrumb-item">
        <a href='{{ $route }}'>
            {{ __(Str::title($slot)) }}
        </a>
    </li>
@endif
