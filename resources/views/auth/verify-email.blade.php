@extends('layout')
@section('title', 'Register')
@section('content')
    <div class="row">
        <div class=" login-box card card-outline card-primary">
            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf

                    <div class="social-auth-links text-center mt-2 mb-3">
                        <x-primary-button type="submit" class="btn btn-primary btn-block">
                            {{ __('Resend Verification Email') }}
                        </x-primary-button>
                    </div>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <div class="social-auth-links text-center mt-2 mb-3">
                        <x-primary-button type="submit" class="btn btn-primary btn-block">
                            {{ __('Log Out') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection('content')
