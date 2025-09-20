<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Course Booking System')</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('welcome') }}">
                Course Booking System
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.courses.index') }}">
                            Courses
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ml-auto">
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-toggle="dropdown">
                                {{ Auth::user()->name }} ({{ ucfirst(Auth::user()->role) }})
                            </a>
                            <div class="dropdown-menu">
                                @if(Auth::user()->isAdmin())
                                    <a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a>
                                    <a class="dropdown-item" href="{{ route('admin.categories.index') }}">Manage Categories</a>
                                    <a class="dropdown-item" href="{{ route('admin.courses.index') }}">Manage Courses</a>
                                    <a class="dropdown-item" href="{{ route('admin.schedules.index') }}">Manage Schedules</a>
                                    <a class="dropdown-item" href="{{ route('admin.bookings.index') }}">Manage Bookings</a>
                                    <a class="dropdown-item" href="{{ route('admin.payments.index') }}">Manage Payments</a>
                                    <a class="dropdown-item" href="{{ route('admin.users.index') }}">Manage Users</a>
                                @elseif(Auth::user()->isStudent())
                                    <a class="dropdown-item" href="{{ route('student.dashboard') }}">
                                        <i class="fa fa-tachometer"></i> Dashboard
                                    </a>
                                    <a class="dropdown-item" href="{{ route('student.courses.index') }}">
                                        <i class="fa fa-search"></i> Browse Courses
                                    </a>
                                    <a class="dropdown-item" href="{{ route('student.bookings.index') }}">
                                        <i class="fa fa-calendar"></i> My Bookings
                                    </a>
                                    <a class="dropdown-item" href="{{ route('student.payments.index') }}">
                                        <i class="fa fa-credit-card"></i> Payments
                                    </a>
                                    <a class="dropdown-item" href="{{ route('student.profile.show') }}">
                                        <i class="fa fa-user"></i> Profile
                                    </a>
                                @endif
                                <div class="dropdown-divider"></div>
                                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-4">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                {{ session('info') }}
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-muted py-3 mt-5">
        <div class="container">
            <small>&copy; 2025 Course Booking System By Muhammad Ali Irfansyah. All rights reserved.</small>
            <br>
            <small>Built with passion and endless cups of coffee.</small>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>