@extends('layouts.app')

@section('title', 'Manage Bookings - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Bookings</h2>
            <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Booking
            </a>
        </div>
    </div>
</div>

<!-- Bookings Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Student</th>
                                    <th>Course & Schedule</th>
                                    <th>Booking Date</th>
                                    <th>Status</th>
                                    <th>Payment</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $booking)
                                    <tr>
                                        <td>
                                            <strong>{{ $booking->booking_code }}</strong>
                                        </td>
                                        <td>
                                            <strong>{{ $booking->user->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $booking->user->email }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $booking->schedule->course->name }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $booking->schedule->start_datetime ? $booking->schedule->start_datetime->format('M d, Y H:i') : 'N/A' }}
                                            </small>
                                        </td>
                                        <td>
                                            {{ $booking->booked_at ? $booking->booked_at->format('M d, Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            @if($booking->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($booking->status == 'approved')
                                                <span class="badge badge-success">Approved</span>
                                            @elseif($booking->status == 'rejected')
                                                <span class="badge badge-danger">Rejected</span>
                                            @elseif($booking->status == 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @elseif($booking->status == 'completed')
                                                <span class="badge badge-primary">Completed</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($booking->payment)
                                                @if($booking->payment->status == 'pending')
                                                    <span class="badge badge-warning">Pending</span>
                                                @elseif($booking->payment->status == 'verified')
                                                    <span class="badge badge-success">Verified</span>
                                                @elseif($booking->payment->status == 'rejected')
                                                    <span class="badge badge-danger">Rejected</span>
                                                @endif
                                            @else
                                                <span class="badge badge-secondary">No Payment</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                @if(!$booking->payment)
                                                    <a href="{{ route('admin.payments.create', ['booking_id' => $booking->id]) }}" class="btn btn-sm btn-success" title="Create Payment">
                                                        <i class="fa fa-credit-card"></i>
                                                    </a>
                                                @endif
                                                @if($booking->status == 'pending')
                                                    <form method="POST" action="{{ route('admin.bookings.approve', $booking) }}" style="display: inline;">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-sm btn-success" title="Approve">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    </form>
                                                @endif
                                                <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this booking?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $bookings->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fa fa-calendar-times-o fa-3x text-muted"></i>
                        <h4 class="mt-3">No Bookings Found</h4>
                        <p class="text-muted">No bookings match your search criteria.</p>
                        <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary">Create First Booking</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection