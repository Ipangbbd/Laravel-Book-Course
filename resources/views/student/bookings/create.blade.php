@extends('layouts.app')

@section('title', 'Book Course - Course Booking System')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ route('student.bookings.index') }}">My Bookings</a></li>
                <li class="breadcrumb-item active">Book Course</li>
            </ol>
        </nav>
        <h2>Book a Course</h2>
        <p class="text-muted">Select a course session and complete your booking</p>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Booking Form</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('student.bookings.store') }}">
                    @csrf
                    
                    <!-- Pre-selected Schedule -->
                    @if($schedule) 
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <div class="card mb-4 border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">Selected Course & Schedule</h6>
                            </div>
                            <div class="card-body">
                                <h5>{{ $schedule->course->name }}</h5>
                                <p class="text-muted">{{ $schedule->course->description }}</p>
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Category:</strong> {{ $schedule->course->category->name }}<br>
                                        <strong>Instructor:</strong> {{ $schedule->course->instructor_name }}<br>
                                        <strong>Duration:</strong> {{ $schedule->course->formatted_duration }}
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Schedule:</strong> {{ $schedule->start_datetime->format('M j, Y') }}<br>
                                        <strong>Time:</strong> {{ $schedule->start_datetime->format('g:i A') }} - {{ $schedule->end_datetime->format('g:i A') }}<br>
                                        <strong>Price:</strong> <span class="text-primary">${{ number_format($schedule->course->price, 2) }}</span>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <strong>Available Slots:</strong> 
                                    <span class="{{ $schedule->isFull() ? 'text-danger' : 'text-success' }}">
                                        {{ $schedule->available_slots - $schedule->booked_slots }} / {{ $schedule->available_slots }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @else
                        
                    <!-- Schedule Selection --> 
                        <div class="form-group">
                            <label for="schedule_id">Select Course & Schedule <span class="text-danger">*</span></label>
                            <select class="form-control @error('schedule_id') is-invalid @enderror" 
                                    id="schedule_id" 
                                    name="schedule_id" 
                                    required>
                                <option value="">Choose a course schedule...</option>
                                @foreach($availableSchedules as $courseName => $schedules)
                                    <optgroup label="{{ $courseName }}">
                                        @foreach($schedules as $schedule)
                                            <option value="{{ $schedule->id }}" 
                                                    {{ old('schedule_id') == $schedule->id ? 'selected' : '' }}
                                                    data-price="{{ $schedule->course->price }}"
                                                    data-slots="{{ $schedule->available_slots - $schedule->booked_slots }}">
                                                {{ $schedule->start_datetime->format('M j, Y g:i A') }} 
                                                ({{ $schedule->available_slots - $schedule->booked_slots }} slots available)
                                                - ${{ number_format($schedule->course->price, 2) }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('schedule_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    @endif
                    
                    <!-- Notes -->
                    <div class="form-group">
                        <label for="notes">Additional Notes (Optional)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                    id="notes" 
                                    name="notes" 
                                    rows="3" 
                                    placeholder="Any special requirements or notes about your booking...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Maximum 1000 characters</small>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="accept_terms" required>
                            <label class="form-check-label" for="accept_terms">
                                I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a> <span class="text-danger">*</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fa fa-calendar-plus-o"></i> Complete Booking
                        </button>
                        <a href="{{ route('student.courses.index') }}" class="btn btn-outline-secondary btn-block">
                            <i class="fa fa-arrow-left"></i> Back to Courses
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h6 class="mb-0">Booking Information</h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i>
                    <strong>Important Notes:</strong>
                    <ul class="mb-0 mt-2">
                        <li>Your booking will be pending until payment is verified</li>
                        <li>Payment is required within 24 hours</li>
                        <li>Cancellation is allowed up to 24 hours before the session</li>
                        <li>A confirmation email will be sent upon successful booking</li>
                    </ul>
                </div>
            </div>
        </div>
        
        @if($schedule)
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Next Steps</h6>
            </div>
            <div class="card-body">
                <ol class="mb-0">
                    <li>Complete this booking form</li>
                    <li>Submit payment proof</li>
                    <li>Wait for admin verification</li>
                    <li>Receive confirmation email</li>
                    <li>Attend your session</li>
                </ol>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Terms and Conditions Modal -->
<div class="modal fade" id="termsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Terms and Conditions</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h6>Course Booking Terms</h6>
                <ul>
                    <li>All bookings are subject to availability</li>
                    <li>Payment must be completed within 24 hours of booking</li>
                    <li>Cancellations must be made at least 24 hours before the scheduled session</li>
                    <li>No-shows will not be eligible for refunds</li>
                    <li>Course schedules may be subject to change with prior notice</li>
                </ul>
                
                <h6>Payment Terms</h6>
                <ul>
                    <li>Full payment is required before session confirmation</li>
                    <li>Refunds are processed within 5-7 business days for valid cancellations</li>
                    <li>Payment verification may take up to 48 hours</li>
                </ul>
                
                <h6>Conduct Policy</h6>
                <ul>
                    <li>Students are expected to attend sessions on time</li>
                    <li>Respectful behavior towards instructors and fellow students is required</li>
                    <li>Course materials are for personal use only</li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    I Understand
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const scheduleSelect = document.getElementById('schedule_id');
    if (scheduleSelect) {
        scheduleSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const price = selectedOption.getAttribute('data-price');
                const slots = selectedOption.getAttribute('data-slots');
                
                // You can add dynamic updates here if needed
                console.log('Selected schedule - Price: $' + price + ', Slots: ' + slots);
            }
        });
    }
});
</script>
@endsection