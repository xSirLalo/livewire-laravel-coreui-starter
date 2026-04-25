{{--
    Componente de input mejorado con soporte para Livewire v3 y Laravel 12

    Ejemplos de uso:

    Form-floating con live:
    <x-admin.input label="Nombre" model="form.name" live required />

    Input normal (sin floating):
    <x-admin.input label="Email" type="email" model="form.email" :floating="false" />

    Con debounce personalizado:
    <x-admin.input label="Búsqueda" model="search" :debounce="500" />

    Número con lazy:
    <x-admin.input label="Edad" type="number" model="form.age" lazy />

    Deshabilitado y readonly:
    <x-admin.input label="ID" model="form.id" disabled readonly />

    Con placeholder personalizado:
    <x-admin.input label="Nombre" model="form.name" placeholder="Ingrese su nombre completo" />
--}}

@props([
    'label' => null,
    'type' => 'text',
    'model',
    'placeholder' => null,
    'disabled' => false,
    'readonly' => false,
    'required' => false,
    'lazy' => false,
    'live' => false,
    'debounce' => null,
    'floating' => true,
])

@php
    // Determinar el inputmode basado en el tipo
    $inputmode = match($type) {
        'number' => 'decimal',
        'tel', 'search', 'email', 'url' => $type,
        default => 'text',
    };

    // Determinar el modificador de wire:model
    $wireModifier = match(true) {
        $lazy => '.lazy',
        $live => '.live',
        is_numeric($debounce) => ".live.debounce.{$debounce}ms",
        $debounce === true => '.live.debounce',
        default => '',
    };

    // Generar el ID si no se proporciona
    $inputId = $attributes->get('id', $model);

    // Placeholder por defecto
    $placeholderText = $placeholder ?? $label ?? '';

    // Construir atributos del input
    $inputAttributes = $attributes->class([
        'form-control',
        'is-invalid' => $errors->has($model),
    ])->merge([
        'type' => $type,
        'inputmode' => $inputmode,
        'id' => $inputId,
        'placeholder' => $placeholderText,
    ]);
@endphp

@if($floating)
    <div class="form-floating">
        <input
            {{ $inputAttributes }}
            wire:model{{ $wireModifier }}="{{ $model }}"
            @if($disabled) disabled @endif
            @if($readonly) readonly @endif
            @if($required) required @endif
        >
        @if($label)
            <label for="{{ $inputId }}">{{ $label }}@if($required) <span class="text-danger">*</span>@endif</label>
        @endif
        @error($model)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
@else
    @if($label)
        <label for="{{ $inputId }}" class="form-label">
            {{ $label }}@if($required) <span class="text-danger">*</span>@endif
        </label>
    @endif
    <input
        {{ $inputAttributes }}
        wire:model{{ $wireModifier }}="{{ $model }}"
        @if($disabled) disabled @endif
        @if($readonly) readonly @endif
        @if($required) required @endif
    >
    @error($model)
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
@endif
