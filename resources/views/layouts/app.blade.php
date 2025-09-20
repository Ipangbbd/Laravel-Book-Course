<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="csrf_token_here">

    <title>Xperium Academy</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-bg: #0a0a0a;
            --secondary-bg: #111111;
            --card-bg: #1a1a1a;
            --border-color: #222222;
            --text-primary: #ffffff;
            --text-secondary: #a0a0a0;
            --text-muted: #666666;
            --accent: #ffffff;
            --success: #10b981;
            --error: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --hover: #252525;
            --glow: rgba(255, 255, 255, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--primary-bg);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            /* Add top padding to prevent navbar overlap */
            padding-top: 120px;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.01'%3E%3Ccircle cx='30' cy='30' r='2'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        /* ==============================================
        NAVBAR 
        ============================================== */
        .navbar-wrapper {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1.5rem 2rem 0 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-wrapper.scrolled {
            padding: 0.25rem 2rem 0 2rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            background: rgba(10, 10, 10, 0.85);
        }

        .navbar {
            background: rgba(17, 17, 17, 0.9) !important;
            border: 1px solid rgba(34, 34, 34, 0.8);
            padding: 0.75rem 1.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 20px;
            position: relative;
            overflow: visible;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            
            /* glass effect */
            box-shadow: 
                0 8px 32px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.1),
                0 0 0 0.5px rgba(255, 255, 255, 0.05);
        }

        .navbar-wrapper.scrolled .navbar {
            padding: 0.4rem 1.5rem;
            border-radius: 16px;
            background: rgba(17, 17, 17, 0.95) !important;
            border: 1px solid rgba(34, 34, 34, 0.6);
        }

        /* Create the subtle inward curve */
        .navbar::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 120px;
            height: 16px;
            background: inherit;
            border: 1px solid rgba(34, 34, 34, 0.8);
            border-top: none;
            border-radius: 0 0 60px 60px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            transition: all 0.4s ease;
        }

        .navbar-wrapper.scrolled .navbar::after {
            bottom: -4px;
            width: 80px;
            height: 8px;
            border-radius: 0 0 40px 40px;
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--text-primary) !important;
            letter-spacing: -0.025em;
            transition: all 0.4s ease;
        }

        .navbar-wrapper.scrolled .navbar-brand {
            font-size: 0.95rem;
        }

        .navbar-brand:hover {
            text-shadow: 0 0 12px var(--glow);
        }

        .navbar-nav .nav-link {
            color: rgba(160, 160, 160, 0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.4s ease;
            border-radius: 10px;
            margin: 0 0.15rem;
            font-size: 0.9rem;
            position: relative;
        }

        .navbar-wrapper.scrolled .navbar-nav .nav-link {
            padding: 0.35rem 0.8rem !important;
            font-size: 0.85rem;
        }

        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            bottom: 4px;
            left: 50%;
            width: 0;
            height: 1px;
            background: var(--accent);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .navbar-nav .nav-link:hover {
            color: var(--text-primary) !important;
            background: var(--hover);
        }

        .navbar-nav .nav-link:hover::after {
            width: 70%;
        }

        .dropdown-menu {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid rgba(34, 34, 34, 0.8);
            border-radius: 12px;
            padding: 0.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
            margin-top: 0.5rem;
            opacity: 0;
            transform: translateY(-5px);
            transition: all 0.2s ease;
        }

        .dropdown-menu.show {
            opacity: 1;
            transform: translateY(0);
        }

        .dropdown-item {
            color: var(--text-secondary) !important;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            font-size: 0.85rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .dropdown-item:hover {
            background: var(--hover);
            color: var(--text-primary) !important;
            transform: translateX(2px);
        }

        .dropdown-item i {
            width: 14px;
            opacity: 0.7;
            font-size: 0.8rem;
        }

        .dropdown-divider {
            border-color: rgba(34, 34, 34, 0.6);
            margin: 0.5rem 0;
        }

        /* ==============================================
        RESPONSIVE DESIGN
        ============================================== */
        @media (max-width: 991px) {
            body {
                padding-top: 100px;
            }
            
            .navbar-wrapper {
                padding: 0.75rem 1rem 0 1rem;
            }
            
            .navbar-wrapper.scrolled {
                padding: 0.5rem 1rem 0 1rem;
            }
            
            .navbar {
                padding: 0.75rem 1rem;
                border-radius: 20px;
            }
            
            .navbar-wrapper.scrolled .navbar {
                padding: 0.6rem 1rem;
                border-radius: 16px;
            }
            
            .navbar::after {
                width: 80px;
                height: 12px;
                bottom: -6px;
            }
            
            .navbar-wrapper.scrolled .navbar::after {
                width: 60px;
                height: 10px;
                bottom: -5px;
            }
            
            .navbar-collapse {
                margin-top: 1rem;
                padding-top: 1rem;
                border-top: 1px solid rgba(34, 34, 34, 0.6);
            }
            
            .navbar-nav .nav-link {
                margin: 0.25rem 0;
                text-align: center;
            }
            
            .dropdown-menu {
                position: static !important;
                transform: none !important;
                opacity: 1 !important;
                box-shadow: inset 0 0 0 1px var(--border-color);
                background: var(--hover);
                margin-top: 0.25rem;
            }
        }

        @media (max-width: 576px) {
            body {
                padding-top: 85px;
            }
            
            .navbar-wrapper {
                padding: 0.5rem 0.75rem 0 0.75rem;
            }
            
            .navbar-wrapper.scrolled {
                padding: 0.25rem 0.75rem 0 0.75rem;
            }
            
            .navbar {
                padding: 0.6rem 1rem;
                border-radius: 16px;
            }
            
            .navbar-wrapper.scrolled .navbar {
                padding: 0.5rem 1rem;
                border-radius: 14px;
            }
            
            .navbar::after {
                width: 60px;
                height: 10px;
                bottom: -5px;
            }
            
            .navbar-wrapper.scrolled .navbar::after {
                width: 50px;
                height: 8px;
                bottom: -4px;
            }
            
            .navbar-brand {
                font-size: 1.1rem;
            }
            
            .navbar-wrapper.scrolled .navbar-brand {
                font-size: 1rem;
            }
            
            .navbar-nav .nav-link {
                font-size: 0.9rem;
                padding: 0.5rem 1rem !important;
            }
            
            .navbar-wrapper.scrolled .navbar-nav .nav-link {
                padding: 0.4rem 0.8rem !important;
                font-size: 0.85rem;
            }
        }

        /* ==============================================
        CONTAINER 
        ============================================== */
        .container {
            flex: 1;
        }

        /* ==============================================
        ALERTS
        ============================================== */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 1rem 1.5rem;
            font-weight: 500;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
            transform: translateY(0);
            transition: transform 0.2s ease;
        }

        .alert:hover {
            transform: translateY(-2px);
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .alert-info {
            background: rgba(59, 130, 246, 0.1);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        .close {
            color: inherit;
            opacity: 0.8;
            transition: all 0.2s ease;
        }

        .close:hover {
            opacity: 1;
            transform: rotate(90deg);
        }

        /* ==============================================
        FOOTER 
        ============================================== */
        footer {
            background: transparent !important;
            padding: 3rem 0 0 0;
            margin-top: 4rem;
        }

        .footer-container {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 24px 24px 0 0;
            margin: 0 2rem;
            padding: 4.5rem 2rem 2rem 3rem;
            box-shadow: 
                0 -8px 32px rgba(0, 0, 0, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.05);
            position: relative;
        }

        .footer-container::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 60px;
            background: linear-gradient(to bottom, transparent, var(--primary-bg));
            pointer-events: none;
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
        }

        .footer-brand h4 {
            color: var(--text-primary);
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1rem;
            letter-spacing: -0.025em;
        }

        .footer-brand p {
            color: var(--text-muted);
            font-size: 0.9rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .footer-social a {
            width: 36px;
            height: 36px;
            background: var(--hover);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .footer-social a:hover {
            background: var(--card-bg);
            color: var(--text-primary);
            border-color: var(--accent);
            transform: translateY(-2px);
        }

        .footer-section h5 {
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-section ul li {
            margin-bottom: 0.75rem;
        }

        .footer-section ul li a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-section ul li a:hover {
            color: var(--text-primary);
            transform: translateX(4px);
        }

        .footer-section ul li a i {
            opacity: 0.5;
        }

        .footer-bottom {
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
            text-align: center;
        }

        .footer-bottom small {
            color: var(--text-muted);
            font-size: 0.85rem;
            line-height: 1.6;
            opacity: 0;
            animation: footerFadeIn 0.8s ease-out 0.2s forwards;
        }

        @keyframes footerFadeIn {
            to { opacity: 1; }
        }

        /* Responsive Footer */
        @media (max-width: 991px) {
            .footer-container {
                margin: 0 1rem;
                border-radius: 20px 20px 0 0;
                padding: 2.5rem 1.5rem 1.5rem 1.5rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr 1fr;
                gap: 2rem;
            }
            
            .footer-brand {
                grid-column: 1 / -1;
                text-align: center;
                margin-bottom: 1rem;
            }
            
            .footer-social {
                justify-content: center;
            }
        }

        @media (max-width: 576px) {

            .footer-container {
                margin: 0 0.5rem;
                border-radius: 16px 16px 0 0;
                padding: 2rem 1rem 1rem 1rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                text-align: center;
            }
            
            .footer-brand h4 {
                font-size: 1.25rem;
            }
            
            .footer-section h5 {
                font-size: 0.9rem;
            }
        }

        /* ==============================================
        NAVBAR TOGGLER 
        ============================================== */
        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            background: var(--hover);
        }

        .navbar-toggler:active {
            transform: scale(0.95);
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 2px var(--glow);
            outline: none;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 0.75%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }

        /* ==============================================
        UTILITIES 
        ============================================== */
        .text-primary { color: var(--text-primary) !important; }
        .text-secondary { color: var(--text-secondary) !important; }
        .text-muted { color: var(--text-muted) !important; }

        /* Smooth scrolling */
        html {
            scroll-behavior: smooth;
        }

        /* Selection */
        ::selection {
            background: var(--accent);
            color: var(--primary-bg);
        }

        /* Focus styles */
        button:focus,
        .btn:focus,
        .nav-link:focus {
            box-shadow: 0 0 0 2px var(--glow);
            outline: none;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--primary-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
            border: 2px solid var(--primary-bg);
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--hover);
        }

        /* Cursor */
        a, button, .btn, .nav-link, .dropdown-item {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <!-- Curved Navigation -->
    <div class="navbar-wrapper">
        <nav class="navbar navbar-expand-lg">
            <div class="container">
                <a class="navbar-brand ml-3" href="{{ route('welcome') }}">
                    Xperium Academy
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
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
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
    </div>

    <!-- Main Content — YOUR DOMAIN. I TOUCH NOTHING. -->
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
                <button type="button" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif

        <!-- Page Content — YOUR MASTERPIECE -->
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-container">
            <div class="footer-content">
                <!-- Brand Section -->
                <div class="footer-brand">
                    <h4>Xperium Academy</h4>
                    <p>Empowering students to discover and book their perfect courses with ease. Built with passion and endless cups of coffee.</p>
                    <div class="footer-social">
                        <a href="#" title="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#" title="LinkedIn">
                            <i class="fa fa-linkedin"></i>
                        </a>
                        <a href="#" title="GitHub">
                            <i class="fa fa-github"></i>
                        </a>
                    </div>
                </div>

                <!-- Product Section -->
                <div class="footer-section">
                    <h5>Product</h5>
                    <ul>
                        <li><a href="{{ route('public.courses.index') }}">Browse Courses</a></li>
                        <li><a href="#">Course Categories</a></li>
                        <li><a href="#">Pricing</a></li>
                        <li><a href="#">Features</a></li>
                    </ul>
                </div>

                <!-- Resources Section -->
                <div class="footer-section">
                    <h5>Resources</h5>
                    <ul>
                        <li><a href="#">Documentation</a></li>
                        <li><a href="#">Help Center</a></li>
                        <li><a href="#">FAQs</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <!-- Company Section -->
                <div class="footer-section">
                    <h5>Company</h5>
                    <ul>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">News</a></li>
                    </ul>
                </div>

                <!-- Legal Section -->
                <div class="footer-section">
                    <h5>Legal</h5>
                    <ul>
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Cookie Policy</a></li>
                        <li><a href="#">Security</a></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <small>&copy; 2025 Xperium Academy By Muhammad Ali Irfansyah. All rights reserved.</small>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    
    <!-- Navbar Scroll Behavior -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navbarWrapper = document.querySelector('.navbar-wrapper');
            
            function handleScroll() {
                const scrollY = window.scrollY;
                
                if (scrollY > 30) {
                    navbarWrapper.classList.add('scrolled');
                } else {
                    navbarWrapper.classList.remove('scrolled');
                }
            }
            
            // Initial check
            handleScroll();
            
            // Listen for scroll events
            window.addEventListener('scroll', handleScroll, { passive: true });
        });
    </script>
</body>

</html>