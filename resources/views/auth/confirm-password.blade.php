@extends('layouts.guest')

@section('content')
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h1>{{ __('Confirm Password') }}</h1>
                            <p class="text-body-secondary">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

                            <form method="POST" action="{{ route('password.confirm') }}">
                                @csrf

                                <div class="input-group mb-4">
                                    <span class="input-group-text">
                                        <i class="cil-lock-locked icon"></i>
                                    </span>
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password" autofocus>
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary px-4">
                                            {{ __('Confirm') }}
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
