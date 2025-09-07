@extends('layouts.app')

@section('title', 'Booking Details - ' . $booking->booking_code)

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('student.bookings.index') }}">My Bookings</a></li>
                    <li class="breadcrumb-item active">{{ $booking->booking_code }}</li>
                </ol>
            </nav>
            <h2>Booking Details</h2>
            <p class="text-muted">View your booking information and status</p>
        </div>
    </div>

    <div class="row">
        <!-- Main Booking Information -->
        <div class="col-md-8">
            <!-- Booking Status Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Booking Status</h5>
                        @if($booking->status === 'approved')
                            <span class="badge badge-success badge-pill">{{ ucfirst($booking->status) }}</span>
                        @elseif($booking->status === 'pending')
                            <span class="badge badge-warning badge-pill">{{ ucfirst($booking->status) }}</span>
                        @elseif($booking->status === 'cancelled')
                            <span class="badge badge-danger badge-pill">{{ ucfirst($booking->status) }}</span>
                        @elseif($booking->status === 'completed')
                            <span class="badge badge-primary badge-pill">{{ ucfirst($booking->status) }}</span>
                        @else
                            <span class="badge badge-secondary badge-pill">{{ ucfirst($booking->status) }}</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Booking Information</h6>
                            <p><strong>Booking Code:</strong> {{ $booking->booking_code }}</p>
                            <p><strong>Booking Date:</strong> {{ $booking->booked_at->format('M j, Y g:i A') }}</p>
                            <p><strong>Status:</strong>
                                @if($booking->status === 'approved')
                                    <span class="text-success">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status === 'pending')
                                    <span class="text-warning">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="text-danger">{{ ucfirst($booking->status) }}</span>
                                @else
                                    <span class="text-secondary">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6>Payment Status</h6>
                            @if($booking->payment)
                                <p><strong>Payment Status:</strong>
                                    @if($booking->payment->status === 'verified')
                                        <span class="text-success">{{ ucfirst($booking->payment->status) }}</span>
                                    @elseif($booking->payment->status === 'pending')
                                        <span class="text-warning">{{ ucfirst($booking->payment->status) }}</span>
                                    @else
                                        <span class="text-danger">{{ ucfirst($booking->payment->status) }}</span>
                                    @endif
                                </p>
                                <p><strong>Amount:</strong> ${{ number_format($booking->payment->amount, 2) }}</p>
                                <p><strong>Payment Date:</strong> {{ $booking->payment->paid_at->format('M j, Y') }}</p>
                            @else
                                <p><strong>Payment Status:</strong> <span class="text-secondary">Not Paid</span></p>
                                <p><strong>Amount Due:</strong> ${{ number_format($booking->schedule->course->price, 2) }}</p>
                            @endif
                        </div>
                    </div>

                    @if($booking->notes)
                        <div class="mt-3">
                            <h6>Your Notes</h6>
                            <p class="text-muted">{{ $booking->notes }}</p>
                        </div>
                    @endif

                    @if($booking->admin_notes)
                        <div class="mt-3">
                            <h6>Admin Notes</h6>
                            <div class="alert alert-info">
                                {{ $booking->admin_notes }}
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Course Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            @if($booking->schedule->course->image_path)
                                <img src="{{ asset('storage/' . $booking->schedule->course->image_path) }}"
                                    class="img-fluid rounded" alt="{{ $booking->schedule->course->name }}">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                    style="height: 150px;">
                                    <i class="fa fa-book fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h4>{{ $booking->schedule->course->name }}</h4>
                            <p class="text-muted">{{ $booking->schedule->course->description }}</p>

                            <div class="row">
                                <div class="col-6">
                                    <p><strong>Category:</strong> {{ $booking->schedule->course->category->name }}</p>
                                    <p><strong>Instructor:</strong> {{ $booking->schedule->course->instructor_name }}</p>
                                    <p><strong>Duration:</strong> {{ $booking->schedule->course->formatted_duration }}</p>
                                </div>
                                <div class="col-6">
                                    <p><strong>Price:</strong> ${{ number_format($booking->schedule->course->price, 2) }}
                                    </p>
                                    <p><strong>Max Participants:</strong> {{ $booking->schedule->course->max_participants }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Schedule Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Session Date & Time</h6>
                            <p><strong>Date:</strong> {{ $booking->schedule->start_datetime->format('l, M j, Y') }}</p>
                            <p><strong>Start Time:</strong> {{ $booking->schedule->start_datetime->format('g:i A') }}</p>
                            <p><strong>End Time:</strong> {{ $booking->schedule->end_datetime->format('g:i A') }}</p>
                            <p><strong>Duration:</strong>
                                {{ $booking->schedule->start_datetime->diffInMinutes($booking->schedule->end_datetime) }}
                                minutes</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Availability</h6>
                            <p><strong>Total Slots:</strong> {{ $booking->schedule->available_slots }}</p>
                            <p><strong>Booked Slots:</strong> {{ $booking->schedule->booked_slots }}</p>
                            <p><strong>Available Slots:</strong>
                                {{ $booking->schedule->available_slots - $booking->schedule->booked_slots }}</p>

                            @if($booking->schedule->notes)
                                <h6 class="mt-3">Schedule Notes</h6>
                                <p class="text-muted">{{ $booking->schedule->notes }}</p>
                            @endif
                        </div>
                    </div>

                    @if($booking->schedule->start_datetime > now())
                        <div class="alert alert-info mt-3">
                            <i class="fa fa-clock-o"></i>
                            <strong>Upcoming Session:</strong>
                            This session is scheduled for {{ $booking->schedule->start_datetime->diffForHumans() }}.
                        </div>
                    @elseif($booking->schedule->start_datetime <= now() && $booking->schedule->end_datetime > now())
                        <div class="alert alert-warning mt-3">
                            <i class="fa fa-play"></i>
                            <strong>Session in Progress:</strong>
                            This session is currently ongoing.
                        </div>
                    @else
                        <div class="alert alert-secondary mt-3">
                            <i class="fa fa-check"></i>
                            <strong>Session Completed:</strong>
                            This session ended {{ $booking->schedule->end_datetime->diffForHumans() }}.
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    @if(!$booking->payment)
                        <a href="{{ route('student.payments.create', ['booking_id' => $booking->id]) }}"
                            class="btn btn-success btn-block mb-2">
                            <i class="fa fa-credit-card"></i> Make Payment
                        </a>
                    @elseif($booking->payment)
                        <a href="{{ route('student.payments.show', $booking->payment) }}"
                            class="btn btn-outline-info btn-block mb-2">
                            <i class="fa fa-eye"></i> View Payment
                        </a>
                    @endif

                    @if($booking->canBeCancelled())
                        <button type="button" class="btn btn-outline-danger btn-block mb-2" data-toggle="modal"
                            data-target="#cancelModal">
                            <i class="fa fa-times"></i> Cancel Booking
                        </button>
                    @endif

                    <a href="{{ route('student.bookings.index') }}" class="btn btn-outline-secondary btn-block">
                        <i class="fa fa-arrow-left"></i> Back to Bookings
                    </a>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="mb-0">Need Help?</h6>
                </div>
                <div class="card-body">
                    <p class="small text-muted">
                        If you have any questions about your booking or need assistance,
                        please contact our support team.
                    </p>
                    <p class="small">
                        <strong>Email:</strong> support@coursebooking.com<br>
                        <strong>Phone:</strong> (555) 123-4567
                    </p>
                </div>
            </div>

            <!-- Course Link -->
            <div class="card">
                <div class="card-body text-center">
                    <a href="{{ route('student.courses.show', $booking->schedule->course) }}"
                        class="btn btn-outline-primary btn-block">
                        <i class="fa fa-book"></i> View Course Details
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    @if($booking->canBeCancelled())
        <div class="modal fade" id="cancelModal" tabindex="-1">
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
                            <div class="alert alert-warning">
                                <i class="fa fa-exclamation-triangle"></i>
                                <strong>Warning:</strong> This action cannot be undone.
                            </div>

                            <p>Are you sure you want to cancel your booking for:</p>
                            <ul>
                                <li><strong>Course:</strong> {{ $booking->schedule->course->name }}</li>
                                <li><strong>Date:</strong> {{ $booking->schedule->start_datetime->format('M j, Y g:i A') }}</li>
                                <li><strong>Booking Code:</strong> {{ $booking->booking_code }}</li>
                            </ul>

                            <div class="form-group">
                                <label for="cancellation_reason">Reason for cancellation: <span
                                        class="text-danger">*</span></label>
                                <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3"
                                    required placeholder="Please provide a reason for cancelling this booking"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                Keep Booking
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancel Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection