<div class="container-lg px-4">
    <x-slot name="breadcrumb">
        <x-admin.breadcrumb-item type="active">{{ __('Dashboard') }}</x-admin.breadcrumb-item>
    </x-slot>

    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</div>
