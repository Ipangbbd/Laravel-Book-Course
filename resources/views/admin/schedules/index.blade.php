@extends('layouts.app')

@section('title', 'Manage Schedules - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Manage Schedules</h2>
            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add New Schedule
            </a>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.schedules.index') }}">
                    <div class="row">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control" placeholder="Search by course name..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="course_id" class="form-control">
                                <option value="">All Courses</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                                        {{ $course->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-control">
                                <option value="">All Status</option>
                                <option value="scheduled" {{ request('status') == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_from" class="form-control" placeholder="From Date" value="{{ request('date_from') }}">
                        </div>
                        <div class="col-md-2">
                            <input type="date" name="date_to" class="form-control" placeholder="To Date" value="{{ request('date_to') }}">
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="btn btn-info">Filter</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Schedules Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if($schedules->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Course</th>
                                    <th>Start Date/Time</th>
                                    <th>End Date/Time</th>
                                    <th>Slots</th>
                                    <th>Booked</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->id }}</td>
                                        <td>
                                            <strong>{{ $schedule->course->name }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $schedule->course->category->name ?? 'N/A' }}</small>
                                        </td>
                                        <td>
                                            {{ $schedule->start_datetime ? $schedule->start_datetime->format('M d, Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            {{ $schedule->end_datetime ? $schedule->end_datetime->format('M d, Y H:i') : 'N/A' }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $schedule->available_slots }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $schedule->booked_slots > 0 ? 'warning' : 'secondary' }}">
                                                {{ $schedule->booked_slots }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($schedule->status == 'scheduled')
                                                <span class="badge badge-primary">Scheduled</span>
                                            @elseif($schedule->status == 'completed')
                                                <span class="badge badge-success">Completed</span>
                                            @elseif($schedule->status == 'cancelled')
                                                <span class="badge badge-danger">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-sm btn-info">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                                <a href="{{ route('admin.schedules.edit', $schedule) }}" class="btn btn-sm btn-warning">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                                <form method="POST" action="{{ route('admin.schedules.destroy', $schedule) }}" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this schedule?')">
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
                        {{ $schedules->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fa fa-calendar-o fa-3x text-muted"></i>
                        <h4 class="mt-3">No Schedules Found</h4>
                        <p class="text-muted">No schedules match your search criteria.</p>
                        <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">Create First Schedule</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection