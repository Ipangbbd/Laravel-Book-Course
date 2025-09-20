@extends('layouts.app')

@section('title', 'My Payments - Xperium Academy')

@section('content')
    <style>
        /* Payment Index Styles */
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

        /* Filter Card */
        .filter-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .filter-header {
            background: var(--secondary-bg);
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-body {
            padding: 2rem;
        }

        /* Form Styles */
        .form-label {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.55rem 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: var(--secondary-bg);
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control option {
            background: var(--secondary-bg);
            color: var(--text-primary);
        }

        /* Buttons */
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

        /* Action Bar */
        .action-bar {
            margin-bottom: 2rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        /* Payment Cards */
        .payments-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .payment-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .payment-card:hover {
            transform: translateY(-4px);
            border-color: var(--hover);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .payment-header {
            background: var(--secondary-bg);
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .payment-code {
            font-weight: 600;
            color: var(--text-primary);
            font-family: monospace;
            font-size: 0.875rem;
        }

        .payment-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .course-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .course-category {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .payment-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
            flex: 1;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .detail-value {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .detail-value.primary {
            color: var(--text-primary);
            font-weight: 600;
        }

        .detail-value.amount {
            color: var(--accent);
            font-weight: 700;
            font-size: 1.25rem;
        }

        .payment-method-badge {
            background: var(--secondary-bg);
            color: var(--text-secondary);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: capitalize;
            border: 1px solid var(--border-color);
        }

        .payment-footer {
            padding: 1rem 1.5rem;
            background: var(--secondary-bg);
            border-top: 1px solid var(--border-color);
            display: flex;
            gap: 0.5rem;
        }

        .btn-sm-modern {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
            flex: 1;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
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

        /* Notes */
        .rejection-reason {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            border-radius: 8px;
            padding: 0.75rem;
            margin-top: 0.5rem;
        }

        .admin-notes {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 0.75rem;
            margin-top: 0.5rem;
        }

        /* Empty State */
        .empty-state {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .empty-description {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Pagination */
        .pagination {
            --bs-pagination-bg: var(--card-bg);
            --bs-pagination-border-color: var(--border-color);
            --bs-pagination-color: var(--text-secondary);
            --bs-pagination-hover-bg: var(--hover);
            --bs-pagination-hover-border-color: var(--hover);
            --bs-pagination-hover-color: var(--text-primary);
            --bs-pagination-active-bg: var(--accent);
            --bs-pagination-active-border-color: var(--accent);
            --bs-pagination-active-color: var(--primary-bg);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .filter-body {
                padding: 1.5rem;
            }

            .payments-grid {
                grid-template-columns: 1fr;
            }

            .action-bar {
                flex-direction: column;
            }
        }
    </style>
    <div class="row mb-4">
        <div class="col-12">
            <div class="page-header">
                <h2 class="page-title">My Payments</h2>
                <p class="page-subtitle">Track your course payments and upload payment proofs</p>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="filter-card">
                <div class="filter-header">
                    <h5 class="filter-title">
                        <i class="fa fa-filter"></i>
                        Filter Payments
                    </h5>
                </div>
                <div class="filter-body">
                    <form method="GET" action="{{ route('student.payments.index') }}">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="status" class="form-label">Payment Status</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="">All Status</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Verified
                                    </option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="transaction_reference" class="form-label">Transaction Reference</label>
                                <input type="text" class="form-control" id="transaction_reference"
                                    name="transaction_reference" value="{{ request('transaction_reference') }}"
                                    placeholder="Search by reference">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="booking_code" class="form-label">Booking Code</label>
                                <input type="text" class="form-control" id="booking_code" name="booking_code"
                                    value="{{ request('booking_code') }}" placeholder="Search by booking code">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <div style="display: flex; gap: 0.5rem;">
                                    <button type="submit" class="modern-btn btn-primary-modern">
                                        <i class="fa fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('student.payments.index') }}" class="modern-btn btn-outline-modern">
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
    <div class="action-bar">
        <a href="{{ route('student.payments.create') }}" class="modern-btn btn-success-modern">
            <i class="fa fa-plus"></i> Submit New Payment
        </a>
        <a href="{{ route('student.bookings.index') }}" class="modern-btn btn-outline-modern">
            <i class="fa fa-calendar"></i> View Bookings
        </a>
    </div>

    @if($payments->count() > 0)
        <!-- Payments List -->
        <div class="payments-grid">
            @foreach($payments as $payment)
                <div class="payment-card">
                    <div class="payment-header">
                        <strong class="payment-code">{{ $payment->booking->booking_code }}</strong>
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

                    <div class="payment-body">
                        <h6 class="course-title">{{ $payment->booking->schedule->course->name }}</h6>
                        <p class="course-category">{{ $payment->booking->schedule->course->category->name }}</p>

                        <div class="payment-details">
                            <div class="detail-item">
                                <span class="detail-label">Amount</span>
                                <span class="detail-value amount">Rp.{{ number_format($payment->amount, 2) }}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Payment Method</span>
                                <span
                                    class="payment-method-badge">{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Paid Date</span>
                                <span class="detail-value">{{ $payment->paid_at->format('M j, Y') }}</span>
                            </div>

                            @if($payment->transaction_reference)
                                <div class="detail-item">
                                    <span class="detail-label">Reference</span>
                                    <span class="detail-value">{{ $payment->transaction_reference }}</span>
                                </div>
                            @endif

                            @if($payment->verified_at)
                                <div class="detail-item">
                                    <span class="detail-label">Verified</span>
                                    <span class="detail-value">{{ $payment->verified_at->format('M j, Y') }}</span>
                                </div>
                            @endif

                            @if($payment->status === 'rejected' && $payment->rejection_reason)
                                <div class="detail-item">
                                    <span class="detail-label">Rejection Reason</span>
                                    <div class="rejection-reason">
                                        <span
                                            style="color: var(--error); font-size: 0.875rem;">{{ Str::limit($payment->rejection_reason, 80) }}</span>
                                    </div>
                                </div>
                            @endif

                            @if($payment->admin_notes)
                                <div class="detail-item">
                                    <span class="detail-label">Admin Notes</span>
                                    <div class="admin-notes">
                                        <span
                                            style="color: var(--text-secondary); font-size: 0.875rem;">{{ Str::limit($payment->admin_notes, 80) }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="payment-footer">
                        <a href="{{ route('student.payments.show', $payment) }}"
                            class="modern-btn btn-outline-modern btn-sm-modern">
                            <i class="fa fa-eye"></i> View
                        </a>

                        @if($payment->proof_path)
                            <a href="{{ route('student.payments.download-proof', $payment) }}"
                                class="modern-btn btn-outline-modern btn-sm-modern">
                                <i class="fa fa-download"></i> Proof
                            </a>
                        @endif

                        <a href="{{ route('student.bookings.show', $payment->booking) }}"
                            class="modern-btn btn-outline-modern btn-sm-modern">
                            <i class="fa fa-calendar"></i> Booking
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                {{ $payments->links() }}
            </div>
        </div>
    @else
        <!-- No Payments -->
        <div class="row">
            <div class="col-12">
                <div class="empty-state">
                    <i class="fa fa-credit-card empty-icon"></i>
                    <h5 class="empty-title">No Payments Found</h5>
                    @if(request()->hasAny(['status', 'transaction_reference', 'booking_code']))
                        <p class="empty-description">
                            No payments match your search criteria. Try adjusting your filters.
                        </p>
                        <a href="{{ route('student.payments.index') }}" class="modern-btn btn-primary-modern">
                            Clear Filters
                        </a>
                    @else
                        <p class="empty-description">
                            You haven't made any payments yet. Start by booking a course.
                        </p>
                        <a href="{{ route('student.courses.index') }}" class="modern-btn btn-primary-modern">
                            Browse Courses
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endif
@endsection