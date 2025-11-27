@extends('layouts.guest')

@section('content')
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-group d-block d-md-flex row">
                        <div class="card col-md-7 p-4 mb-0">
                            <div class="card-body">
                                <h1>{{ __('Login') }}</h1>
                                <p class="text-body-secondary">{{ __('Sign In to your account') }}</p>

                                @if (session('status'))
                                    <div class="alert alert-success" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <div class="input-group mb-3">
                                        <span class="input-group-text">
                                            <i class="cil-user icon"></i>
                                        </span>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('Email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="input-group mb-4">
                                        <span class="input-group-text">
                                            <i class="cil-lock-locked icon"></i>
                                        </span>
                                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('Password') }}" required autocomplete="current-password">
                                        @error('password')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <div class="form-check mb-3">
                                        <input id="remember" type="checkbox" class="form-check-input" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember me') }}
                                        </label>
                                    </div>

                                    <div class="row">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary px-4">
                                                {{ __('Login') }}
                                            </button>
                                        </div>
                                        <div class="col-6 text-end">
                                            @if (Route::has('password.request'))
                                                <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                                    {{ __('Forgot password?') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="card col-md-5 text-white bg-primary py-5">
                            <div class="card-body text-center">
                                <div>
                                    <h2>{{ __('Sign up') }}</h2>
                                    <p>{{ __('Create your account and start managing your appointments easily and efficiently.') }}</p>
                                    @if (Route::has('register'))
                                        <a class="btn btn-lg btn-outline-light mt-3" href="{{ route('register') }}">
                                            {{ __('Register Now!') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
