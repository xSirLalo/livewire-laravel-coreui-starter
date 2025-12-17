@props([
    'options' => [15, 30, 50],
    'filters' => null,
    'search_placeholder' => __('Search'),
])

<div class="row pb-3 g-2">
    <div class="col-md-auto">
        <select class="form-select form-select-sm" wire:model.live="paginate">
            @foreach ($options as $option)
                <option value="{{ $option }}">{{ $option }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-auto">
        <input type='search' class="form-control form-control-sm" placeholder="{{ $search_placeholder }}" wire:model.live='search' />
    </div>
    {{ $slot }}
</div>
