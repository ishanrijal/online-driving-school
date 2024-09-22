@extends('layout')
@section('title', 'Register')
@section('content')
<div class="row">
    <div class="col-sm-12" style="padding: 0 48px">
        <div class="signup-box">
            <div class="card card-outline card-primary">
                @if (session('registration-fail'))
                    <div class="col-sm-12">
                        <div class="alert alert-success">
                            {{ session('registration-fail') }}
                        </div>
                    </div>
                @endif
                <div class="card-header text-center">
                    <h1>Register User</h1>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Register a new user</p>
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <x-text-input placeholder="Name" id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="0.88em" height="1em" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M224 256c70.7 0 128-57.3 128-128S294.7 0 224 0S96 57.3 96 128s57.3 128 128 128m89.6 32h-16.7c-22.2 10.2-46.9 16-72.9 16s-50.6-5.8-72.9-16h-16.7C60.2 288 0 348.2 0 422.4V464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48v-41.6c0-74.2-60.2-134.4-134.4-134.4" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <x-input-error class="text-danger" :messages="$errors->get('name')" />

                        <div class="input-group mb-3">
                            <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="email" placeholder="Email" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7c22.4 17.4 52.1 39.5 154.1 113.6c21.1 15.4 56.7 47.8 92.2 47.6c35.7.3 72-32.8 92.3-47.6c102-74.1 131.6-96.3 154-113.7M256 320c23.2.4 56.6-29.2 73.4-41.4c132.7-96.3 142.8-104.7 173.4-128.7c5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9c30.6 23.9 40.7 32.4 173.4 128.7c16.8 12.2 50.2 41.8 73.4 41.4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <x-input-error class="text-danger" :messages="$errors->get('email')" />
                        
                        <div class="input-group mb-3">
                            <select name="role" class="">
                                <option value="admin">Admin</option>
                                <option value="student">Student</option>
                                <option value="staff">Staff</option>
                                <option value="instructor">Instructor</option>
                            </select>
                        </div>

                        <div class="input-group mb-3">
                            <x-text-input id="password" class="form-control" placeholder="Password"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1em" viewBox="0 0 640 512">
                                        <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144 144 0 0 1-26 2.61m313.82 58.1l-110.55-85.44a331.3 331.3 0 0 0 81.25-102.07a32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="text-danger" />
                        
                        <div class="input-group mb-3">
                            <x-text-input id="password_confirmation" class="form-control" placeholder="Confirm Password"
                            type="password"
                            name="password_confirmation"
                            required autocomplete="new-password" />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="1.25em" height="1em" viewBox="0 0 640 512">
                                        <path fill="currentColor" d="M320 400c-75.85 0-137.25-58.71-142.9-133.11L72.2 185.82c-13.79 17.3-26.48 35.59-36.72 55.59a32.35 32.35 0 0 0 0 29.19C89.71 376.41 197.07 448 320 448c26.91 0 52.87-4 77.89-10.46L346 397.39a144 144 0 0 1-26 2.61m313.82 58.1l-110.55-85.44a331.3 331.3 0 0 0 81.25-102.07a32.35 32.35 0 0 0 0-29.19C550.29 135.59 442.93 64 320 64a308.15 308.15 0 0 0-147.32 37.7L45.46 3.37A16 16 0 0 0 23 6.18L3.37 31.45A16 16 0 0 0 6.18 53.9l588.36 454.73a16 16 0 0 0 22.46-2.81l19.64-25.27a16 16 0 0 0-2.82-22.45"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger" />
                        
                        <div class="flex items-center justify-end mt-4">
                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('login') }}">
                                {{ __('Already have an account?') }}
                            </a>

                            <div class="social-auth-links text-center mt-2 mb-3">
                                <x-primary-button class="btn btn-primary btn-block">
                                {{ __('Register') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection