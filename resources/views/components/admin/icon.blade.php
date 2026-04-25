@props([
    'name',
    'style' => 'solid',
])

@php
    $attributes = $attributes->class([
        'fa' . Str::limit($style, 1, null) . ' fa-' . $name,
    ])->merge([
        //
    ]);
@endphp

<i {{ $attributes }}></i>
