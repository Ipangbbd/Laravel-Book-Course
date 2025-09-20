@extends('layouts.admin-layout')

@section('title', 'Create User - Admin Dashboard')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>Create New User</h2>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Users
                    </a>
                </div>

                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-8">
                                            <!-- Name -->
                                            <div class="form-group">
                                                <label for="name">Full Name *</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                                    id="name" name="name" value="{{ old('name') }}" required>
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Email -->
                                            <div class="form-group">
                                                <label for="email">Email Address *</label>
                                                <input type="email"
                                                    class="form-control @error('email') is-invalid @enderror" id="email"
                                                    name="email" value="{{ old('email') }}" required>
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Password -->
                                            <div class="form-group">
                                                <label for="password">Password *</label>
                                                <input type="password"
                                                    class="form-control @error('password') is-invalid @enderror"
                                                    id="password" name="password" required>
                                                @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Confirm Password -->
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password *</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <!-- Avatar -->
                                            <div class="form-group">
                                                <label for="avatar">Avatar</label>
                                                <input type="file"
                                                    class="form-control-file @error('avatar') is-invalid @enderror"
                                                    id="avatar" name="avatar" accept="image/*">
                                                @error('avatar')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                                <small class="form-text text-muted">Max 2MB, JPEG/PNG only</small>
                                            </div>

                                            <!-- Role -->
                                            <div class="form-group">
                                                <label for="role">Role *</label>
                                                <select class="form-control @error('role') is-invalid @enderror" id="role"
                                                    name="role" required>
                                                    <option value="">Select Role</option>
                                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin
                                                    </option>
                                                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>
                                                        Student</option>
                                                </select>
                                                @error('role')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <!-- Status -->
                                            <div class="form-group">
                                                <label for="status">Status *</label>
                                                <select class="form-control @error('status') is-invalid @enderror"
                                                    id="status" name="status" required>
                                                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                                </select>
                                                @error('status')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-save"></i> Create User
                                        </button>
                                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                                            Cancel
                                        </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection