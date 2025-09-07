@extends('layouts.app')

@section('title', 'Edit Profile - Course Booking System')

@section('content')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <!-- Back to Profile Button -->
            <div class="mb-3">
                <a href="{{ route('student.profile.show') }}" class="btn btn-outline-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Profile
                </a>
            </div>

            <!-- Edit Profile Form -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa fa-user-edit"></i> Edit My Profile</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <!-- Avatar Section -->
                        <div class="row mb-4">
                            <div class="col-md-3 text-center">
                                <div class="mb-3">
                                    @if($user->avatar_path)
                                        <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}"
                                            class="rounded-circle" id="avatar-preview"
                                            style="width: 120px; height: 120px; object-fit: cover;">
                                    @else
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                            id="avatar-preview" style="width: 120px; height: 120px; font-size: 48px;">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <label for="avatar" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-camera"></i> Change Photo
                                    </label>
                                    <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*"
                                        onchange="previewAvatar(this)">
                                </div>
                                @if($user->avatar_path)
                                    <div>
                                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeAvatar()">
                                            <i class="fa fa-trash"></i> Remove
                                        </button>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-9">
                                <div class="alert alert-info">
                                    <h6><i class="fa fa-info-circle"></i> Profile Photo Tips</h6>
                                    <ul class="mb-0">
                                        <li>Use a clear, recent photo of yourself</li>
                                        <li>Supported formats: JPG, JPEG, PNG</li>
                                        <li>Maximum file size: 2MB</li>
                                        <li>Recommended size: 400x400 pixels</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        @if ($errors->has('avatar'))
                            <div class="alert alert-danger">
                                {{ $errors->first('avatar') }}
                            </div>
                        @endif

                        <!-- Basic Information -->
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fa fa-user"></i> Basic Information
                        </h6>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="font-weight-bold">Full Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $user->name) }}" required
                                    placeholder="Enter your full name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="font-weight-bold">Email Address <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                    name="email" value="{{ old('email', $user->email) }}" required
                                    placeholder="Enter your email address">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Change Password Section -->
                        <h6 class="font-weight-bold text-primary mb-3">
                            <i class="fa fa-lock"></i> Change Password (Optional)
                        </h6>

                        <div class="alert alert-warning">
                            <small>
                                <i class="fa fa-exclamation-triangle"></i>
                                Leave password fields empty if you don't want to change your password.
                            </small>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="current_password" class="font-weight-bold">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                    id="current_password" name="current_password" placeholder="Enter your current password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="password" class="font-weight-bold">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Enter new password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="font-weight-bold">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Confirm new password">
                            </div>
                        </div>

                        <hr class="my-4">

                        <!-- Action Buttons -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('student.profile.show') }}" class="btn btn-secondary">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Avatar Preview -->
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
                        img.className = 'rounded-circle';
                        img.style.width = '120px';
                        img.style.height = '120px';
                        img.style.objectFit = 'cover';
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
                placeholder.className = 'rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto';
                placeholder.style.width = '120px';
                placeholder.style.height = '120px';
                placeholder.style.fontSize = '48px';
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
                    strengthClass = 'text-danger';
                    break;
                case 2:
                    strengthText = 'Weak';
                    strengthClass = 'text-warning';
                    break;
                case 3:
                    strengthText = 'Medium';
                    strengthClass = 'text-info';
                    break;
                case 4:
                    strengthText = 'Strong';
                    strengthClass = 'text-success';
                    break;
                case 5:
                    strengthText = 'Very Strong';
                    strengthClass = 'text-success';
                    break;
            }

            // Remove existing strength indicator
            var existingIndicator = document.getElementById('password-strength');
            if (existingIndicator) {
                existingIndicator.remove();
            }

            // Add strength indicator if password is not empty
            if (password.length > 0) {
                var indicator = document.createElement('small');
                indicator.id = 'password-strength';
                indicator.className = strengthClass;
                indicator.textContent = 'Strength: ' + strengthText;
                this.parentNode.appendChild(indicator);
            }
        });
    </script>
@endsection