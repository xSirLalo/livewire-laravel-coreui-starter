@props([
    'module_name' => __('Untitled Module'),
    'module_action' => '',
    'module_icon' => 'fas fa-cube',
    'module_model' => null,
])

<div class="card">
    <div class="card-header">
        <div class="row d-flex justify-content-between align-items-center">
            <div class="col-auto">
                <i class="{{ $module_icon }}"></i>
                <span class="h5">{{ __(Str::title($module_name)) }}</span>
                <small class="text-muted">{{ __(Str::title($module_action)) }}</small>
                <div>
                    <small class="text-muted">
                        {{ __(':module_name Management Dashboard', ['module_name' => __(Str::title($module_name))]) }}
                    </small>
                </div>
            </div>
            <div class="col-auto">
                {{ $toolbar }}
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $slot }}
        @if ($module_model)
            <div class="float-end">
                <small class="text-muted">
                    {{ __('Updated at') }}: {{ $module_model->updated_at->diffForHumans() }},
                    {{ __('Created at') }}: {{ $module_model->created_at->isoFormat('LLLL') }}
                </small>
            </div>
        @endif
    </div>
</div>
