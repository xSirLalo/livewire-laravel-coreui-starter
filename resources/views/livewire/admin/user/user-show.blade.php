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
    <x-admin.card-module :$module_model>
        <x-slot name="module_name">{{ $module_name_plural }}</x-slot>
        <x-slot name="module_icon">{{ $module_icon }}</x-slot>
        <x-slot name="module_action">{{ $module_action }}</x-slot>
        <x-slot name="toolbar">
            <x-admin.button-back />
            <x-admin.button-link route='{{ route("admin.$module_name.index") }}' theme="secondary" icon="fas fa-list" title="{{ __('List of') . ' ' . __(Str::title($module_name_plural)) }}" />
            <x-admin.button-link route='{{ route("admin.$module_name.edit", $module_model->id) }}' theme="info" icon="fas fa-pencil-alt" title="{{ __('Edit') . ' ' . __(Str::title($module_name)) }}" />
        </x-slot>
        <x-admin.table :center="true">
            <x-slot name="thead">
                <tr>
                    <th>
                        {{ __('Name') }}
                    </th>
                    <th>
                        {{ __('Value') }}
                    </th>
                </tr>
            </x-slot>
            <x-slot name="tbody">
                <tr>
                    <th>{{ __('Name') }}</th>
                    <td>{{ $module_model->name }}</td>
                </tr>
                <tr>
                    <th>{{ __('Email') }}</th>
                    <td>{{ $module_model->email }}</td>
                </tr>
            </x-slot>
        </x-admin.table>
    </x-admin.card-module>
</div>
