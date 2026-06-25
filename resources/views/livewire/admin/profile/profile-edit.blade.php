<div class="container">
    <x-slot name="breadcrumb">
        <x-admin.breadcrumb>
            <x-admin.breadcrumb-item type="active">Profile</x-admin.breadcrumb-item>
            <x-admin.breadcrumb-item type="active">Edit</x-admin.breadcrumb-item>
        </x-admin.breadcrumb>
    </x-slot>
    <div class="row justify-content-center">
        <div class="col-md-8 mb-4">
            {{-- Profile Information --}}
            <div class="mb-4">
                <div class="card">
                    <div class="card-header">{{ __('Profile Information') }}</div>
                    <div class="card-body">
                        <form wire:submit="updateProfileInformation">

                            {{-- Action Message --}}
                            @if ($profileStatus === 'profile-updated')
                                <div class="alert alert-success fade-out" role="alert">
                                    {{ __('Saved.') }}
                                </div>
                            @endif

                            {{-- Profile Photo --}}
                            <div class="row mb-4">
                                <div class="col-md-8 offset-md-4">
                                    <x-profile-photo-upload :user="auth()->user()" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="name">
                                    {{ __('Name') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" wire:model="name" required autofocus autocomplete="name">
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="email">
                                    {{ __('Email') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" required autocomplete="email">
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @auth
                                        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                                            <div class="mt-2">
                                                <p class="mb-0">
                                                    {{ __('Your email address is unverified.') }}
                                                    <button type="button" class="btn btn-link p-0" wire:click="sendEmailVerification">
                                                        {{ __('Click here to re-send the verification email.') }}
                                                    </button>
                                                </p>
                                                @if (session('status') === 'verification-link-sent')
                                                    <div class="alert alert-success mt-3 mb-0" role="alert">
                                                        {{ __('A new verification link has been sent to your email address.') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                    @if ($profileStatus === 'profile-updated')
                                        <span class="m-1 fade-out">{{ __('Saved.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Update Password --}}
            <div class="mb-4">
                <div class="card">
                    <div class="card-header">{{ __('Update Password') }}</div>
                    <div class="card-body">
                        <div class="mb-3">
                            {{ __('Ensure your account is using a long, random password to stay secure.') }}
                        </div>
                        <form wire:submit="updatePassword">
                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="current_password">
                                    {{ __('Current Password') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" wire:model="current_password" required autocomplete="current-password">
                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="password">
                                    {{ __('New Password') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" wire:model="password" required autocomplete="new-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-md-4 col-form-label text-md-end" for="password_confirmation">
                                    {{ __('Confirm Password') }}
                                </label>
                                <div class="col-md-6">
                                    <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" wire:model="password_confirmation" required>
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
                                    </button>
                                    @if ($passwordStatus === 'password-updated')
                                        <span class="m-1 fade-out">{{ __('Saved.') }}</span>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Delete Account --}}
            <div>
                <div class="card">
                    <div class="card-header">{{ __('Delete Account') }}</div>
                    <div class="card-body">
                        <div class="mb-3">
                            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-danger" wire:click="openDeleteModal">
                                    {{ __('Delete Account') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Delete Account Modal --}}
            @if ($showDeleteModal)
                <div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5">
                                    {{ __('Are you sure you want to delete your account?') }}
                                </h1>
                                <button type="button" class="btn-close" aria-label="Close" wire:click="closeDeleteModal"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                                </div>
                                <form wire:submit="deleteAccount">
                                    <div>
                                        <input type="password" class="form-control @error('delete_password') is-invalid @enderror" placeholder="{{ __('Password') }}" wire:model="delete_password" required>
                                        @error('delete_password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" wire:click="closeDeleteModal">
                                    {{ __('Cancel') }}
                                </button>
                                <button type="button" class="btn btn-danger" wire:click="deleteAccount">
                                    {{ __('Delete Account') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
