@extends('layouts.app')

@section('title', $course->name . ' - Course Details')

@section('content')
    <style>
        /* Course Detail Styles */
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

        /* Course Cards */
        .course-detail-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .course-hero-image {
            height: 400px;
            object-fit: cover;
            width: 100%;
            border-radius: 16px 16px 0 0;
        }

        .course-hero-placeholder {
            height: 400px;
            background: var(--hover);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 4rem;
            border-radius: 16px 16px 0 0;
        }

        .course-detail-body {
            padding: 2rem;
        }

        .course-detail-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .course-badges {
            display: flex;
            gap: 0.75rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .modern-badge {
            padding: 0.5rem 1rem;
            border-radius: 10px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: capitalize;
            letter-spacing: 0.025em;
        }

        .badge-category {
            background: rgba(160, 160, 160, 0.15);
            color: var(--text-secondary);
            border: 1px solid rgba(160, 160, 160, 0.3);
        }

        .badge-duration {
            background: rgba(59, 130, 246, 0.15);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.3);
        }

        .badge-price {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .course-meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 2rem;
            padding: 1.5rem;
            background: var(--secondary-bg);
            border-radius: 12px;
            border: 1px solid var(--border-color);
        }

        .meta-item h6 {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .meta-item p {
            font-size: 1rem;
            color: var(--text-primary);
            font-weight: 600;
            margin: 0;
        }

        .course-description {
            font-size: 1rem;
            line-height: 1.7;
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        .course-description h6 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1.125rem;
        }

        /* Schedule Cards */
        .schedule-section {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
        }

        .schedule-header {
            background: var(--secondary-bg);
            padding: 1.5rem 2rem;
            border-bottom: 1px solid var(--border-color);
        }

        .schedule-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .schedule-body {
            padding: 2rem;
        }

        .schedule-card {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            padding: 1.5rem;
            transition: all 0.3s ease;
            margin-bottom: 1.5rem;
        }

        .schedule-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .schedule-card.full {
            border-color: rgba(239, 68, 68, 0.3);
            background: rgba(239, 68, 68, 0.05);
        }

        .schedule-card.available {
            border-color: rgba(16, 185, 129, 0.3);
            background: rgba(16, 185, 129, 0.05);
        }

        .schedule-date {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
        }

        .schedule-time {
            color: var(--text-secondary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .schedule-meta {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            gap: 1rem;
        }

        .slots-info {
            flex: 1;
        }

        .slots-info small {
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: block;
            margin-bottom: 0.25rem;
        }

        .slots-count {
            font-weight: 600;
            font-size: 1rem;
        }

        .slots-count.available {
            color: var(--success);
        }

        .slots-count.full {
            color: var(--error);
        }

        .schedule-notes {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.875rem;
            color: var(--text-muted);
            font-style: italic;
        }

        /* Buttons */
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
            min-width: 120px;
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
        }

        .btn-secondary-modern {
            background: var(--hover);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .btn-danger-modern {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.3);
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

        .btn-block-modern {
            width: 100%;
        }

        .btn-sm-modern {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
            min-width: 100px;
        }

        /* Sidebar */
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
        }

        .sidebar-body {
            padding: 1.5rem;
        }

        .price-highlight {
            font-size: 2rem;
            font-weight: 700;
            color: var(--success);
            margin-bottom: 0.5rem;
        }

        .price-subtitle {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 2rem;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .info-list li:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-list i {
            color: var(--text-muted);
            width: 16px;
            text-align: center;
            margin-top: 0.125rem;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .info-value {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        /* Booking Cards */
        .booking-item {
            padding: 1rem 0;
            border-bottom: 1px solid var(--border-color);
        }

        .booking-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .booking-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.5rem;
        }

        .booking-code {
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-approved {
            background: rgba(16, 185, 129, 0.15);
            color: var(--success);
            border: 1px solid rgba(16, 185, 129, 0.3);
        }

        .status-pending {
            background: rgba(245, 158, 11, 0.15);
            color: var(--warning);
            border: 1px solid rgba(245, 158, 11, 0.3);
        }

        .status-cancelled {
            background: rgba(239, 68, 68, 0.15);
            color: var(--error);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .booking-date {
            color: var(--text-muted);
            font-size: 0.8rem;
            margin-bottom: 0.75rem;
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: var(--text-muted);
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            background: var(--hover);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--text-muted);
            font-size: 2rem;
        }

        .empty-state h5 {
            color: var(--text-primary);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .empty-state p {
            color: var(--text-secondary);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .course-detail-title {
                font-size: 2rem;
            }

            .course-detail-body {
                padding: 1.5rem;
            }

            .course-meta-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .schedule-body {
                padding: 1.5rem;
            }

            .schedule-meta {
                flex-direction: column;
                align-items: flex-start;
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
                    <li class="breadcrumb-item active">{{ $course->name }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <!-- Course Information -->
        <div class="col-md-8">
            <div class="course-detail-card">
                @if($course->image_path)
                    <img src="{{ asset('storage/' . $course->image_path) }}" class="course-hero-image"
                        alt="{{ $course->name }}">
                @else
                    <div class="course-hero-placeholder">
                        <i class="fa fa-book"></i>
                    </div>
                @endif

                <div class="course-detail-body">
                    <h2 class="course-detail-title">{{ $course->name }}</h2>

                    <div class="course-badges">
                        <span class="modern-badge badge-category">{{ $course->category->name }}</span>
                        <span class="modern-badge badge-duration">{{ $course->formatted_duration }}</span>
                        <span class="modern-badge badge-price">Rp.{{ number_format($course->price) }}</span>
                    </div>

                    <div class="course-meta-grid">
                        <div class="meta-item">
                            <h6>Instructor</h6>
                            <p>{{ $course->instructor_name }}</p>
                        </div>
                        <div class="meta-item">
                            <h6>Max Participants</h6>
                            <p>{{ $course->max_participants }} students</p>
                        </div>
                    </div>

                    <div class="course-description">
                        <h6>Course Description</h6>
                        <p>{{ $course->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Available Schedules -->
            @if($course->schedules->count() > 0)
                <div class="schedule-section">
                    <div class="schedule-header">
                        <h5 class="schedule-title">
                            <i class="fa fa-calendar"></i>
                            Available Sessions
                        </h5>
                    </div>
                    <div class="schedule-body">
                        <div class="row">
                            @foreach($course->schedules as $schedule)
                                <div class="col-md-6 mb-3">
                                    <div class="schedule-card {{ $schedule->isFull() ? 'full' : 'available' }}">
                                        <h6 class="schedule-date">
                                            {{ $schedule->start_datetime->format('M j, Y') }}
                                        </h6>
                                        <div class="schedule-time">
                                            <i class="fa fa-clock-o"></i>
                                            {{ $schedule->start_datetime->format('g:i A') }} -
                                            {{ $schedule->end_datetime->format('g:i A') }}
                                        </div>

                                        <div class="schedule-meta">
                                            <div class="slots-info">
                                                <small>Available Slots</small>
                                                <div class="slots-count {{ $schedule->isFull() ? 'full' : 'available' }}">
                                                    {{ $schedule->available_slots - $schedule->booked_slots }} /
                                                    {{ $schedule->available_slots }}
                                                </div>
                                            </div>
                                            <div class="action-button">
                                                @auth
                                                    @if(Auth::user()->isStudent())
                                                        @php
                                                            $userHasBooked = $userBookings->where('schedule_id', $schedule->id)->whereNotIn('status', ['cancelled'])->count() > 0;
                                                        @endphp

                                                        @if($userHasBooked)
                                                            <button class="modern-btn btn-secondary-modern btn-sm-modern" disabled>
                                                                <i class="fa fa-check"></i> Booked
                                                            </button>
                                                        @elseif($schedule->isFull())
                                                            <button class="modern-btn btn-danger-modern btn-sm-modern" disabled>
                                                                <i class="fa fa-times"></i> Full
                                                            </button>
                                                        @elseif($schedule->start_datetime <= now())
                                                            <button class="modern-btn btn-secondary-modern btn-sm-modern" disabled>
                                                                <i class="fa fa-clock-o"></i> Past
                                                            </button>
                                                        @else
                                                            <a href="{{ route('student.bookings.create', ['schedule_id' => $schedule->id]) }}"
                                                                class="modern-btn btn-primary-modern btn-sm-modern">
                                                                <i class="fa fa-calendar-plus-o"></i> Book Now
                                                            </a>
                                                        @endif
                                                    @endif
                                                @else
                                                    <a href="{{ route('login') }}" class="modern-btn btn-primary-modern btn-sm-modern">
                                                        <i class="fa fa-sign-in"></i> Login
                                                    </a>
                                                @endauth
                                            </div>
                                        </div>

                                        @if($schedule->notes)
                                            <div class="schedule-notes">
                                                <i class="fa fa-info-circle"></i>
                                                {{ $schedule->notes }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="schedule-section">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fa fa-calendar-o"></i>
                        </div>
                        <h5>No Sessions Available</h5>
                        <p>This course currently has no scheduled sessions.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-md-4">
            <!-- Quick Info -->
            <div class="sidebar-card">
                <div class="sidebar-header">
                    <h6 class="sidebar-title">
                        <i class="fa fa-info-circle"></i>
                        Course Overview
                    </h6>
                </div>
                <div class="sidebar-body">
                    <div class="price-highlight">Rp.{{ number_format($course->price) }}</div>
                    <div class="price-subtitle">per session</div>

                    <ul class="info-list">
                        <li>
                            <i class="fa fa-user"></i>
                            <div class="info-content">
                                <div class="info-label">Instructor</div>
                                <div class="info-value">{{ $course->instructor_name }}</div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-clock-o"></i>
                            <div class="info-content">
                                <div class="info-label">Duration</div>
                                <div class="info-value">{{ $course->formatted_duration }}</div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-users"></i>
                            <div class="info-content">
                                <div class="info-label">Max Participants</div>
                                <div class="info-value">{{ $course->max_participants }}</div>
                            </div>
                        </li>
                        <li>
                            <i class="fa fa-tag"></i>
                            <div class="info-content">
                                <div class="info-label">Category</div>
                                <div class="info-value">{{ $course->category->name }}</div>
                            </div>
                        </li>
                        @if($course->schedules->count() > 0)
                            <li>
                                <i class="fa fa-calendar"></i>
                                <div class="info-content">
                                    <div class="info-label">Sessions</div>
                                    <div class="info-value">{{ $course->schedules->count() }} available</div><br>
                                </div>
                            </li>
                        @endif
                    </ul>

                    @auth
                        @if(Auth::user()->isStudent())
                            @if($course->schedules->where('start_datetime', '>', now())->count() > 0)
                                <a href="{{ route('student.bookings.create', ['course_id' => $course->id]) }}"
                                    class="modern-btn btn-primary-modern btn-block-modern">
                                    <i class="fa fa-calendar-plus-o"></i> Book This Course
                                </a>
                            @endif
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="modern-btn btn-primary-modern btn-block-modern">
                            <i class="fa fa-sign-in"></i> Login to Book
                        </a>
                    @endauth
                </div>
            </div>

            <!-- User's Bookings for this Course -->
            @auth
                @if(Auth::user()->isStudent() && $userBookings->count() > 0)
                    <div class="sidebar-card">
                        <div class="sidebar-header">
                            <h6 class="sidebar-title">
                                <i class="fa fa-bookmark"></i>
                                Your Bookings
                            </h6>
                        </div>
                        <div class="sidebar-body">
                            @foreach($userBookings as $booking)
                                <div class="booking-item">
                                    <div class="booking-header">
                                        <div class="booking-code">{{ $booking->booking_code }}</div>
                                        @if($booking->status === 'approved')
                                            <span class="status-badge status-approved">{{ ucfirst($booking->status) }}</span>
                                        @elseif($booking->status === 'pending')
                                            <span class="status-badge status-pending">{{ ucfirst($booking->status) }}</span>
                                        @elseif($booking->status === 'cancelled')
                                            <span class="status-badge status-cancelled">{{ ucfirst($booking->status) }}</span>
                                        @else
                                            <span class="status-badge">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </div>
                                    <div class="booking-date">
                                        <i class="fa fa-calendar"></i>
                                        {{ $booking->schedule->start_datetime->format('M j, Y g:i A') }}
                                    </div>
                                    <a href="{{ route('student.bookings.show', $booking) }}"
                                        class="modern-btn btn-outline-modern btn-sm-modern">
                                        <i class="fa fa-eye"></i> View Details
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endauth

            <!-- Back to Courses -->
            <div class="sidebar-card">
                <div class="sidebar-body">
                    <a href="{{ route('student.courses.index') }}" class="modern-btn btn-outline-modern btn-block-modern">
                        <i class="fa fa-arrow-left"></i> Back to Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection