{{-- blade-formatter-disable --}}
@props([
    'input' => '',
    'name' => '',
    'label' => '',
    'placeholder' => '',
    'disabled' => false,
    'required' => false,
])

<div class="form-floating">
    <input
        id="{{ $input }}"
        {{ $attributes->class([
            'form-control',
            'is-invalid' => $errors->has($input)
        ]) }}
        name="{{ $name ?: $input }}"
        placeholder="{{ $placeholder ?: $label }}"
        wire:model="{{ $input }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $required ? 'required' : '' }}
    >
    <label for="{{ $input }}">{{ $label }}</label>
    @error($input)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
