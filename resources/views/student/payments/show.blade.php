@extends('layouts.app')

@section('title', 'Payment Details - ' . $payment->booking->booking_code)

@section('content')
    <style>
        /* Payment Show Styles */
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

        .breadcrumb-item+.breadcrumb-item::before {
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

        /* Cards */
        .details-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .details-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card-header-modern {
            background: var(--secondary-bg);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title-modern {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body-modern {
            padding: 2rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-badge.verified {
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-badge.pending {
            background: rgba(251, 191, 36, 0.15);
            color: var(--warning);
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .status-badge.rejected {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-badge.default {
            background: var(--secondary-bg);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        .status-badge.approved {
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        /* Alert Styles */
        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-modern i {
            font-size: 1.25rem;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .alert-success-modern {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: var(--success);
        }

        .alert-warning-modern {
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.3);
            color: var(--warning);
        }

        .alert-danger-modern {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: var(--error);
        }

        .alert-content {
            flex: 1;
        }

        .alert-content strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Information Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .info-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .info-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .info-value {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .info-value.highlight {
            color: var(--success);
            font-weight: 600;
            font-size: 1rem;
        }

        .info-value.amount {
            color: var(--accent);
            font-weight: 700;
            font-size: 1.25rem;
        }

        /* Payment Proof */
        .proof-image {
            width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .proof-placeholder {
            text-align: center;
            padding: 3rem 2rem;
            background: var(--secondary-bg);
            border-radius: 12px;
            border: 2px dashed var(--border-color);
        }

        .proof-placeholder i {
            font-size: 4rem;
            margin-bottom: 1rem;
        }

        .proof-placeholder.pdf {
            color: var(--error);
        }

        .proof-placeholder.file {
            color: var(--text-muted);
        }

        /* Course Image */
        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .course-placeholder {
            width: 100%;
            height: 200px;
            background: var(--secondary-bg);
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .course-placeholder i {
            font-size: 3rem;
            color: var(--text-muted);
        }

        .course-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .course-category {
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        /* Notes */
        .notes-section {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .notes-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notes-content {
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 0;
        }

        .admin-notes {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .admin-notes .notes-title {
            color: var(--info);
        }

        .rejection-reason {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .rejection-reason .notes-title {
            color: var(--error);
        }

        /* Action Buttons */
        .modern-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom: 0.75rem;
        }

        .btn-outline-primary-modern {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
        }

        .btn-outline-primary-modern:hover {
            background: var(--accent);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-outline-info-modern {
            background: transparent;
            color: var(--info);
            border: 2px solid var(--info);
        }

        .btn-outline-info-modern:hover {
            background: var(--info);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
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
        }

        .btn-outline-secondary-modern {
            background: transparent;
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
        }

        .btn-outline-secondary-modern:hover {
            background: var(--hover);
            border-color: var(--hover);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-primary-modern {
            background: var(--accent);
            color: var(--primary-bg);
        }

        .btn-primary-modern:hover {
            background: var(--text-secondary);
            color: var(--primary-bg);
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
            transition: all 0.3s ease;
        }

        .sidebar-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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

        .contact-info {
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

        /* Timeline */
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

        .timeline-marker.bg-success {
            background: var(--success);
        }

        .timeline-marker.bg-danger {
            background: var(--error);
        }

        .timeline-marker.bg-warning {
            background: var(--warning);
        }

        .timeline-item:not(:last-child)::before {
            content: '';
            position: absolute;
            left: -30px;
            top: 17px;
            width: 2px;
            height: calc(100% + 8px);
            background-color: var(--border-color);
        }

        .timeline-title {
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 5px;
            color: var(--text-primary);
        }

        .timeline-text {
            font-size: 12px;
            color: var(--text-secondary);
            margin-bottom: 0;
        }

        .timeline-text small {
            color: var(--text-muted);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .card-body-modern {
                padding: 1.5rem;
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
                    <li class="breadcrumb-item active">Payment Details</li>
                </ol>
            </nav>
            <div class="page-header">
                <h2 class="page-title">Payment Details</h2>
                <p class="page-subtitle">View your payment information and status</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Payment Information -->
        <div class="col-md-8">
            <!-- Payment Status Card -->
            <div class="details-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fa fa-credit-card"></i>
                        Payment Status
                    </h5>
                    @if($payment->status === 'verified')
                        <span class="status-badge verified">{{ ucfirst($payment->status) }}</span>
                    @elseif($payment->status === 'pending')
                        <span class="status-badge pending">{{ ucfirst($payment->status) }}</span>
                    @elseif($payment->status === 'rejected')
                        <span class="status-badge rejected">{{ ucfirst($payment->status) }}</span>
                    @else
                        <span class="status-badge default">{{ ucfirst($payment->status) }}</span>
                    @endif
                </div>
                <div class="card-body-modern">
                    @if($payment->status === 'verified')
                        <div class="alert-modern alert-success-modern">
                            <i class="fa fa-check-circle"></i>
                            <div class="alert-content">
                                <strong>Payment Verified!</strong> Your payment has been confirmed and your booking is approved.
                            </div>
                        </div>
                    @elseif($payment->status === 'pending')
                        <div class="alert-modern alert-warning-modern">
                            <i class="fa fa-clock-o"></i>
                            <div class="alert-content">
                                <strong>Payment Under Review:</strong> Your payment is being verified by our admin team. This
                                process may take up to 48 hours.
                            </div>
                        </div>
                    @elseif($payment->status === 'rejected')
                        <div class="alert-modern alert-danger-modern">
                            <i class="fa fa-times-circle"></i>
                            <div class="alert-content">
                                <strong>Payment Rejected:</strong> Your payment has been rejected. Please see the reason below
                                and submit a new payment.
                            </div>
                        </div>
                    @endif

                    <div class="info-grid">
                        <div class="info-section">
                            <h6 class="info-section-title">Payment Information</h6>
                            <div class="info-item">
                                <span class="info-label">Amount:</span>
                                <span class="info-value amount">Rp.{{ number_format($payment->amount, 2) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Payment Method:</span>
                                <span
                                    class="info-value">{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Payment Date:</span>
                                <span class="info-value">{{ $payment->paid_at->format('M j, Y g:i A') }}</span>
                            </div>
                            @if($payment->transaction_reference)
                                <div class="info-item">
                                    <span class="info-label">Transaction Reference:</span>
                                    <span class="info-value">{{ $payment->transaction_reference }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="info-section">
                            <h6 class="info-section-title">Verification Details</h6>
                            @if($payment->verified_at)
                                <div class="info-item">
                                    <span class="info-label">Verified Date:</span>
                                    <span class="info-value">{{ $payment->verified_at->format('M j, Y g:i A') }}</span>
                                </div>
                            @endif
                            @if($payment->verifiedBy)
                                <div class="info-item">
                                    <span class="info-label">Verified By:</span>
                                    <span class="info-value">{{ $payment->verifiedBy->name }}</span>
                                </div>
                            @endif
                            @if($payment->status === 'rejected' && $payment->rejection_reason)
                                <div class="rejection-reason">
                                    <h6 class="notes-title">
                                        <i class="fa fa-exclamation-triangle"></i>
                                        Rejection Reason
                                    </h6>
                                    <p class="notes-content">{{ $payment->rejection_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($payment->admin_notes)
                        <div class="admin-notes">
                            <h6 class="notes-title">
                                <i class="fa fa-user-circle-o"></i>
                                Admin Notes
                            </h6>
                            <p class="notes-content">{{ $payment->admin_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment Proof -->
            @if($payment->proof_path)
                <div class="details-card">
                    <div class="card-header-modern">
                        <h5 class="card-title-modern">
                            <i class="fa fa-file-image-o"></i>
                            Payment Proof
                        </h5>
                        <a href="{{ route('student.payments.download-proof', $payment) }}"
                            class="modern-btn btn-outline-primary-modern" style="width: auto; margin: 0; padding: 0.5rem 1rem;">
                            <i class="fa fa-download"></i> Download
                        </a>
                    </div>
                    <div class="card-body-modern">
                        @php
                            $fileExtension = pathinfo($payment->proof_path, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png']))
                            <div style="text-align: center;">
                                <img src="{{ asset('storage/' . $payment->proof_path) }}" class="proof-image" alt="Payment Proof">
                            </div>
                        @elseif(strtolower($fileExtension) === 'pdf')
                            <div class="proof-placeholder pdf">
                                <i class="fa fa-file-pdf-o"></i>
                                <p style="color: var(--text-primary); margin: 0; font-weight: 600;">PDF Payment Proof</p>
                                <a href="{{ route('student.payments.download-proof', $payment) }}"
                                    class="modern-btn btn-primary-modern" style="width: auto; margin-top: 1rem;">
                                    <i class="fa fa-download"></i> Download PDF
                                </a>
                            </div>
                        @else
                            <div class="proof-placeholder file">
                                <i class="fa fa-file"></i>
                                <p style="color: var(--text-primary); margin: 0; font-weight: 600;">Payment Proof File</p>
                                <a href="{{ route('student.payments.download-proof', $payment) }}"
                                    class="modern-btn btn-primary-modern" style="width: auto; margin-top: 1rem;">
                                    <i class="fa fa-download"></i> Download File
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Related Booking -->
            <div class="details-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fa fa-calendar"></i>
                        Related Booking
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="info-grid">
                        <div class="info-section">
                            @if($payment->booking->schedule->course->image_path)
                                <img src="{{ asset('storage/' . $payment->booking->schedule->course->image_path) }}"
                                    class="course-image" alt="{{ $payment->booking->schedule->course->name }}">
                            @else
                                <div class="course-placeholder">
                                    <i class="fa fa-book"></i>
                                </div>
                            @endif
                        </div>
                        <div class="info-section">
                            <h4 class="course-title">{{ $payment->booking->schedule->course->name }}</h4>
                            <p class="course-category">{{ $payment->booking->schedule->course->category->name }}</p>

                            <div class="info-grid">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">Booking Code:</span>
                                        <span class="info-value">{{ $payment->booking->booking_code }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Instructor:</span>
                                        <span
                                            class="info-value">{{ $payment->booking->schedule->course->instructor_name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Session Date:</span>
                                        <span
                                            class="info-value">{{ $payment->booking->schedule->start_datetime->format('M j, Y') }}</span>
                                    </div>
                                </div>
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">Session Time:</span>
                                        <span
                                            class="info-value">{{ $payment->booking->schedule->start_datetime->format('g:i A') }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Booking Status:</span>
                                        @if($payment->booking->status === 'approved')
                                            <span class="status-badge approved">{{ ucfirst($payment->booking->status) }}</span>
                                        @elseif($payment->booking->status === 'pending')
                                            <span class="status-badge pending">{{ ucfirst($payment->booking->status) }}</span>
                                        @else
                                            <span class="status-badge default">{{ ucfirst($payment->booking->status) }}</span>
                                        @endif
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Booked:</span>
                                        <span class="info-value">{{ $payment->booking->booked_at->format('M j, Y') }}</span>
                                    </div>
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
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h6 class="sidebar-title">
                        <i class="fa fa-bolt"></i>
                        Actions
                    </h6>
                </div>
                <div class="sidebar-body">
                    @if($payment->proof_path)
                        <a href="{{ route('student.payments.download-proof', $payment) }}"
                            class="modern-btn btn-outline-primary-modern">
                            <i class="fa fa-download"></i> Download Proof
                        </a>
                    @endif

                    <a href="{{ route('student.bookings.show', $payment->booking) }}"
                        class="modern-btn btn-outline-info-modern">
                        <i class="fa fa-calendar"></i> View Booking
                    </a>

                    @if($payment->status === 'rejected')
                        <a href="{{ route('student.payments.create', ['booking_id' => $payment->booking->id]) }}"
                            class="modern-btn btn-success-modern">
                            <i class="fa fa-plus"></i> Submit New Payment
                        </a>
                    @endif

                    <a href="{{ route('student.payments.index') }}" class="modern-btn btn-outline-secondary-modern">
                        <i class="fa fa-arrow-left"></i> Back to Payments
                    </a>
                </div>
            </div>

            <!-- Payment Timeline -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h6 class="sidebar-title">
                        <i class="fa fa-history"></i>
                        Payment Timeline
                    </h6>
                </div>
                <div class="sidebar-body">
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
                                        <small class="timeline-text">by {{ $payment->verifiedBy->name }}</small>
                                    @endif
                                </div>
                            </div>
                        @elseif($payment->status === 'rejected')
                            <div class="timeline-item">
                                <div class="timeline-marker bg-danger"></div>
                                <div class="timeline-content">
                                    <h6 class="timeline-title">Payment Rejected</h6>
                                    <p class="timeline-text">
                                        {{ $payment->verified_at ? $payment->verified_at->format('M j, Y g:i A') : 'Recently' }}
                                    </p>
                                    @if($payment->verifiedBy)
                                        <small class="timeline-text">by {{ $payment->verifiedBy->name }}</small>
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
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h6 class="sidebar-title">
                        <i class="fa fa-question-circle"></i>
                        Need Help?
                    </h6>
                </div>
                <div class="sidebar-body">
                    <p class="contact-info">
                        Having issues with your payment? Contact our support team.
                    </p>
                    <div class="contact-details">
                        <strong>Email:</strong> payments@coursebooking.com<br>
                        <strong>Phone:</strong> (555) 123-4567
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection