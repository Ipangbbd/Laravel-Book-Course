@extends('layouts.app')

@section('title', $course->name . ' - Course Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Course Details</h2>
                <div>
                    <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit Course
                    </a>
                    <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary ml-2">
                        <i class="fa fa-arrow-left"></i> Back to Courses
                    </a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="mb-0">{{ $course->name }}</h5>
                        </div>
                        <div class="card-body">
                            @if($course->image_path)
                                <div class="mb-3">
                                    <img src="{{ asset('storage/' . $course->image_path) }}" 
                                         alt="{{ $course->name }}" 
                                         class="img-fluid rounded" 
                                         style="max-height: 300px; width: 100%; object-fit: cover;">
                                </div>
                            @endif

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Category:</strong>
                                    <span class="badge badge-info">{{ $course->category->name ?? 'N/A' }}</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Status:</strong>
                                    @if($course->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @elseif($course->status === 'inactive')
                                        <span class="badge badge-secondary">Inactive</span>
                                    @else
                                        <span class="badge badge-warning">Draft</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <h6>Description</h6>
                                <p>{{ $course->description }}</p>
                            </div>

                            <div class="row">
                                <div class="col-md-3">
                                    <h6>Instructor</h6>
                                    <p><i class="fa fa-user"></i> {{ $course->instructor_name }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6>Duration</h6>
                                    <p><i class="fa fa-clock-o"></i> {{ $course->formatted_duration }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6>Max Participants</h6>
                                    <p><i class="fa fa-users"></i> {{ $course->max_participants }}</p>
                                </div>
                                <div class="col-md-3">
                                    <h6>Price</h6>
                                    <p><i class="fa fa-dollar"></i> ${{ number_format($course->price, 2) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schedules Section -->
                    @if($course->schedules->count() > 0)
                        <div class="card mt-4">
                            <div class="card-header">
                                <h5 class="mb-0">Course Schedules</h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Start Date & Time</th>
                                                <th>End Date & Time</th>
                                                <th>Available Slots</th>
                                                <th>Booked Slots</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($course->schedules as $schedule)
                                                <tr>
                                                    <td>{{ $schedule->start_datetime->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $schedule->end_datetime->format('Y-m-d H:i') }}</td>
                                                    <td>{{ $schedule->available_slots }}</td>
                                                    <td>{{ $schedule->booked_slots }}</td>
                                                    <td>
                                                        @if($schedule->status === 'scheduled')
                                                            <span class="badge badge-success">Scheduled</span>
                                                        @elseif($schedule->status === 'cancelled')
                                                            <span class="badge badge-danger">Cancelled</span>
                                                        @else
                                                            <span class="badge badge-warning">{{ ucfirst($schedule->status) }}</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
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
                                <a href="{{ route('admin.courses.edit', $course) }}" class="btn btn-warning btn-block">
                                    <i class="fa fa-edit"></i> Edit Course
                                </a>
                                <a href="{{ route('admin.schedules.create', ['course_id' => $course->id]) }}" class="btn btn-info btn-block">
                                    <i class="fa fa-calendar-plus-o"></i> Add Schedule
                                </a>
                                <form action="{{ route('admin.courses.destroy', $course) }}" 
                                      method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this course? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-block">
                                        <i class="fa fa-trash"></i> Delete Course
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Course Statistics -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <h4 class="text-primary">{{ $course->schedules->count() }}</h4>
                                    <small class="text-muted">Schedules</small>
                                </div>
                                <div class="col-6">
                                    <h4 class="text-success">{{ $course->schedules->sum('booked_slots') }}</h4>
                                    <small class="text-muted">Total Bookings</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information -->
                    <div class="card mt-3">
                        <div class="card-header">
                            <h5 class="mb-0">Meta Information</h5>
                        </div>
                        <div class="card-body">
                            <p><strong>Created:</strong><br>{{ $course->created_at ? $course->created_at->format('Y-m-d H:i') : 'N/A' }}</p>
                            <p><strong>Last Updated:</strong><br>{{ $course->updated_at ? $course->updated_at->format('Y-m-d H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection