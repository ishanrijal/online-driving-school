<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    {{-- <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"> --}}
    
    <link rel="stylesheet" href="{{ asset('assets/css/style-main.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <aside class="main-sidebar">
            <div class="logo">
                <span class="logo-text">Origin Driving</span>
            </div>
            <div class="sidebar dashboard-sidenav">
                <nav class="mt-2">
                    <ul class="nav nav-wrapper flex-column">
                        <li class="nav-item">
                            <a href="/admin/dashboard" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="instructor" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <span>Instructor</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="student" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Students</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="staff" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Staff</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Training</span>
                            </a>
                        </li>                  
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Vehicles</span>
                            </a>
                        </li> 
                        <form action="{{ route('logout') }}" method="post">
                            @csrf
                            <div class="social-auth-links text-center mt-2 mb-3">
                                <button type="submit" class="btn btn-primary btn-block">Logout</button>
                            </div>
                        </form>                 
                    </ul>
                </nav>
            </div>
        </aside>
        <div style="width:100%">
            <nav class="main-header navbar navbar-light">
                <div class="header-left-container">
                    <h2>Origin Driving Admin Panel</h2>
                </div>
                <div class="header-right-container">
                    <div class="dropdown">
                        <a href="#" class="d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ asset('path/to/profile-image.jpg') }}" alt="Profile Image" class="rounded-circle" style="width: 40px; height: 40px;">
                        </a>
                        <strong>{{ Auth::user()->role }}</strong>
        
                        <!-- Dropdown Menu -->
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <li>
                                {{-- <a class="dropdown-item" href="{{ route('profile.show') }}"> --}}
                                <a class="dropdown-item" href="#">
                                    <strong>{{ Auth::user()->name }}</strong><br>
                                    <small>{{ Auth::user()->role }}</small>
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">View Profile</a></li>
                            {{-- <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Edit Profile</a></li> --}}
                            <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                        </ul>
        
                        <!-- Logout Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </nav>
            @yield('content')
        </div>
        


{{-- 
        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io/">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>

        <aside class="control-sidebar control-sidebar-dark">

        </aside> --}}

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>