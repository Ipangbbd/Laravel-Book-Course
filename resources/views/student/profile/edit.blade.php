@extends('layouts.app')

@section('title', 'Edit Profile - Xperium Academy')

@section('content')
    <style>
        /* Profile Edit Styles */
        .breadcrumb {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }

        .breadcrumb-item {
            color: var(--text-secondary);
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: var(--text-primary);
        }

        .breadcrumb-item+.breadcrumb-item::before {
            content: "/";
            color: var(--text-muted);
        }

        .breadcrumb a {
            color: var(--text-secondary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb a:hover {
            color: var(--text-primary);
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            font-size: 1.125rem;
            color: var(--text-secondary);
            margin: 0;
        }

        /* Form Card */
        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .form-header {
            background: var(--secondary-bg);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .form-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-body {
            padding: 2rem;
        }

        /* Avatar Section */
        .avatar-section {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .avatar-container {
            margin-bottom: 1.5rem;
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--accent);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            margin: 0 auto;
            display: block;
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--accent);
            color: var(--primary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            margin: 0 auto;
            border: 4px solid var(--accent);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .avatar-controls {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        /* Tips Card */
        .tips-card {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .tips-title {
            color: var(--info);
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tips-list {
            margin: 0;
            padding-left: 1.25rem;
            color: var(--text-secondary);
        }

        .tips-list li {
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        /* Form Styles */
        .form-section {
            margin-bottom: 2.5rem;
        }

        .section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 2px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
            display: block;
        }

        .form-label .required {
            color: var(--error);
            margin-left: 0.25rem;
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

        /* File Input */
        .file-input-wrapper {
            position: relative;
            display: inline-block;
        }

        .file-input {
            display: none;
        }

        .file-input-label {
            background: var(--accent);
            color: var(--primary-bg);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            border: none;
        }

        .file-input-label:hover {
            background: var(--text-secondary);
            transform: translateY(-2px);
        }

        /* Buttons */
        .modern-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
        }

        .btn-primary-modern {
            background: var(--accent);
            color: var(--primary-bg);
        }

        .btn-primary-modern:hover {
            background: var(--text-secondary);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-secondary-modern {
            background: var(--secondary-bg);
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
        }

        .btn-secondary-modern:hover {
            background: var(--hover);
            border-color: var(--hover);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-danger-modern {
            background: var(--error);
            color: var(--primary-bg);
        }

        .btn-danger-modern:hover {
            background: rgba(239, 68, 68, 0.8);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-sm-modern {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }

        /* Warning Alert */
        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-warning-modern {
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.3);
            color: var(--warning);
        }

        .alert-danger-modern {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--error);
        }

        .alert-modern i {
            font-size: 1.25rem;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .alert-content {
            flex: 1;
            font-size: 0.875rem;
        }

        /* Password Strength */
        .password-strength {
            margin-top: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Action Bar */
        .action-bar {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem 2rem;
            margin-top: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .form-body {
                padding: 1.5rem;
            }

            .avatar-section {
                padding: 1.5rem;
            }

            .avatar-controls {
                flex-direction: column;
            }

            .action-bar {
                flex-direction: column;
                text-align: center;
            }

            .page-title {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Breadcrumb -->
    <nav class="breadcrumb">
        <span class="breadcrumb-item"><a href="{{ route('student.profile.show') }}">Profile</a></span>
        <span class="breadcrumb-item active">Edit Profile</span>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">Edit Profile</h1>
        <p class="page-subtitle">Update your personal information and account settings</p>
    </div>
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Edit Profile Form -->
            <div class="form-card">
                <div class="form-header">
                    <h2 class="form-title"><i class="fa fa-user-edit"></i> Edit My Profile</h2>
                </div>
                <div class="form-body">
                    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Avatar Section -->
                        <div class="avatar-section">
                            <div class="avatar-container">
                                @if($user->avatar_path)
                                    <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}"
                                        class="avatar-preview" id="avatar-preview">
                                @else
                                    <div class="avatar-placeholder" id="avatar-preview">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>

                            <div class="avatar-controls">
                                <div class="file-input-wrapper">
                                    <input type="file" id="avatar" name="avatar" class="file-input" accept="image/*"
                                        onchange="previewAvatar(this)">
                                    <label for="avatar" class="file-input-label">
                                        <i class="fa fa-camera"></i> Change Photo
                                    </label>
                                </div>
                                @if($user->avatar_path)
                                    <button type="button" class="modern-btn btn-danger-modern btn-sm-modern"
                                        onclick="removeAvatar()">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                @endif
                            </div>

                            <div class="tips-card">
                                <h3 class="tips-title"><i class="fa fa-info-circle"></i> Profile Photo Tips</h3>
                                <ul class="tips-list">
                                    <li>Use a clear, recent photo of yourself</li>
                                    <li>Supported formats: JPG, JPEG, PNG</li>
                                    <li>Maximum file size: 2MB</li>
                                    <li>Recommended size: 400x400 pixels</li>
                                </ul>
                            </div>
                        </div>

                        @if ($errors->has('avatar'))
                            <div class="alert-modern alert-danger-modern">
                                <i class="fa fa-exclamation-triangle"></i>
                                <div class="alert-content">{{ $errors->first('avatar') }}</div>
                            </div>
                        @endif

                        <!-- Basic Information -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fa fa-user"></i> Basic Information
                            </h3>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="name" class="form-label">Full Name <span
                                                class="required">*</span></label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name', $user->name) }}" required
                                            placeholder="Enter your full name">
                                        @error('name')
                                            <div class="invalid-feedback"><i class="fa fa-exclamation-circle"></i>
                                                {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email Address <span
                                                class="required">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email', $user->email) }}" required
                                            placeholder="Enter your email address">
                                        @error('email')
                                            <div class="invalid-feedback"><i class="fa fa-exclamation-circle"></i>
                                                {{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Change Password Section -->
                        <div class="form-section">
                            <h3 class="section-title">
                                <i class="fa fa-lock"></i> Change Password (Optional)
                            </h3>

                            <div class="alert-modern alert-warning-modern">
                                <i class="fa fa-exclamation-triangle"></i>
                                <div class="alert-content">
                                    Leave password fields empty if you don't want to change your password.
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" placeholder="Enter your current password">
                                @error('current_password')
                                    <div class="invalid-feedback"><i class="fa fa-exclamation-circle"></i> {{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password" class="form-label">New Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Enter new password">
                                        @error('password')
                                            <div class="invalid-feedback"><i class="fa fa-exclamation-circle"></i>
                                                {{ $message }}</div>
                                        @enderror
                                        <div id="password-strength"></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="password_confirmation"
                                            name="password_confirmation" placeholder="Confirm new password">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Bar -->
                        <div class="action-bar">
                            <a href="{{ route('student.profile.show') }}" class="modern-btn btn-secondary-modern">
                                <i class="fa fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="modern-btn btn-primary-modern">
                                <i class="fa fa-save"></i> Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Avatar Preview and Password Strength -->
    <script>
        function previewAvatar(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    var preview = document.getElementById('avatar-preview');

                    // If it's currently a div (placeholder), replace with img
                    if (preview.tagName === 'DIV') {
                        var img = document.createElement('img');
                        img.id = 'avatar-preview';
                        img.className = 'avatar-preview';
                        img.src = e.target.result;
                        img.alt = '{{ $user->name }}';

                        preview.parentNode.replaceChild(img, preview);
                    } else {
                        // If it's already an img, just update the src
                        preview.src = e.target.result;
                    }
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function removeAvatar() {
            if (confirm('Are you sure you want to remove your profile photo?')) {
                // Reset file input
                document.getElementById('avatar').value = '';

                // Replace img with placeholder div
                var preview = document.getElementById('avatar-preview');
                var placeholder = document.createElement('div');
                placeholder.id = 'avatar-preview';
                placeholder.className = 'avatar-placeholder';
                placeholder.textContent = '{{ strtoupper(substr($user->name, 0, 1)) }}';

                preview.parentNode.replaceChild(placeholder, preview);

                // Add hidden input to indicate avatar removal
                var removeInput = document.createElement('input');
                removeInput.type = 'hidden';
                removeInput.name = 'remove_avatar';
                removeInput.value = '1';
                document.querySelector('form').appendChild(removeInput);
            }
        }

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function () {
            var password = this.value;
            var strength = 0;

            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/)) strength++;
            if (password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            var strengthText = '';
            var strengthClass = '';

            switch (strength) {
                case 0:
                case 1:
                    strengthText = 'Very Weak';
                    strengthClass = 'password-strength';
                    break;
                case 2:
                    strengthText = 'Weak';
                    strengthClass = 'password-strength';
                    break;
                case 3:
                    strengthText = 'Medium';
                    strengthClass = 'password-strength';
                    break;
                case 4:
                    strengthText = 'Strong';
                    strengthClass = 'password-strength';
                    break;
                case 5:
                    strengthText = 'Very Strong';
                    strengthClass = 'password-strength';
                    break;
            }

            // Remove existing strength indicator
            var existingIndicator = document.getElementById('password-strength');
            if (existingIndicator) {
                existingIndicator.innerHTML = '';
            }

            // Add strength indicator if password is not empty
            if (password.length > 0 && existingIndicator) {
                existingIndicator.className = strengthClass;
                existingIndicator.innerHTML = '<i class="fa fa-shield"></i> Strength: ' + strengthText;
            }
        });
    </script>
@endsection