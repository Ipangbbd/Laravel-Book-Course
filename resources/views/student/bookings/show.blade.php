@extends('layouts.app')

@section('title', 'Booking Details - ' . $booking->booking_code)

@section('content')
    <style>
        /* Booking Details Styles */
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

        .breadcrumb-item+.breadcrumb-item::before {
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

        /* Cards */
        .details-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .details-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .card-header-modern {
            background: var(--secondary-bg);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-title-modern {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body-modern {
            padding: 2rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }

        .status-badge.approved {
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-badge.pending {
            background: rgba(251, 191, 36, 0.15);
            color: var(--warning);
            border: 1px solid rgba(251, 191, 36, 0.3);
        }

        .status-badge.cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-badge.completed {
            background: rgba(59, 130, 246, 0.15);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .status-badge.verified {
            background: rgba(34, 197, 94, 0.15);
            color: var(--success);
            border: 1px solid rgba(34, 197, 94, 0.3);
        }

        .status-badge.rejected {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .status-badge.not-paid {
            background: var(--secondary-bg);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        /* Information Grid */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 1.5rem;
        }

        .info-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .info-section-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-primary);
        }

        .info-value {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .info-value.highlight {
            color: var(--success);
            font-weight: 600;
            font-size: 1rem;
        }

        .info-value.amount {
            color: var(--accent);
            font-weight: 600;
            font-size: 1.125rem;
        }

        /* Course Image */
        .course-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 1.5rem;
        }

        .course-placeholder {
            width: 100%;
            height: 200px;
            background: var(--secondary-bg);
            border: 2px dashed var(--border-color);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .course-placeholder i {
            font-size: 3rem;
            color: var(--text-muted);
        }

        .course-title {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .course-description {
            color: var(--text-secondary);
            line-height: 1.6;
            margin-bottom: 1.5rem;
        }

        /* Alert Styles */
        .alert-modern {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.25rem;
            margin-top: 1.5rem;
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
        }

        .alert-modern i {
            font-size: 1.25rem;
            margin-top: 0.125rem;
            flex-shrink: 0;
        }

        .alert-info-modern {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
            color: var(--info);
        }

        .alert-warning-modern {
            background: rgba(251, 191, 36, 0.1);
            border: 1px solid rgba(251, 191, 36, 0.3);
            color: var(--warning);
        }

        .alert-secondary-modern {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
        }

        .alert-content {
            flex: 1;
        }

        .alert-content strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        /* Notes */
        .notes-section {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1.5rem;
        }

        .notes-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .notes-content {
            color: var(--text-secondary);
            line-height: 1.6;
            margin: 0;
        }

        .admin-notes {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .admin-notes .notes-title {
            color: var(--info);
        }

        /* Action Buttons */
        .modern-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            font-weight: 600;
            font-size: 0.875rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom: 0.75rem;
        }

        .btn-success-modern {
            background: var(--success);
            color: var(--primary-bg);
        }

        .btn-success-modern:hover {
            background: rgba(34, 197, 94, 0.8);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-info-modern {
            background: var(--info);
            color: var(--primary-bg);
        }

        .btn-info-modern:hover {
            background: rgba(59, 130, 246, 0.8);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-danger-modern {
            background: var(--error);
            color: var(--primary-bg);
        }

        .btn-danger-modern:hover {
            background: rgba(239, 68, 68, 0.8);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-outline-danger-modern {
            background: transparent;
            color: var(--error);
            border: 2px solid var(--error);
        }

        .btn-outline-danger-modern:hover {
            background: var(--error);
            color: var(--primary-bg);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-outline-secondary-modern {
            background: transparent;
            color: var(--text-secondary);
            border: 2px solid var(--border-color);
        }

        .btn-outline-secondary-modern:hover {
            background: var(--hover);
            border-color: var(--hover);
            color: var(--text-primary);
            text-decoration: none;
            transform: translateY(-2px);
        }

        .btn-outline-primary-modern {
            background: transparent;
            color: var(--accent);
            border: 2px solid var(--accent);
        }

        .btn-outline-primary-modern:hover {
            background: var(--accent);
            color: var(--primary-bg);
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
            transition: all 0.3s ease;
        }

        .sidebar-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
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

        .contact-info {
            color: var(--text-secondary);
            font-size: 0.875rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .contact-details {
            font-size: 0.875rem;
            line-height: 1.6;
        }

        .contact-details strong {
            color: var(--text-primary);
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
            padding: 1.5rem 2rem;
        }

        .modal-title {
            color: var(--text-primary);
            font-weight: 600;
            font-size: 1.25rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .modal-body {
            color: var(--text-secondary);
            padding: 2rem;
            line-height: 1.6;
        }

        .modal-body strong {
            color: var(--text-primary);
            font-weight: 600;
        }

        .modal-body ul {
            margin: 1rem 0;
            padding-left: 1.5rem;
        }

        .modal-body li {
            margin-bottom: 0.5rem;
        }

        .modal-footer {
            border-top: 1px solid var(--border-color);
            background: var(--secondary-bg);
            border-radius: 0 0 16px 16px;
            padding: 1rem 2rem;
        }

        .close {
            color: var(--text-secondary);
            opacity: 0.8;
            font-size: 1.5rem;
            background: none;
            border: none;
            padding: 0;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s ease;
        }

        .close:hover {
            color: var(--text-primary);
            opacity: 1;
            background: var(--hover);
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

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .card-body-modern {
                padding: 1.5rem;
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
                    <li class="breadcrumb-item"><a href="{{ route('student.bookings.index') }}">My Bookings</a></li>
                    <li class="breadcrumb-item active">{{ $booking->booking_code }}</li>
                </ol>
            </nav>
            <div class="page-header">
                <h2 class="page-title">Booking Details</h2>
                <p class="page-subtitle">View your booking information and status</p>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Booking Information -->
        <div class="col-md-8">
            <!-- Booking Status Card -->
            <div class="details-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fa fa-info-circle"></i>
                        Booking Status
                    </h5>
                    @if($booking->status === 'approved')
                        <span class="status-badge approved">{{ ucfirst($booking->status) }}</span>
                    @elseif($booking->status === 'pending')
                        <span class="status-badge pending">{{ ucfirst($booking->status) }}</span>
                    @elseif($booking->status === 'cancelled')
                        <span class="status-badge cancelled">{{ ucfirst($booking->status) }}</span>
                    @elseif($booking->status === 'completed')
                        <span class="status-badge completed">{{ ucfirst($booking->status) }}</span>
                    @else
                        <span class="status-badge not-paid">{{ ucfirst($booking->status) }}</span>
                    @endif
                </div>
                <div class="card-body-modern">
                    <div class="info-grid">
                        <div class="info-section">
                            <h6 class="info-section-title">Booking Information</h6>
                            <div class="info-item">
                                <span class="info-label">Booking Code:</span>
                                <span class="info-value">{{ $booking->booking_code }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Booking Date:</span>
                                <span class="info-value">{{ $booking->booked_at->format('M j, Y g:i A') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status:</span>
                                @if($booking->status === 'approved')
                                    <span class="info-value"
                                        style="color: var(--success);">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status === 'pending')
                                    <span class="info-value"
                                        style="color: var(--warning);">{{ ucfirst($booking->status) }}</span>
                                @elseif($booking->status === 'cancelled')
                                    <span class="info-value" style="color: var(--error);">{{ ucfirst($booking->status) }}</span>
                                @else
                                    <span class="info-value">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-section">
                            <h6 class="info-section-title">Payment Status</h6>
                            @if($booking->payment)
                                <div class="info-item">
                                    <span class="info-label">Payment Status:</span>
                                    @if($booking->payment->status === 'verified')
                                        <span class="info-value"
                                            style="color: var(--success);">{{ ucfirst($booking->payment->status) }}</span>
                                    @elseif($booking->payment->status === 'pending')
                                        <span class="info-value"
                                            style="color: var(--warning);">{{ ucfirst($booking->payment->status) }}</span>
                                    @else
                                        <span class="info-value"
                                            style="color: var(--error);">{{ ucfirst($booking->payment->status) }}</span>
                                    @endif
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Amount:</span>
                                    <span class="info-value amount">Rp.{{ number_format($booking->payment->amount, 2) }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Payment Date:</span>
                                    <span class="info-value">{{ $booking->payment->paid_at->format('M j, Y') }}</span>
                                </div>
                            @else
                                <div class="info-item">
                                    <span class="info-label">Payment Status:</span>
                                    <span class="info-value" style="color: var(--text-muted);">Not Paid</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">Amount Due:</span>
                                    <span
                                        class="info-value amount">Rp.{{ number_format($booking->schedule->course->price, 2) }}</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($booking->notes)
                        <div class="notes-section">
                            <h6 class="notes-title">
                                <i class="fa fa-sticky-note-o"></i>
                                Your Notes
                            </h6>
                            <p class="notes-content">{{ $booking->notes }}</p>
                        </div>
                    @endif

                    @if($booking->admin_notes)
                        <div class="notes-section admin-notes">
                            <h6 class="notes-title">
                                <i class="fa fa-user-circle-o"></i>
                                Admin Notes
                            </h6>
                            <p class="notes-content">{{ $booking->admin_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Course Information -->
            <div class="details-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fa fa-book"></i>
                        Course Information
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="info-grid">
                        <div class="info-section">
                            @if($booking->schedule->course->image_path)
                                <img src="{{ asset('storage/' . $booking->schedule->course->image_path) }}" class="course-image"
                                    alt="{{ $booking->schedule->course->name }}">
                            @else
                                <div class="course-placeholder">
                                    <i class="fa fa-book"></i>
                                </div>
                            @endif
                        </div>
                        <div class="info-section">
                            <h4 class="course-title">{{ $booking->schedule->course->name }}</h4>
                            <p class="course-description">{{ $booking->schedule->course->description }}</p>

                            <div class="info-grid">
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">Category:</span>
                                        <span class="info-value">{{ $booking->schedule->course->category->name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Instructor:</span>
                                        <span class="info-value">{{ $booking->schedule->course->instructor_name }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Duration:</span>
                                        <span class="info-value">{{ $booking->schedule->course->formatted_duration }}</span>
                                    </div>
                                </div>
                                <div class="info-section">
                                    <div class="info-item">
                                        <span class="info-label">Price:</span>
                                        <span
                                            class="info-value amount">Rp.{{ number_format($booking->schedule->course->price, 2) }}</span>
                                    </div>
                                    <div class="info-item">
                                        <span class="info-label">Max Participants:</span>
                                        <span class="info-value">{{ $booking->schedule->course->max_participants }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule Information -->
            <div class="details-card">
                <div class="card-header-modern">
                    <h5 class="card-title-modern">
                        <i class="fa fa-calendar"></i>
                        Schedule Information
                    </h5>
                </div>
                <div class="card-body-modern">
                    <div class="info-grid">
                        <div class="info-section">
                            <h6 class="info-section-title">Session Date & Time</h6>
                            <div class="info-item">
                                <span class="info-label">Date:</span>
                                <span
                                    class="info-value">{{ $booking->schedule->start_datetime->format('l, M j, Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Start Time:</span>
                                <span class="info-value">{{ $booking->schedule->start_datetime->format('g:i A') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">End Time:</span>
                                <span class="info-value">{{ $booking->schedule->end_datetime->format('g:i A') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Duration:</span>
                                <span
                                    class="info-value">{{ $booking->schedule->start_datetime->diffInMinutes($booking->schedule->end_datetime) }}
                                    minutes</span>
                            </div>
                        </div>
                        <div class="info-section">
                            <h6 class="info-section-title">Availability</h6>
                            <div class="info-item">
                                <span class="info-label">Total Slots:</span>
                                <span class="info-value">{{ $booking->schedule->available_slots }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Booked Slots:</span>
                                <span class="info-value">{{ $booking->schedule->booked_slots }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Available Slots:</span>
                                <span
                                    class="info-value highlight">{{ $booking->schedule->available_slots - $booking->schedule->booked_slots }}</span>
                            </div>

                            @if($booking->schedule->notes)
                                <div class="notes-section" style="margin-top: 1rem;">
                                    <h6 class="notes-title">
                                        <i class="fa fa-info-circle"></i>
                                        Schedule Notes
                                    </h6>
                                    <p class="notes-content">{{ $booking->schedule->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if($booking->schedule->start_datetime > now())
                        <div class="alert-modern alert-info-modern">
                            <i class="fa fa-clock-o"></i>
                            <div class="alert-content">
                                <strong>Upcoming Session:</strong>
                                This session is scheduled for {{ $booking->schedule->start_datetime->diffForHumans() }}.
                            </div>
                        </div>
                    @elseif($booking->schedule->start_datetime <= now() && $booking->schedule->end_datetime > now())
                        <div class="alert-modern alert-warning-modern">
                            <i class="fa fa-play"></i>
                            <div class="alert-content">
                                <strong>Session in Progress:</strong>
                                This session is currently ongoing.
                            </div>
                        </div>
                    @else
                        <div class="alert-modern alert-secondary-modern">
                            <i class="fa fa-check"></i>
                            <div class="alert-content">
                                <strong>Session Completed:</strong>
                                This session ended {{ $booking->schedule->end_datetime->diffForHumans() }}.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Actions -->
        <div class="col-md-4">
            <!-- Quick Actions -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h6 class="sidebar-title">
                        <i class="fa fa-bolt"></i>
                        Actions
                    </h6>
                </div>
                <div class="sidebar-body">
                    @if(!$booking->payment)
                        <a href="{{ route('student.payments.create', ['booking_id' => $booking->id]) }}"
                            class="modern-btn btn-success-modern">
                            <i class="fa fa-credit-card"></i> Make Payment
                        </a>
                    @elseif($booking->payment)
                        <a href="{{ route('student.payments.show', $booking->payment) }}" class="modern-btn btn-info-modern">
                            <i class="fa fa-eye"></i> View Payment
                        </a>
                    @endif

                    @if($booking->canBeCancelled())
                        <button type="button" class="modern-btn btn-outline-danger-modern" data-toggle="modal"
                            data-target="#cancelModal">
                            <i class="fa fa-times"></i> Cancel Booking
                        </button>
                    @endif

                    <a href="{{ route('student.bookings.index') }}" class="modern-btn btn-outline-secondary-modern">
                        <i class="fa fa-arrow-left"></i> Back to Bookings
                    </a>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h6 class="sidebar-title">
                        <i class="fa fa-question-circle"></i>
                        Need Help?
                    </h6>
                </div>
                <div class="sidebar-body">
                    <p class="contact-info">
                        If you have any questions about your booking or need assistance,
                        please contact our support team.
                    </p>
                    <div class="contact-details">
                        <strong>Email:</strong> support@coursebooking.com<br>
                        <strong>Phone:</strong> (555) 123-4567
                    </div>
                </div>
            </div>

            <!-- Course Link -->
            <div class="sidebar-card">
                <div class="sidebar-body" style="text-align: center;">
                    <a href="{{ route('student.courses.show', $booking->schedule->course) }}"
                        class="modern-btn btn-outline-primary-modern">
                        <i class="fa fa-book"></i> View Course Details
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Booking Modal -->
    @if($booking->canBeCancelled())
        <div class="modal fade" id="cancelModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form method="POST" action="{{ route('student.bookings.cancel', $booking) }}">
                        @csrf
                        @method('PATCH')

                        <div class="modal-header">
                            <h5 class="modal-title">
                                <i class="fa fa-exclamation-triangle"></i>
                                Cancel Booking
                            </h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span>&times;</span>
                            </button>
                        </div>

                        <div class="modal-body">
                            <div class="alert-modern alert-warning-modern">
                                <i class="fa fa-exclamation-triangle"></i>
                                <div class="alert-content">
                                    <strong>Warning:</strong> This action cannot be undone.
                                </div>
                            </div>

                            <p style="color: var(--text-secondary); margin-bottom: 1rem;">Are you sure you want to cancel your
                                booking for:</p>
                            <ul style="color: var(--text-secondary); margin-bottom: 1.5rem; padding-left: 1.5rem;">
                                <li><strong style="color: var(--text-primary);">Course:</strong>
                                    {{ $booking->schedule->course->name }}</li>
                                <li><strong style="color: var(--text-primary);">Date:</strong>
                                    {{ $booking->schedule->start_datetime->format('M j, Y g:i A') }}</li>
                                <li><strong style="color: var(--text-primary);">Booking Code:</strong>
                                    {{ $booking->booking_code }}</li>
                            </ul>

                            <div class="form-group">
                                <label for="cancellation_reason" class="form-label">Reason for cancellation: <span
                                        class="required">*</span></label>
                                <textarea class="form-control" id="cancellation_reason" name="cancellation_reason" rows="3"
                                    required placeholder="Please provide a reason for cancelling this booking"></textarea>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="modern-btn btn-outline-secondary-modern" data-dismiss="modal">
                                Keep Booking
                            </button>
                            <button type="submit" class="modern-btn btn-danger-modern">
                                <i class="fa fa-times"></i> Cancel Booking
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection