@extends('layouts.app')

@section('title', 'Manage Payments - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Payments</h2>
            <a href="{{ route('admin.payments.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Payment
            </a>
        </div>
    </div>
</div>

<!-- Payments Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking</th>
                                    <th>Student</th>
                                    <th>Course</th>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Payment Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>
                                            <strong>{{ $payment->booking->booking_code }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $payment->booking->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $payment->booking->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $payment->booking->schedule->course->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $payment->booking->schedule->start_datetime ? $payment->booking->schedule->start_datetime->format('M d, Y') : 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            <strong>${{ number_format($payment->amount, 2) }}</strong>
                                        </td>
                                        <td>
                                            {{ ucfirst(str_replace('_', ' ', $payment->payment_method ?? 'N/A')) }}
                                        </td>
                                        <td>
                                            {{ $payment->paid_at ? $payment->paid_at->format('M d, Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            @if($payment->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($payment->status == 'verified')
                                                <span class="badge badge-success">Verified</span>
                                            @elseif($payment->status == 'rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.payments.show', $payment) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if($payment->status == 'pending')
                                                    <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" title="Verify">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-sm btn-danger" title="Reject" 
                                                            data-toggle="modal" data-target="#rejectModal{{ $payment->id }}">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-sm btn-danger" title="Delete" 
                                                        data-toggle="modal" data-target="#deleteModal{{ $payment->id }}">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $payments->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fa fa-credit-card fa-3x text-muted"></i>
                        <h4 class="mt-3">No Payments Found</h4>
                        <p class="text-muted">No payments match your search criteria.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Reject Modals -->
@foreach($payments as $payment)
    @if($payment->status == 'pending')
        <div class="modal fade" id="rejectModal{{ $payment->id }}" tabindex="-1" role="dialog">
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
                            <p><strong>Payment:</strong> ${{ number_format($payment->amount, 2) }}</p>
                            <p><strong>Student:</strong> {{ $payment->booking->user->name }}</p>
                            <div class="form-group">
                                <label for="rejection_reason">Rejection Reason <span class="text-danger">*</span></label>
                                <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="Please provide a reason for rejecting this payment..."></textarea>
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
@endforeach

<!-- Delete Confirmation Modals -->
@foreach($payments as $payment)
    @if($payment->status !== 'verified')
        <div class="modal fade" id="deleteModal{{ $payment->id }}" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}">
                        @csrf
                        @method('DELETE')
                        <div class="modal-header">
                            <h5 class="modal-title">Delete Payment</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p><i class="fa fa-exclamation-triangle text-warning"></i> <strong>Are you sure you want to delete this payment?</strong></p>
                            <p><strong>Payment Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
                            <p><strong>Student:</strong> {{ $payment->booking->user->name }}</p>
                            <p><strong>Booking:</strong> {{ $payment->booking->booking_code }}</p>
                            <div class="alert alert-warning">
                                <small><i class="fa fa-info-circle"></i> This action cannot be undone. The associated booking status may be reset to pending.</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-danger">Delete Payment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach
@endsection