<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="container-fluid">
        <div class="row">
            <header class="navbar navbar-expand-lg navbar-light bg-primary home-header"> 
                <div class="col-sm-10 header-left-container">
                    <p class="tt-box-location">
                        <a href="#" target="blank" rel="nofollow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="0.75em" height="1em" viewBox="0 0 384 512">
                                <path fill="currentColor" d="M172.268 501.67C26.97 291.031 0 269.413 0 192C0 85.961 85.961 0 192 0s192 85.961 192 192c0 77.413-26.97 99.031-172.268 309.67c-9.535 13.774-29.93 13.773-39.464 0M192 272c44.183 0 80-35.817 80-80s-35.817-80-80-80s-80 35.817-80 80s35.817 80 80 80" />
                            </svg>
                            <span>Hornsby, NSW, 2077, Sydney</span>					
                        </a>
                    </p>
                    <p class="tt-box-phone">
                        <a href="tel:0404756988">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24"><path fill="currentColor" d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.28-.28.67-.36 1.02-.25c1.12.37 2.32.57 3.57.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57c.11.35.03.74-.25 1.02z"/></svg>
                            <i class="icon-phone-call"></i>
                            <span>0404756988</span>		  
                        </a>
                    </p>
                    <p class="tt-box-email">
                        <a href="mailto:info@origindrivingschool.com">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M502.3 190.8c3.9-3.1 9.7-.2 9.7 4.7V400c0 26.5-21.5 48-48 48H48c-26.5 0-48-21.5-48-48V195.6c0-5 5.7-7.8 9.7-4.7c22.4 17.4 52.1 39.5 154.1 113.6c21.1 15.4 56.7 47.8 92.2 47.6c35.7.3 72-32.8 92.3-47.6c102-74.1 131.6-96.3 154-113.7M256 320c23.2.4 56.6-29.2 73.4-41.4c132.7-96.3 142.8-104.7 173.4-128.7c5.8-4.5 9.2-11.5 9.2-18.9v-19c0-26.5-21.5-48-48-48H48C21.5 64 0 85.5 0 112v19c0 7.4 3.4 14.3 9.2 18.9c30.6 23.9 40.7 32.4 173.4 128.7c16.8 12.2 50.2 41.8 73.4 41.4" />
                            </svg>
                            <span>info@origindrivingschool.com</span>		  
                        </a>
                    </p>
                </div>
                <div class="col-sm-2">
                    <ul class="social-icon-wrapper">
                        <li> <a href="https://www.facebook.com" target="blank"><i class="fa-brands fa-facebook"></i></a> </li>
                        <li> <a href="https://www.instagram.com" target="blank"><i class="fa-brands fa-instagram"></i></a> </li>
                        <li> <a href="https://www.tiktok.com" target="blank"><i class="fa-brands fa-tiktok"></i></a> </li>
                        <li> <a href="https://www.x.com" target="blank"><i class="fa-brands fa-x"></i></a> </li>
                    </ul>
                </div>
            </header>
        </div>
        <div class="row">
            <nav class="navbar navbar-expand-lg navbar-light bg-light" style="padding: 24px 48px">
                <a class="navbar-brand" href="/">Origin Driving School</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
            
                <div class="collapse navbar-collapse home-nav" id="navbarSupportedContent">
                    <ul class="col-sm-10 navbar-nav mr-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="/">Hom</a>
                        </li>
                        <li class="nav-item active">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#our-program">Our Program</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#Js">Why Us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#testimonial">Testimonial</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#pricing">Pricing</a>
                        </li>
                    </ul>

                    <div class="col-sm-2 nav-form">
                        @if (Route::has('login'))
                            @auth
                                @if (Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                                    <a href="{{ url('/admin/dashboard') }}" class="btn btn-outline-primary my-2 my-sm-0">Admin Dashboard</a>
                                @elseif (Auth::user()->role === 'instructor')
                                    <a href="{{ url('/instructor/dashboard') }}" class="btn btn-outline-primary my-2 my-sm-0">Instructor Dashboard</a>
                                @elseif (Auth::user()->role === 'student')
                                    <a href="{{ url('/student/dashboard') }}" class="btn btn-outline-primary my-2 my-sm-0">Student Dashboard</a>
                                @elseif (Auth::user()->role === 'staff')
                                    <a href="{{ url('/staff/dashboard') }}" class="btn btn-outline-primary my-2 my-sm-0">Staff Dashboard</a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary my-2 my-sm-0">Login</a>
                                
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-outline-primary my-2 my-sm-0">Signup</a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </nav>
        </div>
    </div>