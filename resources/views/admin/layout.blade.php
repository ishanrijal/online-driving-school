<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&amp;display=fallback">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <nav class="main-header navbar navbar-light">
        <div class="header-left-container">
            <div class="logo">
                <span class="logo-text">Origin Driving School</span>
            </div>
        </div>
        <div class="header-right-container">
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    @if( session('staff_image_url') )
                        <img src="{{ session('staff_image_url') }}" alt="Profile Image" class="rounded-circle" style="width: 50px; height: 50px;">
                    @else
                        <img src="https://bootdey.com/img/Content/avatar/avatar7.png" alt="Admin" class="rounded-circle" style="width: 50px; height: 50px;">
                    @endif
                </a>
                <strong class="nav-profile-icon-role">{{ Auth::user()->role }}</strong>
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
    <div class="wrapper">
        <aside class="main-sidebar">
            <div class="sidebar dashboard-sidenav">
                <p class="user-role"><small>{{ Auth::user()->role }}</small></p>
                <nav class="mt-2">
                    <ul class="nav nav-wrapper flex-column">
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.dashboard') ? 'active': ''  }}">
                            <a href="{{route('admin.dashboard')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.user-verify.index') ? 'active': ''  }}">
                            <a href="{{route('admin.user-verify.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <span>New Users</span>
                            </a>
                        </li>
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.instructor.index') ? 'active': ''  }}">
                            <a href="{{route('admin.instructor.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <span>Instructor</span>
                            </a>
                        </li>
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.student.index') ? 'active': ''  }}">
                            <a href="{{route('admin.student.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Students</span>
                            </a>
                        </li>
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.staff.index') ? 'active': ''  }}">
                            <a href="{{route('admin.staff.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Staff</span>
                            </a>
                        </li>
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.classSchedule.index') ? 'active': ''  }}">
                            <a href="{{route('admin.classSchedule.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>View TimeTable</span>
                            </a>
                        </li>                  
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.invoice.index') ? 'active': ''  }}">
                            <a href="{{route('admin.invoice.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Invoice</span>
                            </a>
                        </li> 
                        <li class="nav-item {{ ( Request()->route()->getName() == 'admin.course.index') ? 'active': ''  }}">
                            <a href="{{route('admin.course.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-table"></i>
                                <span>Course</span>
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
        <main class="main-content-wrapper container-fluid">

            @yield('content')
        </div>
    </div>

    <footer class="main-footer">
        <strong>Copyright &copy; {{now()->year}}. All rights reserved <b>{{Auth::user()->role}}</b></strong>
    </footer>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.8/index.global.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        // Pie Chart Data (Replace with actual dynamic data from backend)
        const students_count = {{ session('students_count') ?? 0 }};
        const instructors_count = {{ session('instructors_count') ?? 0 }};
        const staff_count = {{ session('staff_count') ?? 0 }};
        const pieData = {
            labels: ['Students', 'Instructors', 'Staff'],
            datasets: [{
                label: 'Total',
                data: [students_count,instructors_count, staff_count], // Example: 55% Students, 25% Instructors, 20% Staff
                backgroundColor: ['#F91942', '#36A2EB', '#FFCE56'],
                hoverOffset: 4
            }]
        };

        const pieConfig = {
            type: 'pie',
            data: pieData,
        };

        // Create Pie Chart
        const entityPieChart = new Chart(
            document.getElementById('entityPieChart'),
            pieConfig
        );

        // Bar Chart Data (Replace with actual dynamic data from backend)
        const barData = {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'Monthly Registrations',
                data: [10, 20, 30, 40, 50, 60], // Example registration counts
                backgroundColor: '#F91942'
            }]
        };

        const barConfig = {
            type: 'bar',
            data: barData,
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Create Bar Chart
        const registrationBarChart = new Chart(
            document.getElementById('registrationBarChart'),
            barConfig
        );
    </script>
</body>

</html>