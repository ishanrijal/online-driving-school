@extends('layout')
@section('title', 'Login')
@section('content')
        <div class="row">
            <div class="col-sm-12" style="padding: 0 48px">
                <div class="signup-box">
                    <x-auth-session-status class="mb-4" :status="session('status')" />
                    <div class="card card-outline card-primary">
                        <div class="card-header text-center">
                            <h1>Forgot Password</h1>
                        </div>
                        <div class="card-body">
                            <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
                            </div>
                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf
                                <div class="input-group mb-3">
                                    <x-text-input placeholder="Email" id="email" class="form-control" type="email" name="email" :value="old('email')" required autofocus autocomplete="email" />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512"><path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7c22.4 17.4 52.1 39.5 154.1 113.6c21.1 15.4 56.7 47.8 92.2 47.6c35.7.3 72-32.8 92.3-47.6c102-74.1 131.6-96.3 154-113.7M256 320c23.2.4 56.6-29.2 73.4-41.4c132.7-96.3 142.8-104.7 173.4-128.7c5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9c30.6 23.9 40.7 32.4 173.4 128.7c16.8 12.2 50.2 41.8 73.4 41.4"/></svg>
                                        </div>
                                    </div>
                                    <br/>
                                </div>
                                <div class="forgot-password-box">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2 alert text-danger" />
                                </div>
                                <div class="flex items-center justify-end mt-4">   
                                    <div class="social-auth-links text-center mt-2 mb-3">
                                        <x-primary-button class="btn btn-primary btn-block">
                                            {{ __('Email Password Reset Link') }}
                                        </x-primary-button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection