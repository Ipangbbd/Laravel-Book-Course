@extends('layouts.app')

@section('title', 'Login - Xperium Academy')

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
            max-width: 480px;
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

        /* Checkbox */
        .form-check {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .form-check-input {
            width: 18px;
            height: 18px;
            border: 2px solid var(--border-color);
            border-radius: 4px;
            background: var(--secondary-bg);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .form-check-input:checked {
            background: var(--accent);
            border-color: var(--accent);
        }

        .form-check-label {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            user-select: none;
        }

        /* Buttons */
        .auth-btn {
            background: var(--accent);
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
            background: var(--text-secondary);
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

        /* Demo Card */
        .demo-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-top: 1.5rem;
            backdrop-filter: blur(10px);
        }

        .demo-title {
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .demo-accounts {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .demo-accounts strong {
            color: var(--text-primary);
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

            .demo-card {
                padding: 1.25rem;
            }
        }
    </style>

    <div class="auth-container">
        <div class="w-100">
            <div class="auth-card mx-auto">
                <div class="auth-header">
                    <h2 class="auth-title">Welcome Back</h2>
                    <p class="auth-subtitle">Sign in to your account to continue</p>
                </div>
                <div class="auth-body">
                    <form method="POST" action="{{ route('login.authenticate') }}">
                        @csrf

                        <div class="form-group">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" placeholder="Enter your email address" required
                                autofocus>
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Enter your password" required>
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

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember">
                            <label class="form-check-label" for="remember">
                                Remember me for 30 days
                            </label>
                        </div>

                        <button type="submit" class="auth-btn">
                            <i class="fa fa-sign-in"></i>
                            Sign In
                        </button>
                    </form>

                    <div class="auth-divider">
                        <span>New to our platform?</span>
                    </div>

                    <div class="auth-footer">
                        <p class="mb-0">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="auth-link">Create Account</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="demo-card mx-auto" style="max-width: 480px;">
                <h6 class="demo-title">
                    <i class="fa fa-key"></i>
                    Demo Accounts
                </h6>
                <div class="demo-accounts">
                    <strong>Admin Account:</strong> admin@admin.com / Admin123<br>
                    <strong>Student Account:</strong> user@gmail.com / Admin123
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
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
        });
    </script>
@endsection