<div class="container">
    <x-slot name="breadcrumb">
        <x-admin.breadcrumb>
            @foreach ($this->getBreadcrumbItems() as $item)
                @if ($item['active'])
                    <x-admin.breadcrumb-item type="active">{{ $item['title'] }}</x-admin.breadcrumb-item>
                @else
                    <x-admin.breadcrumb-item route="{{ $item['route'] }}">{{ $item['title'] }}</x-admin.breadcrumb-item>
                @endif
            @endforeach
        </x-admin.breadcrumb>
    </x-slot>
    <x-admin.card-module>
        <x-slot name="module_name">{{ $module_name_plural }}</x-slot>
        <x-slot name="module_icon">{{ $module_icon }}</x-slot>
        <x-slot name="module_action">{{ $module_action }}</x-slot>
        <x-slot name="toolbar">
            <x-admin.button-link route='{{ route("admin.$module_name.create") }}' theme="primary" icon="fas fa-plus" title="{{ __('Add') . ' ' . __(Str::title($module_name)) }}" />
        </x-slot>
        <livewire:admin.user.user-table :$module_name lazy />
    </x-admin.card-module>
</div>
