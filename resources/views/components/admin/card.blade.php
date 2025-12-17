@props(['bodyClass' => ''])

<div {{ $attributes->class(['card']) }}>
    <div class="card-header">
        <strong>{{ $title }}</strong>
    </div>
    <div class="card-body {{ $bodyClass }}">
        {{ $slot }}
    </div>
</div>
