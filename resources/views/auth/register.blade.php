@extends('layouts.app')

@section('title', 'Register - Xperium Academy')

@section('content')
    <style>
        /* Auth Form Styles */
        .auth-container {
            min-height: calc(100vh - 200px);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .auth-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(10px);
            width: 100%;
            max-width: 600px;
        }

        .auth-header {
            background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--hover) 100%);
            padding: 2.5rem 2rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .auth-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 0%, transparent 100%);
            pointer-events: none;
        }

        .auth-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            letter-spacing: -0.025em;
            position: relative;
            z-index: 1;
        }

        .auth-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-top: 0.5rem;
            position: relative;
            z-index: 1;
        }

        .auth-body {
            padding: 2.5rem 2rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            letter-spacing: 0.025em;
        }

        .form-control {
            background: var(--secondary-bg);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 12px;
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus {
            background: var(--secondary-bg);
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control.is-invalid {
            border-color: var(--error);
            box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
        }

        .form-control option {
            background: var(--secondary-bg);
            color: var(--text-primary);
            padding: 0.5rem;
        }

        .invalid-feedback {
            color: var(--error);
            font-size: 0.875rem;
            font-weight: 500;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .invalid-feedback::before {
            content: '⚠';
            font-size: 1rem;
        }

        /* Password Input Container */
        .password-container {
            position: relative;
        }

        .password-container .form-control {
            padding-right: 3.5rem;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            font-size: 1.1rem;
        }

        .password-toggle:hover {
            color: var(--text-primary);
            background: var(--hover);
        }

        .password-toggle:focus {
            outline: none;
            color: var(--accent);
            background: var(--hover);
        }

        .password-toggle i {
            transition: opacity 0.2s ease;
        }

        /* Role Selection Styling */
        .role-option {
            padding: 1rem 1.25rem;
            background: var(--secondary-bg);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            margin-bottom: 0.75rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .role-option:hover {
            border-color: var(--hover);
            background: var(--hover);
        }

        .role-option.selected {
            border-color: var(--accent);
            background: rgba(255, 255, 255, 0.05);
        }

        .role-radio {
            width: 20px;
            height: 20px;
            border: 2px solid var(--border-color);
            border-radius: 50%;
            position: relative;
            flex-shrink: 0;
        }

        .role-option.selected .role-radio {
            border-color: var(--accent);
        }

        .role-option.selected .role-radio::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 10px;
            height: 10px;
            background: var(--accent);
            border-radius: 50%;
        }

        .role-info {
            flex: 1;
        }

        .role-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.25rem;
        }

        .role-description {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.4;
        }

        /* Buttons */
        .auth-btn {
            background: var(--success);
            color: var(--primary-bg);
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            letter-spacing: 0.025em;
        }

        .auth-btn:hover {
            background: rgba(16, 185, 129, 0.9);
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .auth-btn:active {
            transform: translateY(0);
        }

        /* Divider */
        .auth-divider {
            margin: 2rem 0;
            position: relative;
            text-align: center;
        }

        .auth-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--border-color);
        }

        .auth-divider span {
            background: var(--card-bg);
            color: var(--text-muted);
            padding: 0 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        /* Links */
        .auth-link {
            color: var(--accent);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s ease;
        }

        .auth-link:hover {
            color: var(--text-primary);
            text-decoration: none;
        }

        .auth-footer {
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Info Card */
        .info-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .info-title {
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-content {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .info-content strong {
            color: var(--text-primary);
        }

        /* Form Grid */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.5rem;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .auth-container {
                padding: 1rem;
            }

            .auth-header {
                padding: 2rem 1.5rem 1.5rem;
            }

            .auth-title {
                font-size: 1.75rem;
            }

            .auth-body {
                padding: 2rem 1.5rem;
            }

            .info-card {
                padding: 1.25rem;
            }
        }
    </style>

    <div class="auth-container">
        <div class="w-100">
            <div class="auth-card mx-auto">
                <div class="auth-header">
                    <h2 class="auth-title">Create Account</h2>
                    <p class="auth-subtitle">Join our platform and start your learning journey</p>
                </div>
                <div class="auth-body">
                    <form method="POST" action="{{ route('register.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="Enter your full name" required autofocus>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="Enter your email address" required>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Account Type</label>
                            <input type="hidden" id="role" name="role" value="{{ old('role') }}">

                            <div class="role-option {{ old('role') == 'student' ? 'selected' : '' }}" data-role="student">
                                <div class="role-radio"></div>
                                <div class="role-info">
                                    <div class="role-title">
                                        <i class="fa fa-user"></i>
                                        Student Account
                                    </div>
                                    <div class="role-description">Browse courses, make bookings, and manage your learning
                                        journey</div>
                                </div>
                            </div>

                            <div class="role-option {{ old('role') == 'admin' ? 'selected' : '' }}" data-role="admin">
                                <div class="role-radio"></div>
                                <div class="role-info">
                                    <div class="role-title">
                                        <i class="fa fa-cog"></i>
                                        Admin Account
                                    </div>
                                    <div class="role-description">Full system access to manage courses, users, and bookings
                                    </div>
                                </div>
                            </div>

                            @error('role')
                                <div class="invalid-feedback" style="display: block; margin-top: 0.5rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label for="password" class="form-label">Password</label>
                                <div class="password-container">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Enter password" required>
                                    <button type="button" class="password-toggle" id="togglePassword"
                                        title="Show/Hide Password">
                                        <i class="fa fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <div class="password-container">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm password" required>
                                    <button type="button" class="password-toggle" id="toggleConfirmPassword"
                                        title="Show/Hide Password">
                                        <i class="fa fa-eye" id="eyeIconConfirm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="auth-btn">
                            <i class="fa fa-user-plus"></i>
                            Create Account
                        </button>
                    </form>

                    <div class="auth-divider">
                        <span>Already have an account?</span>
                    </div>

                    <div class="auth-footer">
                        <p class="mb-0">
                            Already registered?
                            <a href="{{ route('login') }}" class="auth-link">Sign In Here</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="info-card mx-auto" style="max-width: 600px;">
                <h6 class="info-title">
                    <i class="fa fa-info-circle"></i>
                    Account Types
                </h6>
                <div class="info-content">
                    <strong>Student Account:</strong> Perfect for learners who want to browse available courses, make
                    bookings, track their learning progress, and manage their course schedule.<br><br>
                    <strong>Admin Account:</strong> Designed for administrators who need full system access to manage
                    courses, schedules, user accounts, bookings, and overall platform operations.
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Role selection functionality
            const roleOptions = document.querySelectorAll('.role-option');
            const roleInput = document.getElementById('role');

            roleOptions.forEach(option => {
                option.addEventListener('click', function () {
                    // Remove selected class from all options
                    roleOptions.forEach(opt => opt.classList.remove('selected'));

                    // Add selected class to clicked option
                    this.classList.add('selected');

                    // Update hidden input value
                    roleInput.value = this.dataset.role;
                });
            });

            // Password toggle functionality for main password field
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            togglePassword.addEventListener('click', function () {
                // Toggle the type attribute
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);

                // Toggle the icon
                if (type === 'text') {
                    eyeIcon.className = 'fa fa-eye-slash';
                    togglePassword.title = 'Hide Password';
                } else {
                    eyeIcon.className = 'fa fa-eye';
                    togglePassword.title = 'Show Password';
                }
            });

            // Password toggle functionality for confirm password field
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const passwordConfirmInput = document.getElementById('password_confirmation');
            const eyeIconConfirm = document.getElementById('eyeIconConfirm');

            toggleConfirmPassword.addEventListener('click', function () {
                // Toggle the type attribute
                const type = passwordConfirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordConfirmInput.setAttribute('type', type);

                // Toggle the icon
                if (type === 'text') {
                    eyeIconConfirm.className = 'fa fa-eye-slash';
                    toggleConfirmPassword.title = 'Hide Password';
                } else {
                    eyeIconConfirm.className = 'fa fa-eye';
                    toggleConfirmPassword.title = 'Show Password';
                }
            });
        });
    </script>
@endsection