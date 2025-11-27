@extends('layouts.guest')

@section('content')
    <div class="bg-body-tertiary min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h1>{{ __('Verify Your Email Address') }}</h1>
                            <p class="text-body-secondary">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>

                            @if (session('status') == 'verification-link-sent')
                                <div class="alert alert-success" role="alert">
                                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <div class="row d-flex justify-content-between">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary px-4">
                                            {{ __('Resend Verification Email') }}
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="btn btn-link">
                                                {{ __('Log Out') }}
                                            </button>
                                        </form>
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
