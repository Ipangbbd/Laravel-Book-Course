@extends('layouts.app')

@section('title', 'Payment Details - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Payment Details</h2>
            <div>
                <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Edit Payment
                </a>
                <a href="{{ route('admin.bookings.show', $payment->booking) }}" class="btn btn-info">
                    <i class="fa fa-calendar"></i> View Booking
                </a>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Payment Information -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payment Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Amount:</strong></div>
                    <div class="col-md-9">
                        <h4 class="text-success">${{ number_format($payment->amount, 2) }}</h4>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Payment Method:</strong></div>
                    <div class="col-md-9">
                        {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Payment Date:</strong></div>
                    <div class="col-md-9">
                        {{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i') : 'N/A' }}
                        @if($payment->paid_at)
                            <small class="text-muted">({{ $payment->paid_at->diffForHumans() }})</small>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Status:</strong></div>
                    <div class="col-md-9">
                        @if($payment->status == 'pending')
                            <span class="badge badge-warning">Pending</span>
                        @elseif($payment->status == 'verified')
                            <span class="badge badge-success">Verified</span>
                        @elseif($payment->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @endif
                    </div>
                </div>

                @if($payment->verified_at)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Verified Date:</strong></div>
                        <div class="col-md-9">
                            {{ $payment->verified_at->format('M d, Y H:i') }}
                            @if($payment->verifiedBy)
                                <br>
                                <small class="text-muted">by {{ $payment->verifiedBy->name }}</small>
                            @endif
                        </div>
                    </div>
                @endif

                @if($payment->rejection_reason)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Rejection Reason:</strong></div>
                        <div class="col-md-9">
                            <div class="alert alert-danger">
                                {{ $payment->rejection_reason }}
                            </div>
                        </div>
                    </div>
                @endif

                @if($payment->admin_notes)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Admin Notes:</strong></div>
                        <div class="col-md-9">{{ $payment->admin_notes }}</div>
                    </div>
                @endif

                @if($payment->proof_path)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Payment Proof:</strong></div>
                        <div class="col-md-9">
                            <a href="{{ Storage::url($payment->proof_path) }}" target="_blank" class="btn btn-info btn-sm">
                                <i class="fa fa-download"></i> View Proof
                            </a>
                        </div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Created:</strong></div>
                    <div class="col-md-9">
                        {{ $payment->created_at ? $payment->created_at->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Last Updated:</strong></div>
                    <div class="col-md-9">
                        {{ $payment->updated_at ? $payment->updated_at->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Quick Actions -->
        @if($payment->status == 'pending')
            <div class="card mb-3">
                <div class="card-header">
                    <h6 class="mb-0">Quick Actions</h6>
                </div>
                <div class="card-body">
                    <button type="button" class="btn btn-success btn-block mb-2" data-toggle="modal" data-target="#verifyModal">
                        <i class="fa fa-check"></i> Verify Payment
                    </button>
                    
                    <button type="button" class="btn btn-danger btn-block" data-toggle="modal" data-target="#rejectModal">
                        <i class="fa fa-times"></i> Reject Payment
                    </button>
                </div>
            </div>
        @endif

        <!-- Booking Information -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Related Booking</h6>
            </div>
            <div class="card-body">
                <p><strong>Booking Code:</strong> <code>{{ $payment->booking->booking_code }}</code></p>
                <p><strong>Student:</strong> {{ $payment->booking->user->name }}</p>
                <p><strong>Course:</strong> {{ $payment->booking->schedule->course->name }}</p>
                <p><strong>Schedule:</strong> {{ $payment->booking->schedule->start_datetime ? $payment->booking->schedule->start_datetime->format('M d, Y H:i') : 'N/A' }}</p>
                <p><strong>Booking Status:</strong> 
                    @if($payment->booking->status == 'pending')
                        <span class="badge badge-warning">Pending</span>
                    @elseif($payment->booking->status == 'approved')
                        <span class="badge badge-success">Approved</span>
                    @elseif($payment->booking->status == 'rejected')
                        <span class="badge badge-danger">Rejected</span>
                    @elseif($payment->booking->status == 'cancelled')
                        <span class="badge badge-danger">Cancelled</span>
                    @elseif($payment->booking->status == 'completed')
                        <span class="badge badge-primary">Completed</span>
                    @endif
                </p>
                <a href="{{ route('admin.bookings.show', $payment->booking) }}" class="btn btn-info btn-block">
                    <i class="fa fa-calendar"></i> View Full Booking Details
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Verify Modal -->
@if($payment->status == 'pending')
<div class="modal fade" id="verifyModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.payments.verify', $payment) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Verify Payment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
                    <p><strong>Student:</strong> {{ $payment->booking->user->name }}</p>
                    <div class="form-group">
                        <label for="admin_notes">Admin Notes</label>
                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="3" placeholder="Optional notes about the verification..."></textarea>
                    </div>
                    <div class="alert alert-info">
                        <strong>Note:</strong> Verifying this payment will automatically confirm the associated booking.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Verify Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h5 class="modal-title">Reject Payment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
                    <p><strong>Student:</strong> {{ $payment->booking->user->name }}</p>
                    <div class="form-group">
                        <label for="rejection_reason">Rejection Reason <span class="text-danger">*</span></label>
                        <textarea name="rejection_reason" id="rejection_reason" class="form-control" rows="3" required placeholder="Please provide a reason for rejecting this payment..."></textarea>
                    </div>
                    <div class="form-group">
                        <label for="admin_notes">Admin Notes</label>
                        <textarea name="admin_notes" class="form-control" rows="2" placeholder="Optional additional notes..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Reject Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endsection