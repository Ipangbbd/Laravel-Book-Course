@extends('layouts.app')

@section('title', 'My Bookings - Course Booking System')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2>My Bookings</h2>
            <p class="text-muted">Manage your course bookings and track their status</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Filter Bookings</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('student.bookings.index') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved
                                    </option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="booking_code" class="form-label">Booking Code</label>
                                <input type="text" class="form-control" id="booking_code" name="booking_code"
                                    value="{{ request('booking_code') }}" placeholder="Search by booking code">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="course_name" class="form-label">Course Name</label>
                                <input type="text" class="form-control" id="course_name" name="course_name"
                                    value="{{ request('course_name') }}" placeholder="Search by course name">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('student.bookings.index') }}" class="btn btn-outline-secondary">
                                        Clear
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('student.courses.index') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Book New Course
            </a>
        </div>
    </div>

    @if($bookings->count() > 0)
        <!-- Bookings List -->
        <div class="row">
            @foreach($bookings as $booking)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $booking->booking_code }}</strong>
                                @if($booking->status === 'approved')
                                    <span class="badge badge-success">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status === 'pending')
                                    <span class="badge badge-warning">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="badge badge-danger">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status === 'completed')
                                    <span class="badge badge-primary">{{ ucfirst($booking->status) }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            <h6 class="card-title">{{ $booking->schedule->course->name }}</h6>
                            <p class="card-text text-muted small">
                                {{ $booking->schedule->course->category->name }}
                            </p>

                            <div class="mb-2">
                                <small class="text-muted">Schedule:</small><br>
                                <strong>{{ $booking->schedule->start_datetime->format('M j, Y') }}</strong><br>
                                <small>{{ $booking->schedule->start_datetime->format('g:i A') }} -
                                    {{ $booking->schedule->end_datetime->format('g:i A') }}</small>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Booked:</small>
                                <span>{{ $booking->booked_at->format('M j, Y') }}</span>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Instructor:</small>
                                <span>{{ $booking->schedule->course->instructor_name }}</span>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Payment Status:</small>
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
                            </div>

                            @if($booking->notes)
                                <div class="mb-2">
                                    <small class="text-muted">Notes:</small>
                                    <p class="small">{{ Str::limit($booking->notes, 50) }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <a href="{{ route('student.bookings.show', $booking) }}" class="btn btn-outline-primary">
                                    <i class="fa fa-eye"></i> View
                                </a>

                                @if(!$booking->payment)
                                    <a href="{{ route('student.payments.create', ['booking_id' => $booking->id]) }}"
                                        class="btn btn-outline-success">
                                        <i class="fa fa-credit-card"></i> Pay
                                    </a>
                                @endif

                                @if($booking->canBeCancelled())
                                    <button type="button" class="btn btn-outline-danger" data-toggle="modal"
                                        data-target="#cancelModal{{ $booking->id }}">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Cancel Modal -->
                    @if($booking->canBeCancelled())
                        <div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <form method="POST" action="{{ route('student.bookings.cancel', $booking) }}">
                                        @csrf
                                        @method('PATCH')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Cancel Booking</h5>
                                            <button type="button" class="close" data-dismiss="modal">
                                                <span>&times;</span>
                                            </button>
                                        </div>

                                        <div class="modal-body">
                                            <p>Are you sure you want to cancel your booking for
                                                <strong>{{ $booking->schedule->course->name }}</strong>?</p>

                                            <div class="form-group">
                                                <label for="cancellation_reason{{ $booking->id }}">Reason for cancellation:</label>
                                                <textarea class="form-control" id="cancellation_reason{{ $booking->id }}"
                                                    name="cancellation_reason" rows="3" required
                                                    placeholder="Please provide a reason for cancelling this booking"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                Keep Booking
                                            </button>
                                            <button type="submit" class="btn btn-danger">
                                                Cancel Booking
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                {{ $bookings->links() }}
            </div>
        </div>
    @else
        <!-- No Bookings -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fa fa-calendar-o fa-3x text-muted mb-3"></i>
                        <h5>No Bookings Found</h5>
                        @if(request()->hasAny(['status', 'booking_code', 'course_name']))
                            <p class="text-muted">
                                No bookings match your search criteria. Try adjusting your filters.
                            </p>
                            <a href="{{ route('student.bookings.index') }}" class="btn btn-primary">
                                Clear Filters
                            </a>
                        @else
                            <p class="text-muted">
                                You haven't made any bookings yet. Start by browsing our available courses.
                            </p>
                            <a href="{{ route('student.courses.index') }}" class="btn btn-primary">
                                Browse Courses
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection