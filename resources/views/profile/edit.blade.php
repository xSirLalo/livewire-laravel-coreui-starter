<x-app-layout>
    <x-slot name="breadcrumb">
        <ol class="breadcrumb my-0">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active">{{ __('Profile') }}</li>
        </ol>
    </x-slot>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="mb-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="mb-4">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="mb-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
