@extends('layouts.app')

@section('title', 'Edit Schedule - Admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Edit Schedule</h2>
            <div>
                <a href="{{ route('admin.schedules.show', $schedule) }}" class="btn btn-info">
                    <i class="fa fa-eye"></i> View Schedule
                </a>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back to Schedules
                </a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.schedules.update', $schedule) }}">
                    @csrf
                    @method('PATCH')
                    
                    <div class="form-group">
                        <label for="course_id">Course <span class="text-danger">*</span></label>
                        <select name="course_id" id="course_id" class="form-control @error('course_id') is-invalid @enderror" required>
                            <option value="">Select a course...</option>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}" {{ (old('course_id') ?? $schedule->course_id) == $course->id ? 'selected' : '' }}>
                                    {{ $course->name }} ({{ $course->category->name ?? 'No Category' }})
                                </option>
                            @endforeach
                        </select>
                        @error('course_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="start_datetime">Start Date/Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       name="start_datetime" 
                                       id="start_datetime" 
                                       class="form-control @error('start_datetime') is-invalid @enderror" 
                                       value="{{ old('start_datetime') ?? $schedule->start_datetime->format('Y-m-d\TH:i') }}" 
                                       required>
                                @error('start_datetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="end_datetime">End Date/Time <span class="text-danger">*</span></label>
                                <input type="datetime-local" 
                                       name="end_datetime" 
                                       id="end_datetime" 
                                       class="form-control @error('end_datetime') is-invalid @enderror" 
                                       value="{{ old('end_datetime') ?? $schedule->end_datetime->format('Y-m-d\TH:i') }}" 
                                       required>
                                @error('end_datetime')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="available_slots">Available Slots <span class="text-danger">*</span></label>
                                <input type="number" 
                                       name="available_slots" 
                                       id="available_slots" 
                                       class="form-control @error('available_slots') is-invalid @enderror" 
                                       value="{{ old('available_slots') ?? $schedule->available_slots }}" 
                                       min="{{ $schedule->booked_slots }}" 
                                       max="100"
                                       required>
                                @error('available_slots')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">
                                    Current bookings: {{ $schedule->booked_slots }}. 
                                    Cannot reduce below this number.
                                </small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">Status <span class="text-danger">*</span></label>
                                <select name="status" id="status" class="form-control @error('status') is-invalid @enderror" required>
                                    <option value="">Select status...</option>
                                    <option value="scheduled" {{ (old('status') ?? $schedule->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    <option value="cancelled" {{ (old('status') ?? $schedule->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    <option value="completed" {{ (old('status') ?? $schedule->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="notes">Notes</label>
                        <textarea name="notes" 
                                  id="notes" 
                                  class="form-control @error('notes') is-invalid @enderror" 
                                  rows="4" 
                                  placeholder="Optional notes about this schedule...">{{ old('notes') ?? $schedule->notes }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Update Schedule
                        </button>
                        <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary ml-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-update end datetime when start datetime changes
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('start_datetime').addEventListener('change', function() {
        const startDate = new Date(this.value);
        if (startDate) {
            document.getElementById('end_datetime').min = this.value;
        }
    });
});
</script>
@endsection