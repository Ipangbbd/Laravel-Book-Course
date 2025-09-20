@extends('layouts.app')

@section('title', 'Student Dashboard - Xperium Academy')

@section('content')
<style>
    /* Dashboard Styles */
    .dashboard-hero {
        background: linear-gradient(135deg, var(--card-bg) 0%, var(--secondary-bg) 100%);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0%, transparent 100%);
        pointer-events: none;
    }

    .hero-content {
        position: relative;
        z-index: 1;
    }

    .hero-title {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 1rem;
        letter-spacing: -0.025em;
    }

    .hero-subtitle {
        font-size: 1.25rem;
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
        line-height: 1.6;
    }

    .hero-divider {
        height: 2px;
        background: linear-gradient(90deg, var(--accent) 0%, transparent 100%);
        border: none;
        margin: 1.5rem 0;
    }

    .hero-description {
        color: var(--text-secondary);
        font-size: 1rem;
        margin-bottom: 2rem;
    }

    .hero-btn {
        background: var(--accent);
        color: var(--primary-bg);
        border: none;
        border-radius: 12px;
        padding: 1rem 2rem;
        font-size: 1rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .hero-btn:hover {
        background: var(--text-secondary);
        color: var(--primary-bg);
        text-decoration: none;
        transform: translateY(-2px);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    /* Statistics Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 1.5rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-4px);
        border-color: var(--hover);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--accent);
    }

    .stat-card.primary::before {
        background: var(--info);
    }

    .stat-card.success::before {
        background: var(--success);
    }

    .stat-card.warning::before {
        background: var(--warning);
    }

    .stat-card.info::before {
        background: var(--accent);
    }

    .stat-content {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-primary);
        margin-bottom: 0.5rem;
        display: block;
    }

    .stat-label {
        color: var(--text-secondary);
        font-size: 0.875rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin: 0;
    }

    /* Action Cards */
    .actions-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .action-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .action-card:hover {
        transform: translateY(-4px);
        border-color: var(--hover);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .action-icon {
        width: 80px;
        height: 80px;
        background: var(--secondary-bg);
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        font-size: 2rem;
        color: var(--accent);
        transition: all 0.3s ease;
    }

    .action-card:hover .action-icon {
        background: var(--accent);
        color: var(--primary-bg);
        transform: scale(1.1);
    }

    .action-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .action-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1.5rem;
        flex: 1;
    }

    .action-btn {
        background: var(--accent);
        color: var(--primary-bg);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
    }

    .action-btn:hover {
        background: var(--text-secondary);
        color: var(--primary-bg);
        text-decoration: none;
        transform: translateY(-2px);
    }

    .action-btn.btn-success {
        background: var(--success);
    }

    .action-btn.btn-warning {
        background: var(--warning);
    }

    .action-btn.btn-info {
        background: var(--info);
    }

    /* Section Cards */
    .section-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .section-header {
        background: var(--secondary-bg);
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-color);
    }

    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--text-primary);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-body {
        padding: 2rem;
    }

    /* Table Styles */
    .modern-table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    .modern-table th {
        background: var(--secondary-bg);
        color: var(--text-primary);
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 1rem;
        border-bottom: 2px solid var(--border-color);
        text-align: left;
    }

    .modern-table td {
        padding: 1rem;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-secondary);
        vertical-align: top;
    }

    .modern-table tr:hover {
        background: var(--hover);
    }

    .course-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .course-name {
        font-weight: 600;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .course-code {
        font-size: 0.75rem;
        color: var(--text-muted);
        font-family: monospace;
    }

    .schedule-info {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .schedule-date {
        font-weight: 500;
        color: var(--text-primary);
        font-size: 0.875rem;
    }

    .schedule-time {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* Status Badges */
    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 8px;
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

    .status-verified {
        background: rgba(16, 185, 129, 0.15);
        color: var(--success);
        border: 1px solid rgba(16, 185, 129, 0.3);
    }

    .status-not-paid {
        background: rgba(156, 163, 175, 0.15);
        color: var(--text-muted);
        border: 1px solid rgba(156, 163, 175, 0.3);
    }

    .status-rejected {
        background: rgba(239, 68, 68, 0.15);
        color: var(--error);
        border: 1px solid rgba(239, 68, 68, 0.3);
    }

    /* Upcoming Classes Cards */
    .upcoming-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .upcoming-card {
        background: var(--secondary-bg);
        border: 1px solid var(--border-color);
        border-left: 4px solid var(--info);
        border-radius: 12px;
        padding: 1.5rem;
        transition: all 0.3s ease;
    }

    .upcoming-card:hover {
        transform: translateY(-2px);
        border-left-color: var(--accent);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .upcoming-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .upcoming-details {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .upcoming-detail {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: var(--text-secondary);
        font-size: 0.875rem;
    }

    .upcoming-detail i {
        width: 16px;
        color: var(--text-muted);
    }

    /* Course Cards */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }

    .course-card {
        background: var(--card-bg);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .course-card:hover {
        transform: translateY(-4px);
        border-color: var(--hover);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .course-image {
        height: 180px;
        object-fit: cover;
        width: 100%;
    }

    .course-image-placeholder {
        height: 180px;
        background: var(--hover);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        font-size: 2.5rem;
    }

    .course-body {
        padding: 1.5rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .course-title {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-primary);
        margin-bottom: 0.75rem;
    }

    .course-description {
        color: var(--text-secondary);
        font-size: 0.875rem;
        line-height: 1.5;
        margin-bottom: 1rem;
        flex: 1;
    }

    .course-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .course-price {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--success);
    }

    .course-category {
        padding: 0.25rem 0.75rem;
        background: rgba(156, 163, 175, 0.15);
        color: var(--text-secondary);
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .course-footer {
        padding: 1.5rem;
        border-top: 1px solid var(--border-color);
        margin-top: auto;
    }

    .course-btn {
        background: var(--accent);
        color: var(--primary-bg);
        border: none;
        border-radius: 10px;
        padding: 0.75rem 1.5rem;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
    }

    .course-btn:hover {
        background: var(--text-secondary);
        color: var(--primary-bg);
        text-decoration: none;
        transform: translateY(-2px);
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

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 3rem 2rem;
        color: var(--text-muted);
    }

    .empty-state-icon {
        width: 100px;
        height: 100px;
        background: var(--hover);
        border-radius: 25px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1.5rem;
        color: var(--text-muted);
        font-size: 3rem;
    }

    .empty-state h5 {
        color: var(--text-primary);
        font-weight: 600;
        margin-bottom: 0.75rem;
    }

    .empty-state p {
        color: var(--text-secondary);
        margin-bottom: 1.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-title {
            font-size: 2rem;
        }
        
        .stats-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        }
        
        .actions-grid {
            grid-template-columns: 1fr;
        }
        
        .section-body {
            padding: 1.5rem;
        }
        
        .modern-table {
            font-size: 0.875rem;
        }
        
        .modern-table th,
        .modern-table td {
            padding: 0.75rem;
        }
    }
</style>

<div class="dashboard-hero">
    <div class="hero-content">
        <h1 class="hero-title">Welcome back, {{ Auth::user()->name }}!</h1>
        <p class="hero-subtitle">Discover amazing courses and continue your learning journey today.</p>
        <hr class="hero-divider">
        <p class="hero-description">Browse through our extensive course catalog and book your favorite sessions to enhance your skills.</p>
        <a href="{{ route('student.courses.index') }}" class="hero-btn">
            <i class="fa fa-compass"></i>
            Explore Courses
        </a>
    </div>
</div>

<!-- Quick Statistics -->
<div class="stats-grid">
    <div class="stat-card primary">
        <div class="stat-content">
            <span class="stat-number">{{ $stats['total_bookings'] }}</span>
            <p class="stat-label">Total Bookings</p>
        </div>
    </div>
    <div class="stat-card success">
        <div class="stat-content">
            <span class="stat-number">{{ $stats['completed_courses'] }}</span>
            <p class="stat-label">Completed</p>
        </div>
    </div>
    <div class="stat-card warning">
        <div class="stat-content">
            <span class="stat-number">{{ $stats['active_bookings'] }}</span>
            <p class="stat-label">Active Bookings</p>
        </div>
    </div>
    <div class="stat-card info">
        <div class="stat-content">
            <span class="stat-number">{{ $stats['pending_payments'] }}</span>
            <p class="stat-label">Pending Payments</p>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="actions-grid">

    <div class="action-card">
        <div class="action-icon">
            <i class="fa fa-user"></i>
        </div>
        <h5 class="action-title">Profile</h5>
        <p class="action-description">Update your profile information and account preferences.</p>
        <a href="{{ route('student.profile.show') }}" class="action-btn btn-info">
            <i class="fa fa-edit"></i>
            View Profile
        </a>
    </div>
    
    <div class="action-card">
        <div class="action-icon">
            <i class="fa fa-calendar"></i>
        </div>
        <h5 class="action-title">My Bookings</h5>
        <p class="action-description">View and manage your course bookings, schedules, and attendance.</p>
        <a href="{{ route('student.bookings.index') }}" class="action-btn btn-success">
            <i class="fa fa-eye"></i>
            View Bookings
        </a>
    </div>

    <div class="action-card">
        <div class="action-icon">
            <i class="fa fa-credit-card"></i>
        </div>
        <h5 class="action-title">Payments</h5>
        <p class="action-description">Manage your course payments and view transaction history.</p>
        <a href="{{ route('student.payments.index') }}" class="action-btn btn-warning">
            <i class="fa fa-money"></i>
            View Payments
        </a>
    </div>
    
</div>

<div class="action-card">
    <div class="action-icon">
        <i class="fa fa-search"></i>
    </div>
    <h5 class="action-title">Browse Courses</h5>
    <p class="action-description">Discover new courses and learning opportunities tailored to your interests.</p>
    <a href="{{ route('student.courses.index') }}" class="action-btn">
        <i class="fa fa-arrow-right"></i>
        Browse Now
    </a>
</div>

<!-- Recent Bookings -->
@if($recentBookings->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <h5 class="section-title">
                <i class="fa fa-clock-o"></i>
                Recent Bookings
            </h5>
        </div>
        <div class="section-body">
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>Course</th>
                            <th>Schedule</th>
                            <th>Status</th>
                            <th>Booked Date</th>
                            <th>Payment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentBookings as $booking)
                            <tr>
                                <td>
                                    <div class="course-info">
                                        <div class="course-name">{{ $booking->schedule->course->name }}</div>
                                        <div class="course-code">{{ $booking->booking_code }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="schedule-info">
                                        <div class="schedule-date">{{ $booking->schedule->start_datetime->format('M j, Y') }}</div>
                                        <div class="schedule-time">{{ $booking->schedule->start_datetime->format('g:i A') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @if($booking->status === 'approved')
                                        <span class="status-badge status-approved">{{ ucfirst($booking->status) }}</span>
                                    @elseif($booking->status === 'pending')
                                        <span class="status-badge status-pending">{{ ucfirst($booking->status) }}</span>
                                    @elseif($booking->status === 'cancelled')
                                        <span class="status-badge status-cancelled">{{ ucfirst($booking->status) }}</span>
                                    @else
                                        <span class="status-badge">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $booking->booked_at->format('M j, Y') }}</td>
                                <td>
                                    @if($booking->payment)
                                        @if($booking->payment->status === 'verified')
                                            <span class="status-badge status-verified">Verified</span>
                                        @elseif($booking->payment->status === 'pending')
                                            <span class="status-badge status-pending">Pending</span>
                                        @else
                                            <span class="status-badge status-rejected">{{ ucfirst($booking->payment->status) }}</span>
                                        @endif
                                    @else
                                        <span class="status-badge status-not-paid">Not Paid</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('student.bookings.index') }}" class="modern-btn btn-outline-modern">
                    <i class="fa fa-eye"></i>
                    View All Bookings
                </a>
            </div>
        </div>
    </div>
@endif

<!-- Upcoming Schedules -->
@if($upcomingSchedules->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <h5 class="section-title">
                <i class="fa fa-calendar-o"></i>
                Upcoming Classes
            </h5>
        </div>
        <div class="section-body">
            <div class="upcoming-grid">
                @foreach($upcomingSchedules as $booking)
                    <div class="upcoming-card">
                        <h6 class="upcoming-title">{{ $booking->schedule->course->name }}</h6>
                        <div class="upcoming-details">
                            <div class="upcoming-detail">
                                <i class="fa fa-calendar"></i>
                                <span>{{ $booking->schedule->start_datetime->format('M j, Y') }}</span>
                            </div>
                            <div class="upcoming-detail">
                                <i class="fa fa-clock-o"></i>
                                <span>{{ $booking->schedule->start_datetime->format('g:i A') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('student.bookings.show', $booking) }}" class="modern-btn btn-outline-modern">
                            <i class="fa fa-eye"></i>
                            View Details
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endif

<!-- Featured Courses -->
@if($featuredCourses->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <h5 class="section-title">
                <i class="fa fa-star"></i>
                Recommended Courses
            </h5>
        </div>
        <div class="section-body">
            <div class="courses-grid">
                @foreach($featuredCourses as $course)
                    <div class="course-card">
                        @if($course->image_path)
                            <img src="{{ asset('storage/' . $course->image_path) }}" class="course-image" alt="{{ $course->name }}">
                        @else
                            <div class="course-image-placeholder">
                                <i class="fa fa-book"></i>
                            </div>
                        @endif
                        <div class="course-body">
                            <h6 class="course-title">{{ $course->name }}</h6>
                            <p class="course-description">{{ Str::limit($course->description, 80) }}</p>
                            <div class="course-meta">
                                <div class="course-price">Rp.{{ number_format($course->price, 2) }}</div>
                                <div class="course-category">{{ $course->category->name }}</div>
                            </div>
                        </div>
                        <div class="course-footer">
                            <a href="{{ route('student.courses.show', $course) }}" class="course-btn">
                                <i class="fa fa-eye"></i>
                                View Course
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('student.courses.index') }}" class="modern-btn btn-outline-modern">
                    <i class="fa fa-compass"></i>
                    Browse All Courses
                </a>
            </div>
        </div>
    </div>
@else
    <div class="section-card">
        <div class="section-header">
            <h5 class="section-title">
                <i class="fa fa-rocket"></i>
                Get Started
            </h5>
        </div>
        <div class="section-body">
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fa fa-graduation-cap"></i>
                </div>
                <h5>Start Your Learning Journey</h5>
                <p>Browse our course catalog to find the perfect learning opportunity for you.</p>
                <a href="{{ route('student.courses.index') }}" class="modern-btn">
                    <i class="fa fa-compass"></i>
                    Explore Courses
                </a>
            </div>
        </div>
    </div>
@endif
@endsection