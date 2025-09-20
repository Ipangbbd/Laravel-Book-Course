@extends('layouts.admin-layout')

@section('title', 'Booking Details - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Booking Details</h2>
            <div>
                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Edit Booking
                </a>
                @if($booking->payment)
                    <a href="{{ route('admin.payments.show', $booking->payment) }}" class="btn btn-info">
                        <i class="fa fa-credit-card"></i> View Payment
                    </a>
                @endif
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Bookings
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Booking Information -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Booking Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Booking Code:</strong></div>
                    <div class="col-md-9">
                        <code>{{ $booking->booking_code }}</code>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Student:</strong></div>
                    <div class="col-md-9">
                        <strong>{{ $booking->user->name }}</strong>
                        <br>
                        <small class="text-muted">{{ $booking->user->email }}</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Course:</strong></div>
                    <div class="col-md-9">
                        <strong>{{ $booking->schedule->course->name }}</strong>
                        <br>
                        <small class="text-muted">Category: {{ $booking->schedule->course->category->name ?? 'N/A' }}</small>
                        <br>
                        <small class="text-muted">Instructor: {{ $booking->schedule->course->instructor_name ?? 'N/A' }}</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Schedule:</strong></div>
                    <div class="col-md-9">
                        <strong>Start:</strong> {{ $booking->schedule->start_datetime ? $booking->schedule->start_datetime->format('M d, Y H:i') : 'N/A' }}
                        <br>
                        <strong>End:</strong> {{ $booking->schedule->end_datetime ? $booking->schedule->end_datetime->format('M d, Y H:i') : 'N/A' }}
                        @if($booking->schedule->start_datetime && $booking->schedule->end_datetime)
                            <br>
                            <small class="text-muted">Duration: {{ $booking->schedule->start_datetime->diff($booking->schedule->end_datetime)->format('%H:%I hours') }}</small>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Booking Date:</strong></div>
                    <div class="col-md-9">
                        {{ $booking->booked_at ? $booking->booked_at->format('M d, Y H:i') : 'N/A' }}
                        <small class="text-muted">({{ $booking->booked_at ? $booking->booked_at->diffForHumans() : 'N/A' }})</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Status:</strong></div>
                    <div class="col-md-9">
                        @if($booking->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($booking->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($booking->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="badge badge-danger">Cancelled</span>
                        @elseif($booking->status == 'completed')
                            <span class="badge badge-primary">Completed</span>
                        @endif
                    </div>
                </div>

                @if($booking->notes)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Student Notes:</strong></div>
                        <div class="col-md-9">{{ $booking->notes }}</div>
                    </div>
                @endif

                @if($booking->admin_notes)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Admin Notes:</strong></div>
                        <div class="col-md-9">{{ $booking->admin_notes }}</div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Created:</strong></div>
                    <div class="col-md-9">
                        {{ $booking->created_at ? $booking->created_at->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Last Updated:</strong></div>
                    <div class="col-md-9">
                        {{ $booking->updated_at ? $booking->updated_at->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Quick Actions -->
        @if($booking->status == 'pending')
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" class="mb-2">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa fa-check"></i> Approve Booking
                        </button>
                    </form>
                    
                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                        <i class="fa fa-times"></i> Reject Booking
                    </button>
                </div>
            </div>
        @endif

        <!-- Payment Status -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Payment Information</h6>
            </div>
            <div class="card-body">
                @if($booking->payment)
                    <p><strong>Amount:</strong> Rp.{{ number_format($booking->payment->amount, 2) }}</p>
                    <p><strong>Method:</strong> {{ ucfirst($booking->payment->payment_method ?? 'N/A') }}</p>
                    <p><strong>Status:</strong> 
                        @if($booking->payment->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($booking->payment->status == 'verified')
                            <span class="badge badge-success">Verified</span>
                        @elseif($booking->payment->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @endif
                    </p>
                    <a href="{{ route('admin.payments.show', $booking->payment) }}" class="btn btn-info btn-block">
                        <i class="fa fa-credit-card"></i> View Payment Details
                    </a>
                @else
                    <div class="text-center">
                        <i class="fa fa-credit-card fa-2x text-muted"></i>
                        <p class="mt-2 mb-3">No payment submitted yet</p>
                        <a href="{{ route('admin.payments.create', ['booking_id' => $booking->id]) }}" class="btn btn-primary btn-block">
                            <i class="fa fa-plus"></i> Create Payment
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
@if($booking->status == 'pending')
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.bookings.reject', $booking) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Reject Booking</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="rejection_reason">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3" required placeholder="Please provide a reason for rejecting this booking..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection