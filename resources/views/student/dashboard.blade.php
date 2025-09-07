@extends('layouts.app')

@section('title', 'Student Dashboard - Course Booking System')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="jumbotron bg-light">
                <h1 class="display-4">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="lead">Discover amazing courses and start your learning journey today.</p>
                <hr class="my-4">
                <p>Browse through our extensive course catalog and book your favorite sessions.</p>
                <a href="{{ route('student.courses.index') }}" class="btn btn-primary btn-lg">Explore Courses</a>
            </div>
        </div>
    </div>

    <!-- Quick Statistics -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $stats['total_bookings'] }}</h3>
                    <p class="mb-0">Total Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $stats['completed_courses'] }}</h3>
                    <p class="mb-0">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $stats['active_bookings'] }}</h3>
                    <p class="mb-0">Active Bookings</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body text-center">
                    <h3 class="mb-1">{{ $stats['pending_payments'] }}</h3>
                    <p class="mb-0">Pending Payments</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fa fa-search fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Browse Courses</h5>
                    <p class="card-text">Discover new courses and learning opportunities</p>
                    <a href="{{ route('student.courses.index') }}" class="btn btn-primary btn-block">Browse Now</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fa fa-calendar fa-3x text-success mb-3"></i>
                    <h5 class="card-title">My Bookings</h5>
                    <p class="card-text">View and manage your course bookings</p>
                    <a href="{{ route('student.bookings.index') }}" class="btn btn-success btn-block">View Bookings</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fa fa-credit-card fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">Payments</h5>
                    <p class="card-text">Manage your course payments</p>
                    <a href="{{ route('student.payments.index') }}" class="btn btn-warning btn-block">View Payments</a>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card text-center h-100">
                <div class="card-body">
                    <i class="fa fa-user fa-3x text-info mb-3"></i>
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">Update your profile information</p>
                    <a href="{{ route('student.profile.show') }}" class="btn btn-info btn-block">View Profile</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Bookings -->
    @if($recentBookings->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recent Bookings</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                        <th>Booked Date</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>
                                                <strong>{{ $booking->schedule->course->name }}</strong><br>
                                                <small class="text-muted">{{ $booking->booking_code }}</small>
                                            </td>
                                            <td>
                                                {{ $booking->schedule->start_datetime->format('M j, Y') }}<br>
                                                <small
                                                    class="text-muted">{{ $booking->schedule->start_datetime->format('g:i A') }}</small>
                                            </td>
                                            <td>
                                                @if($booking->status === 'approved')
                                                    <span class="badge badge-success">{{ ucfirst($booking->status) }}</span>
                                                @elseif($booking->status === 'pending')
                                                    <span class="badge badge-warning">{{ ucfirst($booking->status) }}</span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="badge badge-danger">{{ ucfirst($booking->status) }}</span>
                                                @else
                                                    <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $booking->booked_at->format('M j, Y') }}</td>
                                            <td>
                                                @if($booking->payment)
                                                    @if($booking->payment->status === 'verified')
                                                        <span class="badge badge-success">Verified</span>
                                                    @elseif($booking->payment->status === 'pending')
                                                        <span class="badge badge-warning">Pending</span>
                                                    @else
                                                        <span class="badge badge-danger">{{ ucfirst($booking->payment->status) }}</span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-secondary">Not Paid</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('student.bookings.index') }}" class="btn btn-outline-primary">View All
                                Bookings</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Upcoming Schedules -->
    @if($upcomingSchedules->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Upcoming Classes</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($upcomingSchedules as $booking)
                                <div class="col-md-4 mb-3">
                                    <div class="card border-left-primary">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $booking->schedule->course->name }}</h6>
                                            <p class="card-text">
                                                <i class="fa fa-calendar"></i>
                                                {{ $booking->schedule->start_datetime->format('M j, Y') }}<br>
                                                <i class="fa fa-clock-o"></i>
                                                {{ $booking->schedule->start_datetime->format('g:i A') }}
                                            </p>
                                            <a href="{{ route('student.bookings.show', $booking) }}"
                                                class="btn btn-sm btn-outline-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Featured Courses -->
    @if($featuredCourses->count() > 0)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Recommended Courses</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($featuredCourses as $course)
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100">
                                        @if($course->image_path)
                                            <img src="{{ asset('storage/' . $course->image_path) }}" class="card-img-top"
                                                alt="{{ $course->name }}" style="height: 150px; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-light d-flex align-items-center justify-content-center"
                                                style="height: 150px;">
                                                <i class="fa fa-book fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $course->name }}</h6>
                                            <p class="card-text text-muted small">{{ Str::limit($course->description, 80) }}</p>
                                            <p class="mb-2">
                                                <strong class="text-primary">${{ number_format($course->price, 2) }}</strong>
                                                <span class="badge badge-secondary">{{ $course->category->name }}</span>
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <a href="{{ route('student.courses.show', $course) }}"
                                                class="btn btn-primary btn-sm btn-block">View Course</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('student.courses.index') }}" class="btn btn-outline-primary">Browse All
                                Courses</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Get Started</h5>
                    </div>
                    <div class="card-body text-center">
                        <i class="fa fa-graduation-cap fa-3x text-muted mb-3"></i>
                        <h5>Start Your Learning Journey</h5>
                        <p class="text-muted">Browse our course catalog to find the perfect learning opportunity for you.</p>
                        <a href="{{ route('student.courses.index') }}" class="btn btn-primary">Explore Courses</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection