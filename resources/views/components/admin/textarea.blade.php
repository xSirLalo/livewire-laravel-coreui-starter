@props([
    'input' => '',
    'name' => '',
    'label' => '',
    'placeholder' => '',
    'disabled' => false,
    'required' => false,
    'size' => '100px',
])

<div class="form-floating">
    <textarea id="{{ $input }}" class="form-control form-control-sm @error($input) is-invalid @enderror" name="{{ $name ?: $input }}" placeholder="{{ $placeholder ?: $label }}" wire:model="{{ $input }}" style="height: {{ $size }};" {{ $disabled ? 'disabled' : '' }} {{ $required ? 'required' : '' }}></textarea>
    <label for="{{ $input }}">{{ $label }}</label>
    @error($input)
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>
