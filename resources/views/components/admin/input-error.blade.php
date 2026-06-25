@props(['for'])

@error($for)
    <div {{ $attributes->merge(['class' => 'invalid-feedback']) }}>
        <strong>{{ $message }}</strong>
    </div>
@enderror
