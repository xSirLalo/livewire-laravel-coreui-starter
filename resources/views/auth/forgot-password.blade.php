@extends('layouts.guest')

@section('content')
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h1>{{ __('Reset Password') }}</h1>
                            <p class="text-body-secondary">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p>

                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class="input-group mb-3">
                                    <span class="input-group-text">
                                        <i class="cil-envelope-open icon"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="row d-flex justify-content-between">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary px-4">
                                            {{ __('Email Password Reset Link') }}
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <a class="btn btn-link" href="{{ route('login') }}">
                                            {{ __('Back to login') }}
                                        </a>
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
