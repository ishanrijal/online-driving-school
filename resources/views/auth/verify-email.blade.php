@extends('layout')
@section('title', 'Register')
@section('content')
    <div class="row">
        <div class="col-sm-12" style="padding: 0 48px">
            <div class="signup-box">
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <h1>Verification Email</h1>
                    </div>
                    <div class="card-body" style="padding: 48px">
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Thanks for signing up! Before getting started, admin needs to verify your email address. So, please wait for a moment.') }}
                        </div>
            
                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                            </div>
                        @endif
                        <div style="margin-top: 24px">
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
            </div>
        </div>
    </div>
@endsection('content')
