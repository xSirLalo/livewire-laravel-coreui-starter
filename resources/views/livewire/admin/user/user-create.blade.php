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
    <x-admin.validation-errors />
    <x-admin.card-module>
        <x-slot name="module_name">{{ $module_name_plural }}</x-slot>
        <x-slot name="module_icon">{{ $module_icon }}</x-slot>
        <x-slot name="module_action">{{ $module_action }}</x-slot>
        <x-slot name="toolbar">
            <x-admin.button-back />
            <x-admin.button-link route='{{ route("admin.$module_name.index") }}' theme="secondary" icon="fas fa-list" title="{{ __('List of') . ' ' . __(Str::title($module_name_plural)) }}" />
        </x-slot>
        <form wire:submit="store" onkeydown="return event.key != 'Enter';" autocomplete="off">
            <x-admin.card class="mb-3">
                <x-slot name="title">General</x-slot>
                <div class="row g-2">
                    <div class="col-md-12">
                        <x-admin.input label="{{ __('Name') }}" input="form.name" required="true" />
                    </div>
                    <div class="col-md-12">
                        <x-admin.input label="{{ __('Email') }}" input="form.email" />
                    </div>
                    <div class="col-md-12">
                        <div class="input-group">
                            <div class="form-floating">
                                <input id="floatingPassword" type="password" class="form-control" name="form.password" placeholder="{{ __('Password') }}" aria-label="{{ __('Password') }}" aria-describedby="togglePassword" wire:model="form.password" wire:keydown="updatePassword" autocomplete="new-password">
                                <label for="floatingPassword">{{ __('Password') }}</label>
                            </div>
                            <span id="togglePassword" class="input-group-text" data-coreui-toggle="tooltip" title="{{ __('Toggle Password Visibility') }}" tabindex="0" role="button" onclick="togglePasswordVisibility('floatingPassword')"><i class="fas fa-eye-slash fa-fw"></i></span>
                            <span class="input-group-text" data-coreui-toggle="tooltip" title="{{ __('Generate Password') }}" tabindex="0" role="button" wire:click="generatePassword">
                                <i class="fas fa-arrows-rotate fa-fw" wire:loading.remove wire:target="generatePassword"></i>
                                <i class="fas fa-spinner fa-spin fa-fw" wire:loading wire:target="generatePassword"></i>
                            </span>
                        </div>
                        @push('js')
                            <script>
                                function togglePasswordVisibility(inputId) {
                                    const input = document.getElementById(inputId);
                                    const toggleIcon = document.getElementById('togglePassword');
                                    if (input.type === 'password') {
                                        input.type = 'text';
                                        toggleIcon.innerHTML = '<i class="fas fa-eye fa-fw"></i>';
                                    } else {
                                        input.type = 'password';
                                        toggleIcon.innerHTML = '<i class="fas fa-eye-slash fa-fw"></i>';
                                    }
                                }
                            </script>
                        @endpush
                    </div>
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input id="floatingPasswordConfirmation" type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" wire:model="form.password_confirmation" autocomplete="new-password">
                            <label for="floatingPasswordConfirmation">{{ __('Confirm Password') }}</label>
                            @error($form->password_confirmation)
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </x-admin.card>
            <div class="float-end">
                <x-admin.button-link route='{{ route("admin.$module_name.index") }}' theme="warning" icon="fas fa-x" title="{{ __('Cancel') }}" />
                <x-admin.button-action theme="primary" icon="fas fa-floppy-disk" title="{{ __('Save') . ' ' . __(Str::title($module_name)) }}" wireAction="store" />
            </div>
        </form>
    </x-admin.card-module>
</div>
