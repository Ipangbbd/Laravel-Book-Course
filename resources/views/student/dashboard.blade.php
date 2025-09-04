@extends('layouts.app')

@section('title', 'Student Dashboard - Course Booking System')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="jumbotron bg-light">
            <h1 class="display-4">Student Dashboard</h1>
            <p class="lead">Hello {{ Auth::user()->name }}, ready to learn something new?</p>
            <hr class="my-4">
            <p>Browse courses and manage your bookings.</p>
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
                        <p><strong>Role:</strong> <span class="badge badge-success">{{ ucfirst(Auth::user()->role) }}</span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Status:</strong> <span class="badge badge-primary">{{ ucfirst(Auth::user()->status) }}</span></p>
                        <p><strong>Session ID:</strong> <code>{{ session()->getId() }}</code></p>
                        <p><strong>Login Time:</strong> {{ now()->format('M d, Y H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-search fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Browse Courses</h5>
                <p class="card-text">Find courses to enroll in</p>
                <a href="{{ route('public.courses.index') }}" class="btn btn-primary">Browse</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
                <h5 class="card-title">My Bookings</h5>
                <p class="card-text">View your course bookings</p>
                <button class="btn btn-secondary" disabled>Coming Soon</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-credit-card fa-3x text-muted mb-3"></i>
                <h5 class="card-title">Payments</h5>
                <p class="card-text">Manage your payments</p>
                <button class="btn btn-secondary" disabled>Coming Soon</button>
            </div>
        </div>
    </div>
    
    <div class="col-md-3 mb-4">
        <div class="card text-center">
            <div class="card-body">
                <i class="fa fa-user fa-3x text-muted mb-3"></i>
                <h5 class="card-title">Profile</h5>
                <p class="card-text">Update your profile</p>
                <button class="btn btn-secondary" disabled>Coming Soon</button>
            </div>
        </div>
    </div>
</div>

<!-- Learning Progress -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Learning Progress</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-md-3">
                        <h3 class="text-primary">0</h3>
                        <p class="text-muted">Enrolled Courses</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-success">0</h3>
                        <p class="text-muted">Completed</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-warning">0</h3>
                        <p class="text-muted">In Progress</p>
                    </div>
                    <div class="col-md-3">
                        <h3 class="text-info">0</h3>
                        <p class="text-muted">Pending Bookings</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Recent Activity</h5>
            </div>
            <div class="card-body text-center">
                <i class="fa fa-inbox fa-3x text-muted"></i>
                <p class="mt-3 mb-0">No recent activity to show</p>
                <small class="text-muted">Start browsing courses to see your activity here</small>
            </div>
        </div>
    </div>
</div>

<!-- Logout -->
<div class="row">
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