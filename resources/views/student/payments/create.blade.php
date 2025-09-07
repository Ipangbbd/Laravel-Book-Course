@extends('layouts.app')

@section('title', 'Submit Payment - Course Booking System')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.payments.index') }}">My Payments</a></li>
                <li class="breadcrumb-item active">Submit Payment</li>
            </ol>
        </nav>
        <h2>Submit Payment</h2>
        <p class="text-muted">Upload your payment proof and complete the payment process</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Payment Form</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.payments.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    @if($booking)
                        <!-- Pre-selected Booking -->
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Selected Booking</h6>
                            </div>
                            <div class="card-body">
                                <h5>{{ $booking->schedule->course->name }}</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>Booking Code:</strong> {{ $booking->booking_code }}</p>
                                        <p><strong>Course Category:</strong> {{ $booking->schedule->course->category->name }}</p>
                                        <p><strong>Instructor:</strong> {{ $booking->schedule->course->instructor_name }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>Schedule:</strong> {{ $booking->schedule->start_datetime->format('M j, Y g:i A') }}</p>
                                        <p><strong>Booking Status:</strong> 
                                            <span class="badge badge-{{ $booking->status === 'approved' ? 'success' : 'warning' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Amount:</strong> <span class="text-primary h5">${{ number_format($booking->schedule->course->price, 2) }}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Booking Selection -->
                        <div class="form-group">
                            <label for="booking_id">Select Booking <span class="text-danger">*</span></label>
                            <select class="form-control @error('booking_id') is-invalid @enderror" 
                                    id="booking_id" 
                                    name="booking_id" 
                                    required>
                                <option value="">Choose a booking to pay for...</option>
                                @foreach($bookingsWithoutPayments as $bookingOption)
                                    <option value="{{ $bookingOption->id }}" 
                                            {{ old('booking_id') == $bookingOption->id ? 'selected' : '' }}
                                            data-amount="{{ $bookingOption->schedule->course->price }}">
                                        {{ $bookingOption->booking_code }} - 
                                        {{ $bookingOption->schedule->course->name }} 
                                        ({{ $bookingOption->schedule->start_datetime->format('M j, Y') }}) 
                                        - ${{ number_format($bookingOption->schedule->course->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('booking_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    
                    <!-- Payment Amount -->
                    <div class="form-group">
                        <label for="amount">Payment Amount <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">$</span>
                            </div>
                            <input type="number" 
                                    class="form-control @error('amount') is-invalid @enderror" 
                                    id="amount" 
                                    name="amount" 
                                    value="{{ old('amount', $booking ? $booking->schedule->course->price : '') }}" 
                                    step="0.01" 
                                    min="0" 
                                    required 
                                    {{ $booking ? 'readonly' : '' }}>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <small class="form-text text-muted">Amount must match the course price exactly</small>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                        <select class="form-control @error('payment_method') is-invalid @enderror" 
                                id="payment_method" 
                                name="payment_method" 
                                required>
                            <option value="">Select payment method...</option>
                            <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                            <option value="e_wallet" {{ old('payment_method') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                            <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('payment_method')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <!-- Transaction Reference -->
                    <div class="form-group">
                        <label for="transaction_reference">Transaction Reference (Optional)</label>
                        <input type="text" 
                                class="form-control @error('transaction_reference') is-invalid @enderror" 
                                id="transaction_reference" 
                                name="transaction_reference" 
                                value="{{ old('transaction_reference') }}" 
                                placeholder="Enter transaction ID or reference number">
                        @error('transaction_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Reference number from your bank or payment provider</small>
                    </div>
                    
                    <!-- Payment Proof Upload -->
                    <div class="form-group">
                        <label for="proof_file">Payment Proof <span class="text-danger">*</span></label>
                        <input type="file" 
                                class="form-control-file @error('proof_file') is-invalid @enderror" 
                                id="proof_file" 
                                name="proof_file" 
                                accept=".jpg,.jpeg,.png,.pdf" 
                                required>
                        @error('proof_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">
                            Upload a screenshot or photo of your payment receipt. 
                            Accepted formats: JPG, JPEG, PNG, PDF (Max: 5MB)
                        </small>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="accept_terms" required>
                            <label class="form-check-label" for="accept_terms">
                                I confirm that the payment information is accurate and I agree to the 
                                <a href="#" data-toggle="modal" data-target="#termsModal">payment terms</a> 
                                <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block">
                            <i class="fa fa-upload"></i> Submit Payment
                        </button>
                        <a href="{{ route('student.payments.index') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fa fa-arrow-left"></i> Back to Payments
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <!-- Payment Instructions -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Payment Instructions</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <strong>Important:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Make sure the payment amount matches exactly</li>
                        <li>Upload a clear screenshot or photo of your receipt</li>
                        <li>Include transaction reference for faster processing</li>
                        <li>Payment verification may take up to 48 hours</li>
                    </ul>
                </div>
            </div>
        </div>
        
        <!-- Bank Details -->
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Bank Transfer Details</h6>
            </div>
            <div class="card-body">
                <p><strong>Bank Name:</strong> Course Booking Bank</p>
                <p><strong>Account Name:</strong> Course Booking System</p>
                <p><strong>Account Number:</strong> 1234567890</p>
                <p><strong>Routing Number:</strong> 987654321</p>
                <p><strong>SWIFT Code:</strong> CBSBANK</p>
                <small class="text-muted">
                    Please include your booking code in the transfer description
                </small>
            </div>
        </div>
        
        <!-- Help -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Need Help?</h6>
            </div>
            <div class="card-body">
                <p class="small text-muted">
                    Having trouble with your payment? Contact our support team.
                </p>
                <p class="small">
                    <strong>Email:</strong> codevwithali@coursebooking.com<br>
                    <strong>Phone:</strong> (555) 123-4567
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Payment Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment Terms & Conditions</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Payment Processing</h6>
                <ul>
                    <li>All payments are subject to verification by our admin team</li>
                    <li>Payment verification may take up to 48 hours</li>
                    <li>Incomplete or unclear payment proofs may be rejected</li>
                    <li>Payment amount must match the course price exactly</li>
                </ul>
                
                <h6>Refund Policy</h6>
                <ul>
                    <li>Refunds are processed for cancelled bookings made 24+ hours before session</li>
                    <li>Refund processing takes 5-7 business days</li>
                    <li>Transaction fees may be deducted from refunds</li>
                    <li>No-shows are not eligible for refunds</li>
                </ul>
                
                <h6>Payment Security</h6>
                <ul>
                    <li>Upload only genuine payment receipts</li>
                    <li>Do not share payment proofs with unauthorized parties</li>
                    <li>Report any payment discrepancies immediately</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    I Understand
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bookingSelect = document.getElementById('booking_id');
    const amountInput = document.getElementById('amount');
    
    if (bookingSelect && amountInput) {
        bookingSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const amount = selectedOption.getAttribute('data-amount');
                amountInput.value = amount;
            } else {
                amountInput.value = '';
            }
        });
    }
    
    // File upload preview
    const fileInput = document.getElementById('proof_file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const fileSize = (file.size / 1024 / 1024).toFixed(2);
                console.log('Selected file:', file.name, 'Size:', fileSize + 'MB');
                
                if (fileSize > 5) {
                    alert('File size is too large. Please select a file smaller than 5MB.');
                    this.value = '';
                }
            }
        });
    }
});
</script>
@endsection