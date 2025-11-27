@extends('layouts.guest')

@section('content')
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h1>{{ __('Reset Password') }}</h1>
                            <p class="text-body-secondary">{{ __('Enter your new password') }}</p>

                            <form method="POST" action="{{ route('password.store') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="cil-envelope-open icon"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email') }}" value="{{ old('email', $request->email) }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="cil-lock-locked icon"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="new-password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="input-group mb-4">
                                    <span class="input-group-text">
                                        <i class="cil-lock-locked icon"></i>
                                    </span>
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="{{ __('Confirm Password') }}" required>
                                </div>

                                <div class="row">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary px-4">
                                            {{ __('Reset Password') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
