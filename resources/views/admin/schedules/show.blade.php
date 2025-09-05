@extends('layouts.app')

@section('title', 'Schedule Details - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Schedule Details</h2>
            <div>
                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-warning">
                    <i class="fa fa-edit"></i> Edit Schedule
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Schedules
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Information -->
<div class="row mb-4">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Schedule Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Schedule ID:</strong></div>
                    <div class="col-md-9">{{ $schedule->id }}</div>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-3"><strong>Course:</strong></div>
                    <div class="col-md-9">
                        <strong>{{ $schedule->course->name }}</strong>
                        <br>
                        <small class="text-muted">Category: {{ $schedule->course->category->name ?? 'N/A' }}</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Start Date/Time:</strong></div>
                    <div class="col-md-9">
                        {{ $schedule->start_datetime ? $schedule->start_datetime->format('M d, Y H:i') : 'N/A' }}
                        <small class="text-muted">({{ $schedule->start_datetime ? $schedule->start_datetime->diffForHumans() : 'N/A' }})</small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>End Date/Time:</strong></div>
                    <div class="col-md-9">
                        {{ $schedule->end_datetime ? $schedule->end_datetime->format('M d, Y H:i') : 'N/A' }}
                        @if($schedule->start_datetime && $schedule->end_datetime)
                            <small class="text-muted">(Duration: {{ $schedule->start_datetime->diff($schedule->end_datetime)->format('%H:%I hours') }})</small>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Status:</strong></div>
                    <div class="col-md-9">
                        @if($schedule->status == 'scheduled')
                            <span class="badge badge-primary">Scheduled</span>
                        @elseif($schedule->status == 'completed')
                            <span class="badge badge-success">Completed</span>
                        @elseif($schedule->status == 'cancelled')
                            <span class="badge badge-danger">Cancelled</span>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Available Slots:</strong></div>
                    <div class="col-md-9">
                        <span class="badge badge-info">{{ $schedule->available_slots }}</span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Booked Slots:</strong></div>
                    <div class="col-md-9">
                        <span class="badge badge-{{ $schedule->booked_slots > 0 ? 'warning' : 'secondary' }}">{{ $schedule->booked_slots }}</span>
                        <small class="text-muted">
                            ({{ $schedule->available_slots - $schedule->booked_slots }} remaining)
                        </small>
                    </div>
                </div>

                @if($schedule->notes)
                    <div class="row mb-3">
                        <div class="col-md-3"><strong>Notes:</strong></div>
                        <div class="col-md-9">{{ $schedule->notes }}</div>
                    </div>
                @endif

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Created:</strong></div>
                    <div class="col-md-9">
                        {{ $schedule->created_at ? $schedule->created_at->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3"><strong>Last Updated:</strong></div>
                    <div class="col-md-9">
                        {{ $schedule->updated_at ? $schedule->updated_at->format('M d, Y H:i') : 'N/A' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Quick Stats -->
        <div class="card mb-3">
            <div class="card-header">
                <h6 class="mb-0">Quick Stats</h6>
            </div>
            <div class="card-body text-center">
                <div class="row">
                    <div class="col-6">
                        <h4 class="text-info">{{ $schedule->available_slots }}</h4>
                        <small class="text-muted">Available Slots</small>
                    </div>
                    <div class="col-6">
                        <h4 class="text-warning">{{ $schedule->booked_slots }}</h4>
                        <small class="text-muted">Booked</small>
                    </div>
                </div>
                <hr>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" 
                         style="width: {{ $schedule->available_slots > 0 ? ($schedule->booked_slots / $schedule->available_slots) * 100 : 0 }}%">
                    </div>
                </div>
                <small class="text-muted">
                    {{ $schedule->available_slots > 0 ? round(($schedule->booked_slots / $schedule->available_slots) * 100) : 0 }}% Full
                </small>
            </div>
        </div>

        <!-- Course Info -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Course Information</h6>
            </div>
            <div class="card-body">
                <p><strong>Instructor:</strong> {{ $schedule->course->instructor_name ?? 'N/A' }}</p>
                <p><strong>Price:</strong> ${{ number_format($schedule->course->price, 2) }}</p>
                <p><strong>Duration:</strong> {{ $schedule->course->formatted_duration }}</p>
                <p><strong>Max Participants:</strong> {{ $schedule->course->max_participants }}</p>
                @if($schedule->course->description)
                    <p><strong>Description:</strong></p>
                    <p class="small">{{ Str::limit($schedule->course->description, 100) }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Bookings for this Schedule -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Bookings for this Schedule</h5>
            </div>
            <div class="card-body">
                @if($schedule->bookings->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Booking Code</th>
                                    <th>Student</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Booking Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedule->bookings as $booking)
                                    <tr>
                                        <td><code>{{ $booking->booking_code }}</code></td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ $booking->user->email }}</td>
                                        <td>
                                            @if($booking->status == 'confirmed')
                                                <span class="badge badge-success">Confirmed</span>
                                            @elseif($booking->status == 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($booking->status == 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>{{ $booking->created_at ? $booking->created_at->format('M d, Y') : 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-3">
                        <i class="fa fa-calendar-times-o fa-2x text-muted"></i>
                        <p class="mt-2 mb-0">No bookings for this schedule yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection