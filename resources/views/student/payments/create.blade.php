@extends('layouts.app')

@section('title', 'Submit Payment - Xperium Academy')

@section('content')
<style>
    /* Payment Create Styles */
    .breadcrumb {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
    }

    .breadcrumb-item {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .breadcrumb-item.active {
        color: var(--text-primary);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: var(--text-muted);
    }

    .breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .breadcrumb a:hover {
        color: var(--text-primary);
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        font-size: 1.125rem;
        color: var(--text-secondary);
        margin: 0;
    }

    /* Form Card */
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .form-header {
        background: var(--secondary-bg);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-body {
        padding: 2rem;
    }

    /* Selected Booking Card */
    .selected-booking-card {
        background: var(--card-bg);
        border: 2px solid var(--success);
        border-radius: 16px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .selected-booking-header {
        background: linear-gradient(135deg, var(--success) 0%, rgba(34, 197, 94, 0.8) 100%);
        color: var(--primary-bg);
        padding: 1.5rem 2rem;
    }

    .selected-booking-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .selected-booking-body {
        padding: 2rem;
    }

    .booking-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .booking-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .detail-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .detail-value {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .detail-value.highlight {
        color: var(--success);
        font-weight: 600;
        font-size: 1rem;
    }

    .detail-value.amount {
        color: var(--accent);
        font-weight: 700;
        font-size: 1.25rem;
    }

    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.025em;
    }

    .status-badge.approved {
        background: rgba(34, 197, 94, 0.15);
        color: var(--success);
        border: 1px solid rgba(34, 197, 94, 0.3);
    }

    .status-badge.pending {
        background: rgba(251, 191, 36, 0.15);
        color: var(--warning);
        border: 1px solid rgba(251, 191, 36, 0.3);
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .form-label .required {
        color: var(--error);
        margin-left: 0.25rem;
    }

    .form-control {
        background: var(--secondary-bg);
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus {
        background: var(--secondary-bg);
        border-color: var(--accent);
        color: var(--text-primary);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .form-control.is-invalid {
        border-color: var(--error);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .form-control option {
        background: var(--secondary-bg);
        color: var(--text-primary);
        padding: 0.5rem;
    }

    .form-control[readonly] {
        background: var(--hover);
        border-color: var(--border-color);
        opacity: 0.8;
    }

    .input-group {
        display: flex;
        width: 100%;
    }

    .input-group-prepend {
        display: flex;
    }

    .input-group-text {
        background: var(--secondary-bg);
        border: 2px solid var(--border-color);
        border-right: none;
        color: var(--text-secondary);
        padding: 1rem 1.25rem;
        border-radius: 12px 0 0 12px;
        font-weight: 600;
    }

    .input-group .form-control {
        border-radius: 0 12px 12px 0;
        border-left: none;
    }

    .input-group .form-control:focus {
        border-left: 2px solid var(--accent);
    }

    .invalid-feedback {
        color: var(--error);
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-text {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

    /* File Input */
    .form-control-file {
        background: var(--secondary-bg);
        border: 2px dashed var(--border-color);
        color: var(--text-primary);
        border-radius: 12px;
        padding: 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
        cursor: pointer;
    }

    .form-control-file:hover {
        border-color: var(--accent);
        background: var(--hover);
    }

    .form-control-file:focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        outline: none;
    }

    .form-control-file.is-invalid {
        border-color: var(--error);
    }

    /* Checkbox */
    .form-check {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        background: var(--secondary-bg);
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .form-check-input:checked {
        background: var(--accent);
        border-color: var(--accent);
    }

    .form-check-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        cursor: pointer;
        user-select: none;
    }

    .form-check-label a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 600;
    }

    .form-check-label a:hover {
        color: var(--text-primary);
        text-decoration: underline;
    }

    /* Buttons */
    .modern-btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom: 1rem;
    }

    .btn-success-modern {
        background: var(--success);
        color: var(--primary-bg);
    }

    .btn-success-modern:hover {
        background: rgba(34, 197, 94, 0.8);
        color: var(--primary-bg);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .btn-outline-modern {
        background: transparent;
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .btn-outline-modern:hover {
        background: var(--hover);
        border-color: var(--hover);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Sidebar Cards */
    .sidebar-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .sidebar-header {
        background: var(--secondary-bg);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-body {
        padding: 1.5rem;
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: var(--info);
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-info i {
        font-size: 1.25rem;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .alert-info ul {
        margin: 0.5rem 0 0;
        padding-left: 1rem;
    }

    .alert-info li {
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .bank-details {
        color: var(--text-secondary);
        line-height: 1.6;
    }

    .bank-details p {
        margin-bottom: 0.5rem;
    }

    .bank-details strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    .help-info {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .contact-details {
        font-size: 0.875rem;
        line-height: 1.6;
    }

    .contact-details strong {
        color: var(--text-primary);
        font-weight: 600;
    }

    /* Modal Styles */
    .modal-content {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
    }

    .modal-header {
        background: var(--secondary-bg);
        border-bottom: 1px solid var(--border-color);
        border-radius: 16px 16px 0 0;
        padding: 1.5rem 2rem;
    }

    .modal-title {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 1.25rem;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modal-body {
        color: var(--text-secondary);
        padding: 2rem;
        line-height: 1.6;
    }

    .modal-body h6 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.75rem;
        margin-top: 1.5rem;
    }

    .modal-body h6:first-child {
        margin-top: 0;
    }

    .modal-body ul {
        margin: 1rem 0;
        padding-left: 1.5rem;
    }

    .modal-body li {
        margin-bottom: 0.5rem;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
        background: var(--secondary-bg);
        border-radius: 0 0 16px 16px;
        padding: 1rem 2rem;
    }

    .close {
        color: var(--text-secondary);
        opacity: 0.8;
        font-size: 1.5rem;
        background: none;
        border: none;
        padding: 0;
        width: 2rem;
        height: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        transition: all 0.2s ease;
    }

    .close:hover {
        color: var(--text-primary);
        opacity: 1;
        background: var(--hover);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .form-body {
            padding: 1.5rem;
        }
        
        .selected-booking-body {
            padding: 1.5rem;
        }
        
        .booking-details-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .sidebar-body {
            padding: 1.25rem;
        }
    }
</style>
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.payments.index') }}">My Payments</a></li>
                <li class="breadcrumb-item active">Submit Payment</li>
            </ol>
        </nav>
        <div class="page-header">
            <h2 class="page-title">Submit Payment</h2>
            <p class="page-subtitle">Upload your payment proof and complete the payment process</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-card">
            <div class="form-header">
                <h5 class="form-title">
                    <i class="fa fa-credit-card"></i>
                    Payment Form
                </h5>
            </div>
            <div class="form-body">
                <form method="POST" action="{{ route('student.payments.store') }}" enctype="multipart/form-data">
                    @csrf
                    
                    @if($booking)
                        <!-- Pre-selected Booking -->
                        <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                        
                        <div class="selected-booking-card">
                            <div class="selected-booking-header">
                                <h6 class="selected-booking-title">
                                    <i class="fa fa-check-circle"></i>
                                    Selected Booking
                                </h6>
                            </div>
                            <div class="selected-booking-body">
                                <h5 class="booking-name">{{ $booking->schedule->course->name }}</h5>
                                <div class="booking-details-grid">
                                    <div class="detail-group">
                                        <div class="detail-item">
                                            <span class="detail-label">Booking Code:</span>
                                            <span class="detail-value">{{ $booking->booking_code }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Course Category:</span>
                                            <span class="detail-value">{{ $booking->schedule->course->category->name }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Instructor:</span>
                                            <span class="detail-value">{{ $booking->schedule->course->instructor_name }}</span>
                                        </div>
                                    </div>
                                    <div class="detail-group">
                                        <div class="detail-item">
                                            <span class="detail-label">Schedule:</span>
                                            <span class="detail-value">{{ $booking->schedule->start_datetime->format('M j, Y g:i A') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Booking Status:</span>
                                            <span class="status-badge {{ $booking->status === 'approved' ? 'approved' : 'pending' }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Amount:</span>
                                            <span class="detail-value amount">Rp.{{ number_format($booking->schedule->course->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <!-- Booking Selection -->
                        <div class="form-group">
                            <label for="booking_id" class="form-label">Select Booking <span class="required">*</span></label>
                            <select class="form-control @error('booking_id') is-invalid @enderror" 
                                    id="booking_id" 
                                    name="booking_id" 
                                    required>
                                <option value="">Choose a booking to pay for...</option>
                                @foreach($bookingsWithoutPayments as $bookingOption)
                                    <option
                                        value="{{ $bookingOption->id }}"
                                        {{ old('booking_id') == $bookingOption->id ? 'selected' : '' }}
                                        data-amount="{{ $bookingOption->schedule->course->price }}"
                                    >
                                        {{ $bookingOption->booking_code }} -
                                        {{ $bookingOption->schedule->course->name }}
                                        ({{ $bookingOption->schedule->start_datetime->format('M j, Y') }})
                                        - Rp.{{ number_format($bookingOption->schedule->course->price, 2) }}
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
                        <label for="amount" class="form-label">Payment Amount <span class="required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Rp.</span>
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
                        <small class="form-text">Amount must match the course price exactly</small>
                    </div>
                    
                    <!-- Payment Method -->
                    <div class="form-group">
                        <label for="payment_method" class="form-label">Payment Method <span class="required">*</span></label>
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
                        <label for="transaction_reference" class="form-label">Transaction Reference (Optional)</label>
                        <input type="text" 
                                class="form-control @error('transaction_reference') is-invalid @enderror" 
                                id="transaction_reference" 
                                name="transaction_reference" 
                                value="{{ old('transaction_reference') }}" 
                                placeholder="Enter transaction ID or reference number">
                        @error('transaction_reference')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Reference number from your bank or payment provider</small>
                    </div>
                    
                    <!-- Payment Proof Upload -->
                    <div class="form-group">
                        <label for="proof_file" class="form-label">Payment Proof <span class="required">*</span></label>
                        <input type="file" 
                                class="form-control-file @error('proof_file') is-invalid @enderror" 
                                id="proof_file" 
                                name="proof_file" 
                                accept=".jpg,.jpeg,.png,.pdf" 
                                required>
                        @error('proof_file')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">
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
                                <span class="required">*</span>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="form-group">
                        <button type="submit" class="modern-btn btn-success-modern">
                            <i class="fa fa-upload"></i> Submit Payment
                        </button>
                        <a href="{{ route('student.payments.index') }}" class="modern-btn btn-outline-modern">
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
        <div class="sidebar-card">
            <div class="sidebar-header">
                <h6 class="sidebar-title">
                    <i class="fa fa-info-circle"></i>
                    Payment Instructions
                </h6>
            </div>
            <div class="sidebar-body">
                <div class="alert-info">
                    <i class="fa fa-info-circle"></i>
                    <div>
                        <strong>Important:</strong>
                        <ul>
                            <li>Make sure the payment amount matches exactly</li>
                            <li>Upload a clear screenshot or photo of your receipt</li>
                            <li>Include transaction reference for faster processing</li>
                            <li>Payment verification may take up to 48 hours</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Bank Details -->
        <div class="sidebar-card">
            <div class="sidebar-header">
                <h6 class="sidebar-title">
                    <i class="fa fa-bank"></i>
                    Bank Transfer Details
                </h6>
            </div>
            <div class="sidebar-body">
                <div class="bank-details">
                    <p><strong>Bank Name:</strong> Course Booking Bank</p>
                    <p><strong>Account Name:</strong> Xperium Academy</p>
                    <p><strong>Account Number:</strong> 1234567890</p>
                    <p><strong>Routing Number:</strong> 987654321</p>
                    <p><strong>SWIFT Code:</strong> CBSBANK</p>
                    <small style="color: var(--text-muted);">
                        Please include your booking code in the transfer description
                    </small>
                </div>
            </div>
        </div>
        
        <!-- Help -->
        <div class="sidebar-card">
            <div class="sidebar-header">
                <h6 class="sidebar-title">
                    <i class="fa fa-question-circle"></i>
                    Need Help?
                </h6>
            </div>
            <div class="sidebar-body">
                <p class="help-info">
                    Having trouble with your payment? Contact our support team.
                </p>
                <div class="contact-details">
                    <strong>Email:</strong> codevwithali@coursebooking.com<br>
                    <strong>Phone:</strong> (555) 123-4567
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Terms Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-file-text-o"></i>
                    Payment Terms & Conditions
                </h5>
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
                <button type="button" class="modern-btn btn-success-modern" data-dismiss="modal">
                    <i class="fa fa-check"></i>
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