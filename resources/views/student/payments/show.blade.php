@extends('layouts.app')

@section('title', 'Payment Details - ' . $payment->booking->booking_code)

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.payments.index') }}">My Payments</a></li>
                <li class="breadcrumb-item active">Payment Details</li>
            </ol>
        </nav>
        <h2>Payment Details</h2>
        <p class="text-muted">View your payment information and status</p>
    </div>
</div>

<div class="row">
    <!-- Payment Information -->
    <div class="col-md-8">
        <!-- Payment Status Card -->
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payment Status</h5>
                    @if($payment->status === 'verified')
                        <span class="badge badge-success badge-pill">{{ ucfirst($payment->status) }}</span>
                    @elseif($payment->status === 'pending')
                        <span class="badge badge-warning badge-pill">{{ ucfirst($payment->status) }}</span>
                    @elseif($payment->status === 'rejected')
                        <span class="badge badge-danger badge-pill">{{ ucfirst($payment->status) }}</span>
                    @else
                        <span class="badge badge-secondary badge-pill">{{ ucfirst($payment->status) }}</span>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if($payment->status === 'verified')
                    <div class="alert alert-success">
                        <i class="fa fa-check-circle"></i>
                        <strong>Payment Verified!</strong> Your payment has been confirmed and your booking is approved.
                    </div>
                @elseif($payment->status === 'pending')
                    <div class="alert alert-warning">
                        <i class="fa fa-clock-o"></i>
                        <strong>Payment Under Review:</strong> Your payment is being verified by our admin team. This process may take up to 48 hours.
                    </div>
                @elseif($payment->status === 'rejected')
                    <div class="alert alert-danger">
                        <i class="fa fa-times-circle"></i>
                        <strong>Payment Rejected:</strong> Your payment has been rejected. Please see the reason below and submit a new payment.
                    </div>
                @endif
                
                <div class="row">
                    <div class="col-md-6">
                        <h6>Payment Information</h6>
                        <p><strong>Amount:</strong> <span class="text-primary h5">${{ number_format($payment->amount, 2) }}</span></p>
                        <p><strong>Payment Method:</strong> {{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</p>
                        <p><strong>Payment Date:</strong> {{ $payment->paid_at->format('M j, Y g:i A') }}</p>
                        @if($payment->transaction_reference)
                            <p><strong>Transaction Reference:</strong> {{ $payment->transaction_reference }}</p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        <h6>Verification Details</h6>
                        @if($payment->verified_at)
                            <p><strong>Verified Date:</strong> {{ $payment->verified_at->format('M j, Y g:i A') }}</p>
                        @endif
                        @if($payment->verifiedBy)
                            <p><strong>Verified By:</strong> {{ $payment->verifiedBy->name }}</p>
                        @endif
                        @if($payment->status === 'rejected' && $payment->rejection_reason)
                            <p><strong>Rejection Reason:</strong></p>
                            <div class="alert alert-danger">
                                {{ $payment->rejection_reason }}
                            </div>
                        @endif
                    </div>
                </div>
                
                @if($payment->admin_notes)
                    <div class="mt-3">
                        <h6>Admin Notes</h6>
                        <div class="alert alert-info">
                            {{ $payment->admin_notes }}
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Payment Proof -->
        @if($payment->proof_path)
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Payment Proof</h5>
                    <a href="{{ route('student.payments.download-proof', $payment) }}" 
                       class="btn btn-sm btn-outline-primary">
                        <i class="fa fa-download"></i> Download
                    </a>
                </div>
            </div>
            <div class="card-body">
                @php
                    $fileExtension = pathinfo($payment->proof_path, PATHINFO_EXTENSION);
                @endphp
                
                @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']))
                    <div class="text-center">
                        <img src="{{ asset('storage/' . $payment->proof_path) }}" 
                                class="img-fluid rounded" 
                                alt="Payment Proof" 
                                style="max-height: 400px;">
                    </div>
                @elseif(strtolower($fileExtension) === 'pdf')
                    <div class="text-center">
                        <i class="fa fa-file-pdf-o fa-5x text-danger mb-3"></i>
                        <p>PDF Payment Proof</p>
                        <a href="{{ route('student.payments.download-proof', $payment) }}" 
                            class="btn btn-primary">
                            <i class="fa fa-download"></i> Download PDF
                        </a>
                    </div>
                @else
                    <div class="text-center">
                        <i class="fa fa-file fa-5x text-muted mb-3"></i>
                        <p>Payment Proof File</p>
                        <a href="{{ route('student.payments.download-proof', $payment) }}" 
                            class="btn btn-primary">
                            <i class="fa fa-download"></i> Download File
                        </a>
                    </div>
                @endif
            </div>
        </div>
        @endif
        
        <!-- Related Booking -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Related Booking</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if($payment->booking->schedule->course->image_path)
                            <img src="{{ asset('storage/' . $payment->booking->schedule->course->image_path) }}" 
                                    class="img-fluid rounded" 
                                    alt="{{ $payment->booking->schedule->course->name }}">
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 150px;">
                                <i class="fa fa-book fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $payment->booking->schedule->course->name }}</h4>
                        <p class="text-muted">{{ $payment->booking->schedule->course->category->name }}</p>
                        
                        <div class="row">
                            <div class="col-6">
                                <p><strong>Booking Code:</strong> {{ $payment->booking->booking_code }}</p>
                                <p><strong>Instructor:</strong> {{ $payment->booking->schedule->course->instructor_name }}</p>
                                <p><strong>Session Date:</strong> {{ $payment->booking->schedule->start_datetime->format('M j, Y') }}</p>
                            </div>
                            <div class="col-6">
                                <p><strong>Session Time:</strong> {{ $payment->booking->schedule->start_datetime->format('g:i A') }}</p>
                                <p><strong>Booking Status:</strong> 
                                    @if($payment->booking->status === 'approved')
                                        <span class="badge badge-success">{{ ucfirst($payment->booking->status) }}</span>
                                    @elseif($payment->booking->status === 'pending')
                                        <span class="badge badge-warning">{{ ucfirst($payment->booking->status) }}</span>
                                    @else
                                        <span class="badge badge-secondary">{{ ucfirst($payment->booking->status) }}</span>
                                    @endif
                                </p>
                                <p><strong>Booked:</strong> {{ $payment->booking->booked_at->format('M j, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Actions</h6>
            </div>
            <div class="card-body">
                @if($payment->proof_path)
                    <a href="{{ route('student.payments.download-proof', $payment) }}" 
                        class="btn btn-outline-primary btn-block mb-2">
                        <i class="fa fa-download"></i> Download Proof
                    </a>
                @endif
                
                <a href="{{ route('student.bookings.show', $payment->booking) }}" 
                    class="btn btn-outline-info btn-block mb-2">
                    <i class="fa fa-calendar"></i> View Booking
                </a>
                
                @if($payment->status === 'rejected')
                    <a href="{{ route('student.payments.create', ['booking_id' => $payment->booking->id]) }}" 
                        class="btn btn-success btn-block mb-2">
                        <i class="fa fa-plus"></i> Submit New Payment
                    </a>
                @endif
                
                <a href="{{ route('student.payments.index') }}" 
                    class="btn btn-outline-secondary btn-block">
                    <i class="fa fa-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
        
        <!-- Payment Timeline -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Payment Timeline</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item">
                        <div class="timeline-marker bg-success"></div>
                        <div class="timeline-content">
                            <h6 class="timeline-title">Payment Submitted</h6>
                            <p class="timeline-text">{{ $payment->paid_at->format('M j, Y g:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($payment->status === 'verified')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Payment Verified</h6>
                                <p class="timeline-text">{{ $payment->verified_at->format('M j, Y g:i A') }}</p>
                                @if($payment->verifiedBy)
                                    <small class="text-muted">by {{ $payment->verifiedBy->name }}</small>
                                @endif
                            </div>
                        </div>
                    @elseif($payment->status === 'rejected')
                        <div class="timeline-item">
                            <div class="timeline-marker bg-danger"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Payment Rejected</h6>
                                <p class="timeline-text">{{ $payment->verified_at ? $payment->verified_at->format('M j, Y g:i A') : 'Recently' }}</p>
                                @if($payment->verifiedBy)
                                    <small class="text-muted">by {{ $payment->verifiedBy->name }}</small>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="timeline-item">
                            <div class="timeline-marker bg-warning"></div>
                            <div class="timeline-content">
                                <h6 class="timeline-title">Under Review</h6>
                                <p class="timeline-text">Waiting for admin verification</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Contact Support -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Need Help?</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Having issues with your payment? Contact our support team.
                </p>
                <p class="small">
                    <strong>Email:</strong> payments@coursebooking.com<br>
                    <strong>Phone:</strong> (555) 123-4567
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding-left: 30px;
}

.timeline-item {
    position: relative;
    margin-bottom: 20px;
}

.timeline-marker {
    position: absolute;
    left: -35px;
    top: 5px;
    width: 12px;
    height: 12px;
    border-radius: 50%;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: -30px;
    top: 17px;
    width: 2px;
    height: calc(100% + 8px);
    background-color: #dee2e6;
}

.timeline-title {
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 5px;
}

.timeline-text {
    font-size: 12px;
    color: #6c757d;
    margin-bottom: 0;
}
</style>
@endsection