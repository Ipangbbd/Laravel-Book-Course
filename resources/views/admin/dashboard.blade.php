@extends('layouts.app')

@section('title', 'Admin Dashboard - Course Booking System')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="jumbotron">
            <h1 class="display-4">Admin Dashboard</h1>
            <p class="lead">Welcome back, {{ Auth::user()->name }}!</p>
            <hr class="my-4">
            <p>Manage your course booking system from here.</p>
        </div>
    </div>
</div>

<!-- Session Information -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Session Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>User:</strong> {{ Auth::user()->name }}</p>
                        <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                        <p><strong>Role:</strong> <span class="badge badge-primary">{{ ucfirst(Auth::user()->role) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> <span class="badge badge-success">{{ ucfirst(Auth::user()->status) }}</span></p>
                        <p><strong>Session ID:</strong> <code>{{ session()->getId() }}</code></p>
                        <p><strong>Login Time:</strong> {{ now()->format('M d, Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Management Cards -->
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="card-title">Categories</h5>
                <p class="card-text">Manage course categories</p>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-info">Manage Categories</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-book fa-3x text-muted mb-3"></i>
                <h5 class="card-title">Courses</h5>
                <p class="card-text">Create and manage courses</p>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-primary">Manage Courses</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
                <h5 class="card-title">Bookings</h5>
                <p class="card-text">Review student bookings</p>
                <button class="btn btn-secondary" disabled>Coming Soon</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-users fa-3x text-muted mb-3"></i>
                <h5 class="card-title">Users</h5>
                <p class="card-text">Manage system users</p>
                <a href="{{ route('admin.users.index') }}" class="btn btn-success">Manage Users</a>
            </div>
        </div>
    </div>
</div>

<!-- Statistics -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">System Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h3 class="text-primary">{{ $stats['total_courses'] }}</h3>
                        <p class="text-muted">Total Courses</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-success">{{ $stats['active_bookings'] }}</h3>
                        <p class="text-muted">Active Bookings</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-warning">{{ $stats['total_users'] }}</h3>
                        <p class="text-muted">Total Users</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-info">{{ $stats['pending_payments'] }}</h3>
                        <p class="text-muted">Pending Payments</p>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="row text-center">
                    <div class="col-md-3">
                        <h3 class="text-success">{{ $stats['active_courses'] }}</h3>
                        <p class="text-muted">Active Courses</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-primary">{{ $stats['total_categories'] }}</h3>
                        <p class="text-muted">Categories</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-info">{{ $stats['total_students'] }}</h3>
                        <p class="text-muted">Students</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-success">{{ $stats['verified_payments'] }}</h3>
                        <p class="text-muted">Verified Payments</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout -->
<div class="row mt-4">
    <div class="col-12 text-center">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger">
                Logout
            </button>
        </form>
    </div>
</div>
@endsection