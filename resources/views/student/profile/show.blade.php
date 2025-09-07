@extends('layouts.app')

@section('title', 'My Profile - Course Booking System')

@section('content')
    <div class="row">
        <div class="col-md-4 mb-4">
            <!-- Profile Card -->
            <div class="card">
                <div class="card-body text-center">
                    <!-- Avatar -->
                    <div class="mb-3">
                        @if($user->avatar_path)
                            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}"
                                class="rounded-circle" style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto"
                                style="width: 120px; height: 120px; font-size: 48px;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                        @endif
                    </div>

                    <!-- User Info -->
                    <h4 class="mb-1">{{ $user->name }}</h4>
                    <p class="text-muted mb-2">{{ $user->email }}</p>
                    <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>

                    <!-- Edit Button -->
                    <div class="mt-3">
                        <a href="{{ route('student.profile.edit') }}" class="btn btn-primary">
                            <i class="fa fa-edit"></i> Edit Profile
                        </a>
                    </div>

                    <!-- Member Since -->
                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="fa fa-calendar"></i>
                            Member since {{ $user->created_at->format('F Y') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0"><i class="fa fa-chart-bar"></i> Quick Stats</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <h5 class="text-primary mb-0">{{ $stats['total_bookings'] }}</h5>
                            <small class="text-muted">Total Bookings</small>
                        </div>
                        <div class="col-6 mb-3">
                            <h5 class="text-success mb-0">{{ $stats['completed_courses'] }}</h5>
                            <small class="text-muted">Completed</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-warning mb-0">{{ $stats['active_bookings'] }}</h5>
                            <small class="text-muted">Active</small>
                        </div>
                        <div class="col-6">
                            <h5 class="text-info mb-0">{{ $stats['verified_payments'] }}</h5>
                            <small class="text-muted">Paid</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Profile Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fa fa-user"></i> Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-muted">Full Name</label>
                            <p class="mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-muted">Email Address</label>
                            <p class="mb-0">{{ $user->email }}</p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-muted">Account Type</label>
                            <p class="mb-0">
                                <span class="badge badge-primary">{{ ucfirst($user->role) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="font-weight-bold text-muted">Member Since</label>
                            <p class="mb-0">{{ $user->created_at->format('F j, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            @if($recentBookings->count() > 0)
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="fa fa-history"></i> Recent Bookings</h5>
                        <a href="{{ route('student.bookings.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Course</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $booking->schedule->course->name }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $booking->booking_code }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $booking->schedule->start_datetime->format('M j, Y') }}
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $booking->schedule->start_datetime->format('g:i A') }}</small>
                                                </div>
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
                                            <td>
                                                @if($booking->payment)
                                                    @if($booking->payment->status === 'verified')
                                                        <span class="badge badge-success">
                                                            <i class="fa fa-check"></i> Verified
                                                        </span>
                                                    @elseif($booking->payment->status === 'pending')
                                                        <span class="badge badge-warning">
                                                            <i class="fa fa-clock-o"></i> Pending
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            <i class="fa fa-times"></i> {{ ucfirst($booking->payment->status) }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="badge badge-secondary">
                                                        <i class="fa fa-credit-card"></i> Not Paid
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('student.bookings.show', $booking) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Activity -->
                <div class="card">
                    <div class="card-body text-center">
                        <div class="py-4">
                            <i class="fa fa-calendar fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Bookings Yet</h5>
                            <p class="text-muted">You haven't made any course bookings yet. Start exploring our amazing courses!
                            </p>
                            <a href="{{ route('student.courses.index') }}" class="btn btn-primary">
                                <i class="fa fa-search"></i> Browse Courses
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection