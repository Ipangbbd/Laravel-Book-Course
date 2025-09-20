@extends('layouts.admin-layout')

@section('title', 'Add New Payment - Admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Add New Payment</h2>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.payments.store') }}">
                        @csrf

                        <div class="form-group">
                            <label for="booking_id">Booking <span class="text-danger">*</span></label>
                            <select name="booking_id" id="booking_id"
                                class="form-control @error('booking_id') is-invalid @enderror" required>
                                <option value="">Select a booking...</option>
                                @foreach($bookingsWithoutPayments as $bookingOption)
                                    <option value="{{ $bookingOption->id }}" {{ (old('booking_id') ?? $booking?->id) == $bookingOption->id ? 'selected' : '' }}>
                                        {{ $bookingOption->booking_code }} - {{ $bookingOption->user->name }}
                                        ({{ $bookingOption->schedule->course->name }})
                                        - Rp.{{ number_format($bookingOption->schedule->course->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('booking_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            @if($bookingsWithoutPayments->isEmpty())
                                <small class="text-muted">No bookings available for payment. All bookings either have payments
                                    or are cancelled.</small>
                            @endif
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                    <input type="number" name="amount" id="amount"
                                        class="form-control @error('amount') is-invalid @enderror"
                                        value="{{ old('amount') ?? ($booking ? $booking->schedule->course->price : '') }}"
                                        step="0.01" min="0" required>
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                    <select name="payment_method" id="payment_method"
                                        class="form-control @error('payment_method') is-invalid @enderror" required>
                                        <option value="">Select method...</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="credit_card" {{ old('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash
                                        </option>
                                        <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other
                                        </option>
                                    </select>
                                    @error('payment_method')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_reference">Transaction Reference</label>
                                    <input type="text" name="transaction_reference" id="transaction_reference"
                                        class="form-control @error('transaction_reference') is-invalid @enderror"
                                        value="{{ old('transaction_reference') }}" placeholder="e.g., TXN123456">
                                    @error('transaction_reference')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="">Select status...</option>
                                        <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="verified" {{ old('status') == 'verified' ? 'selected' : '' }}>Verified
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Verified payments will automatically approve the
                                        booking.</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="admin_notes">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes"
                                class="form-control @error('admin_notes') is-invalid @enderror" rows="3"
                                placeholder="Optional notes about this payment...">{{ old('admin_notes') }}</textarea>
                            @error('admin_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Create Payment
                            </button>
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto-update amount when booking changes
        document.addEventListener('DOMContentLoaded', function () {
            const bookingSelect = document.getElementById('booking_id');
            const amountInput = document.getElementById('amount');

            bookingSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    // Extract price from option text - this is a simple approach
                    const optionText = selectedOption.text;
                    const priceMatch = optionText.match(/\$([0-9,]+\.?[0-9]*)/);
                    if (priceMatch) {
                        const price = priceMatch[1].replace(',', '');
                        amountInput.value = price;
                    }
                }
            });
        });
    </script>
@endsection