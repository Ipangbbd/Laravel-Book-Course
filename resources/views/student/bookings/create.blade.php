@extends('layouts.app')

@section('title', 'Book Course - Xperium Academy')

@section('content')
<style>
    /* Booking Create Styles */
    .breadcrumb {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem 1.5rem;
        margin-bottom: 2rem;
    }

    .breadcrumb-item {
        color: var(--text-secondary);
        font-weight: 500;
    }

    .breadcrumb-item.active {
        color: var(--text-primary);
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "/";
        color: var(--text-muted);
    }

    .breadcrumb a {
        color: var(--text-secondary);
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .breadcrumb a:hover {
        color: var(--text-primary);
    }

    .page-header {
        margin-bottom: 2rem;
    }

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .page-subtitle {
        font-size: 1.125rem;
        color: var(--text-secondary);
        margin: 0;
    }

    /* Form Card */
    .form-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .form-header {
        background: var(--secondary-bg);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .form-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-body {
        padding: 2rem;
    }

    /* Selected Course Card */
    .selected-course-card {
        background: var(--card-bg);
        border: 2px solid var(--info);
        border-radius: 16px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .selected-course-header {
        background: linear-gradient(135deg, var(--info) 0%, rgba(59, 130, 246, 0.8) 100%);
        color: var(--primary-bg);
        padding: 1.5rem 2rem;
    }

    .selected-course-title {
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .selected-course-body {
        padding: 2rem;
    }

    .course-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .course-description {
        color: var(--text-secondary);
        margin-bottom: 2rem;
        line-height: 1.6;
    }

    .course-details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        margin-bottom: 1.5rem;
    }

    .detail-group {
        display: flex;
        flex-direction: column;
        gap: 0.75rem;
    }

    .detail-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.5rem 0;
    }

    .detail-label {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .detail-value {
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .detail-value.highlight {
        color: var(--success);
        font-weight: 600;
        font-size: 1rem;
    }

    .availability-info {
        background: var(--secondary-bg);
        border: 1px solid var(--border-color);
        border-radius: 12px;
        padding: 1rem;
        margin-top: 1.5rem;
    }

    .availability-label {
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
    }

    .availability-value {
        font-size: 1.125rem;
        font-weight: 600;
    }

    .availability-value.available {
        color: var(--success);
    }

    .availability-value.full {
        color: var(--error);
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.875rem;
        margin-bottom: 0.75rem;
        display: block;
    }

    .form-label .required {
        color: var(--error);
        margin-left: 0.25rem;
    }

    .form-control {
        background: var(--secondary-bg);
        border: 2px solid var(--border-color);
        color: var(--text-primary);
        border-radius: 12px;
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        width: 100%;
    }

    .form-control:focus {
        background: var(--secondary-bg);
        border-color: var(--accent);
        color: var(--text-primary);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: var(--text-muted);
    }

    .form-control.is-invalid {
        border-color: var(--error);
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }

    .form-control option {
        background: var(--secondary-bg);
        color: var(--text-primary);
        padding: 0.5rem;
    }

    .invalid-feedback {
        color: var(--error);
        font-size: 0.875rem;
        font-weight: 500;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-text {
        color: var(--text-muted);
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

    /* Checkbox */
    .form-check {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 2rem;
    }

    .form-check-input {
        width: 18px;
        height: 18px;
        border: 2px solid var(--border-color);
        border-radius: 4px;
        background: var(--secondary-bg);
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .form-check-input:checked {
        background: var(--accent);
        border-color: var(--accent);
    }

    .form-check-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        cursor: pointer;
        user-select: none;
    }

    .form-check-label a {
        color: var(--accent);
        text-decoration: none;
        font-weight: 600;
    }

    .form-check-label a:hover {
        color: var(--text-primary);
        text-decoration: underline;
    }

    /* Buttons */
    .modern-btn {
        padding: 1rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        border: none;
        cursor: pointer;
        width: 100%;
        margin-bottom: 1rem;
    }

    .btn-primary-modern {
        background: var(--accent);
        color: var(--primary-bg);
    }

    .btn-primary-modern:hover {
        background: var(--text-secondary);
        color: var(--primary-bg);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    .btn-outline-modern {
        background: transparent;
        color: var(--text-secondary);
        border: 2px solid var(--border-color);
    }

    .btn-outline-modern:hover {
        background: var(--hover);
        border-color: var(--hover);
        color: var(--text-primary);
        text-decoration: none;
        transform: translateY(-2px);
    }

    /* Sidebar Cards */
    .sidebar-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .sidebar-header {
        background: var(--secondary-bg);
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid var(--border-color);
    }

    .sidebar-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .sidebar-body {
        padding: 1.5rem;
    }

    .alert-info {
        background: rgba(59, 130, 246, 0.1);
        border: 1px solid rgba(59, 130, 246, 0.3);
        color: var(--info);
        border-radius: 12px;
        padding: 1rem;
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
    }

    .alert-info i {
        font-size: 1.25rem;
        margin-top: 0.125rem;
        flex-shrink: 0;
    }

    .alert-info ul {
        margin: 0.5rem 0 0;
        padding-left: 1rem;
    }

    .alert-info li {
        margin-bottom: 0.25rem;
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .steps-list {
        list-style: none;
        padding: 0;
        margin: 0;
        counter-reset: step-counter;
    }

    .steps-list li {
        counter-increment: step-counter;
        position: relative;
        padding-left: 2rem;
        margin-bottom: 0.75rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.4;
    }

    .steps-list li::before {
        content: counter(step-counter);
        position: absolute;
        left: 0;
        top: 0;
        width: 1.5rem;
        height: 1.5rem;
        background: var(--accent);
        color: var(--primary-bg);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Modal Styles */
    .modal-content {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
    }

    .modal-header {
        background: var(--secondary-bg);
        border-bottom: 1px solid var(--border-color);
        border-radius: 16px 16px 0 0;
    }

    .modal-title {
        color: var(--text-primary);
        font-weight: 600;
    }

    .modal-body {
        color: var(--text-secondary);
        padding: 2rem;
    }

    .modal-body h6 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .modal-body ul {
        margin-bottom: 1.5rem;
    }

    .modal-body li {
        margin-bottom: 0.5rem;
        line-height: 1.5;
    }

    .modal-footer {
        border-top: 1px solid var(--border-color);
        background: var(--secondary-bg);
        border-radius: 0 0 16px 16px;
    }

    .close {
        color: var(--text-secondary);
        opacity: 0.8;
    }

    .close:hover {
        color: var(--text-primary);
        opacity: 1;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .page-title {
            font-size: 2rem;
        }
        
        .form-body {
            padding: 1.5rem;
        }
        
        .selected-course-body {
            padding: 1.5rem;
        }
        
        .course-details-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .sidebar-body {
            padding: 1.25rem;
        }
    }
</style>

<div class="row mb-4">
    <div class="col-12">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('student.courses.index') }}">Courses</a></li>
                <li class="breadcrumb-item"><a href="{{ route('student.bookings.index') }}">My Bookings</a></li>
                <li class="breadcrumb-item active">Book Course</li>
            </ol>
        </nav>
        <div class="page-header">
            <h2 class="page-title">Book a Course</h2>
            <p class="page-subtitle">Select a course session and complete your booking</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-card">
            <div class="form-header">
                <h5 class="form-title">
                    <i class="fa fa-calendar-plus-o"></i>
                    Booking Form
                </h5>
            </div>
            <div class="form-body">
                <form method="POST" action="{{ route('student.bookings.store') }}">
                    @csrf
                    
                    <!-- Pre-selected Schedule -->
                    @if($schedule) 
                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        <div class="selected-course-card">
                            <div class="selected-course-header">
                                <h6 class="selected-course-title">
                                    <i class="fa fa-check-circle"></i>
                                    Selected Course & Schedule
                                </h6>
                            </div>
                            <div class="selected-course-body">
                                <h4 class="course-name">{{ $schedule->course->name }}</h4>
                                <p class="course-description">{{ $schedule->course->description }}</p>
                                
                                <div class="course-details-grid">
                                    <div class="detail-group">
                                        <div class="detail-item">
                                            <span class="detail-label">Category:</span>
                                            <span class="detail-value">{{ $schedule->course->category->name }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Instructor:</span>
                                            <span class="detail-value">{{ $schedule->course->instructor_name }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Duration:</span>
                                            <span class="detail-value">{{ $schedule->course->formatted_duration }}</span>
                                        </div>
                                    </div>
                                    <div class="detail-group">
                                        <div class="detail-item">
                                            <span class="detail-label">Schedule:</span>
                                            <span class="detail-value">{{ $schedule->start_datetime->format('M j, Y') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Time:</span>
                                            <span class="detail-value">{{ $schedule->start_datetime->format('g:i A') }} - {{ $schedule->end_datetime->format('g:i A') }}</span>
                                        </div>
                                        <div class="detail-item">
                                            <span class="detail-label">Price:</span>
                                            <span class="detail-value highlight">Rp.{{ number_format($schedule->course->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="availability-info">
                                    <div class="availability-label">Available Slots:</div>
                                    <div class="availability-value {{ $schedule->isFull() ? 'full' : 'available' }}">
                                        {{ $schedule->available_slots - $schedule->booked_slots }} / {{ $schedule->available_slots }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        
                    <!-- Schedule Selection --> 
                        <div class="form-group">
                            <label for="schedule_id" class="form-label">Select Course & Schedule <span class="required">*</span></label>
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
                                                - Rp.{{ number_format($schedule->course->price, 2) }}
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
                        <label for="notes" class="form-label">Additional Notes (Optional)</label>
                        <textarea class="form-control @error('notes') is-invalid @enderror" 
                                    id="notes" 
                                    name="notes" 
                                    rows="4" 
                                    placeholder="Any special requirements or notes about your booking...">{{ old('notes') }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text">Maximum 1000 characters</small>
                    </div>
                    
                    <!-- Terms and Conditions -->
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="accept_terms" required>
                            <label class="form-check-label" for="accept_terms">
                                I agree to the <a href="#" data-toggle="modal" data-target="#termsModal">Terms and Conditions</a> <span class="required">*</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" class="modern-btn btn-primary-modern">
                            <i class="fa fa-calendar-plus-o"></i> Complete Booking
                        </button>
                        <a href="{{ route('student.courses.index') }}" class="modern-btn btn-outline-modern">
                            <i class="fa fa-arrow-left"></i> Back to Courses
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Sidebar -->
    <div class="col-md-4">
        <div class="sidebar-card">
            <div class="sidebar-header">
                <h6 class="sidebar-title">
                    <i class="fa fa-info-circle"></i>
                    Booking Information
                </h6>
            </div>
            <div class="sidebar-body">
                <div class="alert-info">
                    <i class="fa fa-lightbulb-o"></i>
                    <div>
                        <strong>Important Notes:</strong>
                        <ul>
                            <li>Your booking will be pending until payment is verified</li>
                            <li>Payment is required within 24 hours</li>
                            <li>Cancellation is allowed up to 24 hours before the session</li>
                            <li>A confirmation email will be sent upon successful booking</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        @if($schedule)
        <div class="sidebar-card">
            <div class="sidebar-header">
                <h6 class="sidebar-title">
                    <i class="fa fa-list-ol"></i>
                    Next Steps
                </h6>
            </div>
            <div class="sidebar-body">
                <ol class="steps-list">
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
                <h5 class="modal-title">
                    <i class="fa fa-file-text-o"></i>
                    Terms and Conditions
                </h5>
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
                <button type="button" class="modern-btn btn-primary-modern" data-dismiss="modal">
                    <i class="fa fa-check"></i>
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