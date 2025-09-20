@extends('layouts.admin-layout')

@section('title', $user->name . ' - User Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h2>User Details</h2>
                    <div>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                            <i class="fa fa-edit"></i> Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary ml-2">
                            <i class="fa fa-arrow-left"></i> Back to Users
                        </a>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <!-- User Profile Card -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">User Profile</h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 text-center">
                                        @if($user->avatar_path)
                                            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}"
                                                class="img-thumbnail rounded-circle mb-3"
                                                style="width: 120px; height: 120px; object-fit: cover;">
                                        @else
                                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                                style="width: 120px; height: 120px;">
                                                <i class="fa fa-user fa-3x text-muted"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-9">
                                        <h4>{{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="badge badge-info">You</span>
                                            @endif
                                        </h4>
                                        <p class="text-muted">{{ $user->email }}</p>

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <strong>Role:</strong>
                                                @if($user->role === 'admin')
                                                    <span class="badge badge-danger">Admin</span>
                                                @else
                                                    <span class="badge badge-primary">Student</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Status:</strong>
                                                @if($user->status === 'active')
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Joined:</strong><br>
                                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Member Since:</strong><br>
                                                {{ $user->created_at ? $user->created_at->diffForHumans() : 'N/A' }}
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Last Updated:</strong><br>
                                                {{ $user->updated_at ? $user->updated_at->format('M d, Y H:i') : 'N/A' }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- User Activity -->
                        @if($user->role === 'student')
                            <div class="card mt-4">
                                <div class="card-header">
                                    <h5 class="mb-0">Student Activity</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row text-center">
                                        <div class="col-md-4">
                                            <h4 class="text-primary">{{ $user->bookings->count() }}</h4>
                                            <small class="text-muted">Total Bookings</small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="text-success">{{ $user->verifiedPayments->count() }}</h4>
                                            <small class="text-muted">Verified Payments</small>
                                        </div>
                                        <div class="col-md-4">
                                            <h4 class="text-warning">{{ $user->bookings->where('status', 'active')->count() }}
                                            </h4>
                                            <small class="text-muted">Active Bookings</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Recent Bookings -->
                            @if($user->bookings->count() > 0)
                                <div class="card mt-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Recent Bookings</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Booking Code</th>
                                                        <th>Course</th>
                                                        <th>Status</th>
                                                        <th>Booking Date</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->bookings->take(5) as $booking)
                                                        <tr>
                                                            <td>{{ $booking->booking_code }}</td>
                                                            <td>{{ $booking->schedule->course->name ?? 'N/A' }}</td>
                                                            <td>
                                                                @if($booking->status === 'active')
                                                                    <span class="badge badge-success">Active</span>
                                                                @elseif($booking->status === 'cancelled')
                                                                    <span class="badge badge-danger">Cancelled</span>
                                                                @else
                                                                    <span class="badge badge-warning">{{ ucfirst($booking->status) }}</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $booking->created_at ? $booking->created_at->format('M d, Y') : 'N/A' }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="col-md-4">
                        <!-- Quick Actions -->
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Quick Actions</h5>
                            </div>
                            <div class="card-body">
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-block">
                                        <i class="fa fa-edit"></i> Edit User
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-block">
                                                <i class="fa fa-trash"></i> Delete User
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-danger btn-block" disabled
                                            title="Cannot delete your own account">
                                            <i class="fa fa-trash"></i> Delete User
                                        </button>
                                        <small class="text-muted">You cannot delete your own account</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Account Information -->
                        <div class="card mt-3">
                            <div class="card-header">
                                <h5 class="mb-0">Account Information</h5>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled">
                                    <li class="mb-2">
                                        <strong>User ID:</strong><br>
                                        <code>{{ $user->id }}</code>
                                    </li>
                                    <li class="mb-2">
                                        <strong>Email Verified:</strong><br>
                                        @if($user->email_verified_at)
                                            <span class="badge badge-success">Verified</span><br>
                                            <small
                                                class="text-muted">{{ $user->email_verified_at ? $user->email_verified_at->format('M d, Y') : 'N/A' }}</small>
                                        @else
                                            <span class="badge badge-warning">Not Verified</span>
                                        @endif
                                    </li>
                                    <li class="mb-2">
                                        <strong>Registration Date:</strong><br>
                                        {{ $user->created_at ? $user->created_at->format('M d, Y H:i') : 'N/A' }}
                                    </li>
                                    <li>
                                        <strong>Last Profile Update:</strong><br>
                                        {{ $user->updated_at ? $user->updated_at->format('M d, Y H:i') : 'N/A' }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection