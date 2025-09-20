@extends('layouts.admin-layout')

@section('title', 'Edit Payment - Admin')

@section('content')
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Payment</h4>
                </div>
                <div class="card-body">
                    <!-- Booking Information -->
                    <div class="alert alert-info">
                        <h6><i class="fa fa-info-circle"></i> Booking Information</h6>
                        <p class="mb-1"><strong>Booking Code:</strong> {{ $payment->booking->booking_code }}</p>
                        <p class="mb-1"><strong>Student:</strong> {{ $payment->booking->user->name }}
                            ({{ $payment->booking->user->email }})</p>
                        <p class="mb-0"><strong>Course:</strong> {{ $payment->booking->schedule->course->name }}</p>
                    </div>

                    <form method="POST" action="{{ route('admin.payments.update', $payment) }}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="amount">Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="number" step="0.01" min="0" id="amount" name="amount"
                                    class="form-control @error('amount') is-invalid @enderror"
                                    value="{{ old('amount', $payment->amount) }}" required>
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                            <select id="payment_method" name="payment_method"
                                class="form-control @error('payment_method') is-invalid @enderror" required>
                                <option value="">Select Payment Method</option>
                                <option value="bank_transfer" {{ old('payment_method', $payment->payment_method) == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                <option value="cash" {{ old('payment_method', $payment->payment_method) == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="other" {{ old('payment_method', $payment->payment_method) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="transaction_reference">Transaction Reference</label>
                            <input type="text" id="transaction_reference" name="transaction_reference"
                                class="form-control @error('transaction_reference') is-invalid @enderror"
                                value="{{ old('transaction_reference', $payment->transaction_reference) }}"
                                placeholder="Enter transaction reference (optional)">
                            @error('transaction_reference')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Leave empty to auto-generate</small>
                        </div>

                        <div class="form-group">
                            <label for="status">Payment Status <span class="text-danger">*</span></label>
                            <select id="status" name="status" class="form-control @error('status') is-invalid @enderror"
                                required>
                                <option value="pending" {{ old('status', $payment->status) == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="verified" {{ old('status', $payment->status) == 'verified' ? 'selected' : '' }}>Verified</option>
                                <option value="rejected" {{ old('status', $payment->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group" id="rejection_reason_group" style="display: none;">
                            <label for="rejection_reason">Rejection Reason <span class="text-danger">*</span></label>
                            <textarea id="rejection_reason" name="rejection_reason"
                                class="form-control @error('rejection_reason') is-invalid @enderror" rows="3"
                                placeholder="Please provide a reason for rejecting this payment...">{{ old('rejection_reason', $payment->rejection_reason) }}</textarea>
                            @error('rejection_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="admin_notes">Admin Notes</label>
                            <textarea id="admin_notes" name="admin_notes"
                                class="form-control @error('admin_notes') is-invalid @enderror" rows="3"
                                placeholder="Optional administrative notes...">{{ old('admin_notes', $payment->admin_notes) }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-save"></i> Update Payment
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary btn-block">
                                        <i class="fa fa-times"></i> Cancel
                                    </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status');
            const rejectionReasonGroup = document.getElementById('rejection_reason_group');
            const rejectionReasonInput = document.getElementById('rejection_reason');

            function toggleRejectionReason() {
                if (statusSelect.value === 'rejected') {
                    rejectionReasonGroup.style.display = 'block';
                    rejectionReasonInput.required = true;
                } else {
                    rejectionReasonGroup.style.display = 'none';
                    rejectionReasonInput.required = false;
                }
            }

            statusSelect.addEventListener('change', toggleRejectionReason);

            // Initial check
            toggleRejectionReason();
        });
    </script>
@endsection