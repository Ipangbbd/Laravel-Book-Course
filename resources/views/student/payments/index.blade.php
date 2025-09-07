@extends('layouts.app')

@section('title', 'My Payments - Course Booking System')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2>My Payments</h2>
            <p class="text-muted">Track your course payments and upload payment proofs</p>
        </div>
    </div>

    <!-- Filter Form -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Filter Payments</h5>
                </div>
                <div class="card-body">
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
                                <div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-search"></i> Filter
                                    </button>
                                    <a href="{{ route('student.payments.index') }}" class="btn btn-outline-secondary">
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
            <a href="{{ route('student.payments.create') }}" class="btn btn-success">
                <i class="fa fa-plus"></i> Submit New Payment
            </a>
            <a href="{{ route('student.bookings.index') }}" class="btn btn-outline-primary">
                <i class="fa fa-calendar"></i> View Bookings
            </a>
        </div>
    </div>

    @if($payments->count() > 0)
        <!-- Payments List -->
        <div class="row">
            @foreach($payments as $payment)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <strong>{{ $payment->booking->booking_code }}</strong>
                                @if($payment->status === 'verified')
                                    <span class="badge badge-success">{{ ucfirst($payment->status) }}</span>
                                @elseif($payment->status === 'pending')
                                    <span class="badge badge-warning">{{ ucfirst($payment->status) }}</span>
                                @elseif($payment->status === 'rejected')
                                    <span class="badge badge-danger">{{ ucfirst($payment->status) }}</span>
                                @else
                                    <span class="badge badge-secondary">{{ ucfirst($payment->status) }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="card-body">
                            <h6 class="card-title">{{ $payment->booking->schedule->course->name }}</h6>
                            <p class="card-text text-muted small">
                                {{ $payment->booking->schedule->course->category->name }}
                            </p>

                            <div class="mb-2">
                                <small class="text-muted">Amount:</small><br>
                                <h5 class="text-primary mb-0">${{ number_format($payment->amount, 2) }}</h5>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Payment Method:</small>
                                <span
                                    class="badge badge-light">{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</span>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted">Paid Date:</small>
                                <span>{{ $payment->paid_at->format('M j, Y') }}</span>
                            </div>

                            @if($payment->transaction_reference)
                                <div class="mb-2">
                                    <small class="text-muted">Reference:</small>
                                    <span class="small">{{ $payment->transaction_reference }}</span>
                                </div>
                            @endif

                            @if($payment->verified_at)
                                <div class="mb-2">
                                    <small class="text-muted">Verified:</small>
                                    <span>{{ $payment->verified_at->format('M j, Y') }}</span>
                                </div>
                            @endif

                            @if($payment->status === 'rejected' && $payment->rejection_reason)
                                <div class="mb-2">
                                    <small class="text-danger">Rejection Reason:</small>
                                    <p class="small text-danger">{{ Str::limit($payment->rejection_reason, 50) }}</p>
                                </div>
                            @endif

                            @if($payment->admin_notes)
                                <div class="mb-2">
                                    <small class="text-muted">Admin Notes:</small>
                                    <p class="small">{{ Str::limit($payment->admin_notes, 50) }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="card-footer">
                            <div class="btn-group btn-group-sm w-100" role="group">
                                <a href="{{ route('student.payments.show', $payment) }}" class="btn btn-outline-primary">
                                    <i class="fa fa-eye"></i> View
                                </a>

                                @if($payment->proof_path)
                                    <a href="{{ route('student.payments.download-proof', $payment) }}" class="btn btn-outline-info">
                                        <i class="fa fa-download"></i> Proof
                                    </a>
                                @endif

                                <a href="{{ route('student.bookings.show', $payment->booking) }}" class="btn btn-outline-secondary">
                                    <i class="fa fa-calendar"></i> Booking
                                </a>
                            </div>
                        </div>
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
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fa fa-credit-card fa-3x text-muted mb-3"></i>
                        <h5>No Payments Found</h5>
                        @if(request()->hasAny(['status', 'transaction_reference', 'booking_code']))
                            <p class="text-muted">
                                No payments match your search criteria. Try adjusting your filters.
                            </p>
                            <a href="{{ route('student.payments.index') }}" class="btn btn-primary">
                                Clear Filters
                            </a>
                        @else
                            <p class="text-muted">
                                You haven't made any payments yet. Start by booking a course.
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