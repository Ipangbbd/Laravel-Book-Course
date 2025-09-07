@extends('layouts.app')

@section('title', $course->name . ' - Course Details')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.courses.index') }}">Courses</a></li>
                    <li class="breadcrumb-item active">{{ $course->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Course Information -->
        <div class="col-md-8">
            <div class="card mb-4">
                @if($course->image_path)
                    <img src="{{ asset('storage/' . $course->image_path) }}" class="card-img-top" alt="{{ $course->name }}"
                        style="height: 300px; object-fit: cover;">
                @endif

                <div class="card-body">
                    <h2 class="card-title">{{ $course->name }}</h2>

                    <div class="mb-3">
                        <span class="badge badge-primary">{{ $course->category->name }}</span>
                        <span class="badge badge-info">{{ $course->formatted_duration }}</span>
                        <span class="badge badge-success">${{ number_format($course->price, 2) }}</span>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h6>Instructor</h6>
                            <p>{{ $course->instructor_name }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Max Participants</h6>
                            <p>{{ $course->max_participants }} students</p>
                        </div>
                    </div>

                    <h6>Course Description</h6>
                    <p class="card-text">{{ $course->description }}</p>
                </div>
            </div>

            <!-- Available Schedules -->
            @if($course->schedules->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Available Sessions</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @foreach($course->schedules as $schedule)
                                <div class="col-md-6 mb-3">
                                    <div class="card {{ $schedule->isFull() ? 'border-danger' : 'border-success' }}">
                                        <div class="card-body">
                                            <h6 class="card-title">
                                                {{ $schedule->start_datetime->format('M j, Y') }}
                                            </h6>
                                            <p class="card-text">
                                                <i class="fa fa-clock-o"></i>
                                                {{ $schedule->start_datetime->format('g:i A') }} -
                                                {{ $schedule->end_datetime->format('g:i A') }}
                                            </p>

                                            <div class="row">
                                                <div class="col-6">
                                                    <small class="text-muted">Available Slots:</small><br>
                                                    <span class="{{ $schedule->isFull() ? 'text-danger' : 'text-success' }}">
                                                        {{ $schedule->available_slots - $schedule->booked_slots }} /
                                                        {{ $schedule->available_slots }}
                                                    </span>
                                                </div>
                                                <div class="col-6">
                                                    @auth
                                                        @if(Auth::user()->isStudent())
                                                            @php
                                                                $userHasBooked = $userBookings->where('schedule_id', $schedule->id)->whereNotIn('status', ['cancelled'])->count() > 0;
                                                            @endphp

                                                            @if($userHasBooked)
                                                                <button class="btn btn-secondary btn-sm" disabled>
                                                                    Already Booked
                                                                </button>
                                                            @elseif($schedule->isFull())
                                                                <button class="btn btn-danger btn-sm" disabled>
                                                                    Full
                                                                </button>
                                                            @elseif($schedule->start_datetime <= now())
                                                                <button class="btn btn-secondary btn-sm" disabled>
                                                                    Past Session
                                                                </button>
                                                            @else
                                                                <a href="{{ route('student.bookings.create', ['schedule_id' => $schedule->id]) }}"
                                                                    class="btn btn-primary btn-sm">
                                                                    Book Now
                                                                </a>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                                            Login to Book
                                                        </a>
                                                    @endauth
                                                </div>
                                            </div>

                                            @if($schedule->notes)
                                                <div class="mt-2">
                                                    <small class="text-muted">{{ $schedule->notes }}</small>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center">
                        <i class="fa fa-calendar-o fa-3x text-muted mb-3"></i>
                        <h5>No Sessions Available</h5>
                        <p class="text-muted">This course currently has no scheduled sessions.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Info -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Course Overview</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h4 class="text-primary">${{ number_format($course->price, 2) }}</h4>
                        <small class="text-muted">per session</small>
                    </div>

                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="fa fa-user text-muted"></i>
                            <strong>Instructor:</strong> {{ $course->instructor_name }}
                        </li>
                        <li class="mb-2">
                            <i class="fa fa-clock-o text-muted"></i>
                            <strong>Duration:</strong> {{ $course->formatted_duration }}
                        </li>
                        <li class="mb-2">
                            <i class="fa fa-users text-muted"></i>
                            <strong>Max Participants:</strong> {{ $course->max_participants }}
                        </li>
                        <li class="mb-2">
                            <i class="fa fa-tag text-muted"></i>
                            <strong>Category:</strong> {{ $course->category->name }}
                        </li>
                        @if($course->schedules->count() > 0)
                            <li class="mb-2">
                                <i class="fa fa-calendar text-muted"></i>
                                <strong>Sessions:</strong> {{ $course->schedules->count() }} available
                            </li>
                        @endif
                    </ul>

                    @auth
                        @if(Auth::user()->isStudent())
                            @if($course->schedules->where('start_datetime', '>', now())->count() > 0)
                                <a href="{{ route('student.bookings.create', ['course_id' => $course->id]) }}"
                                    class="btn btn-primary btn-block">
                                    <i class="fa fa-calendar-plus-o"></i> Book This Course
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-block">
                            Login to Book
                        </a>
                    @endauth
                </div>
            </div>

            <!-- User's Bookings for this Course -->
            @auth
                @if(Auth::user()->isStudent() && $userBookings->count() > 0)
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="mb-0">Your Bookings</h6>
                        </div>
                        <div class="card-body">
                            @foreach($userBookings as $booking)
                                <div class="mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                    <div class="d-flex justify-content-between">
                                        <strong>{{ $booking->booking_code }}</strong>
                                        @if($booking->status === 'approved')
                                            <span class="badge badge-success">{{ ucfirst($booking->status) }}</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="badge badge-warning">{{ ucfirst($booking->status) }}</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="badge badge-danger">{{ ucfirst($booking->status) }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </div>
                                    <small class="text-muted">
                                        {{ $booking->schedule->start_datetime->format('M j, Y g:i A') }}
                                    </small>
                                    <div class="mt-2">
                                        <a href="{{ route('student.bookings.show', $booking) }}" class="btn btn-sm btn-outline-primary">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Back to Courses -->
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('student.courses.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fa fa-arrow-left"></i> Back to Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection