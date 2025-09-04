@extends('layouts.app')

@section('title', 'Welcome - Course Booking System')

@section('content')
<div class="jumbotron">
    <h1 class="display-4">Course Booking System</h1>
    <p class="lead">Discover, book, and manage your learning journey with our comprehensive course booking platform.</p>
    <hr class="my-4">
    <p>Browse our available courses or create an account to get started.</p>
    <div class="row">
        <div class="col-md-6">
            <a class="btn btn-primary btn-lg" href="{{ route('public.courses.index') }}" role="button">Browse Courses</a>
        </div>
        <div class="col-md-6">
            @guest
                <a class="btn btn-success btn-lg" href="{{ route('register') }}" role="button">Get Started</a>
            @endguest
        </div>
    </div>
</div>

<!-- Features -->
<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fa fa-calendar fa-3x text-primary mb-3"></i>
                <h5 class="card-title">Easy Scheduling</h5>
                <p class="card-text">Book courses that fit your schedule with our flexible scheduling system.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fa fa-users fa-3x text-success mb-3"></i>
                <h5 class="card-title">Expert Instructors</h5>
                <p class="card-text">Learn from industry professionals and certified instructors.</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <i class="fa fa-shield fa-3x text-info mb-3"></i>
                <h5 class="card-title">Secure Platform</h5>
                <p class="card-text">Your data and payments are protected with enterprise-level security.</p>
            </div>
        </div>
    </div>
</div>

@guest
<div class="row mt-5">
    <div class="col-12">
        <div class="card">
            <div class="card-body text-center">
                <h3 class="card-title">Ready to Start Learning?</h3>
                <p class="card-text">Join our community of learners and take the first step towards achieving your goals.</p>
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg mr-3">Create Account</a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">Sign In</a>
            </div>
        </div>
    </div>
</div>
@endguest
@endsection