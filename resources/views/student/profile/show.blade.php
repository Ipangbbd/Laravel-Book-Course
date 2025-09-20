@extends('layouts.app')

@section('title', 'My Profile - Xperium Academy')

@section('content')
    <style>
        /* Profile Show Styles */
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

        /* Profile Cards */
        .profile-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .profile-header {
            background: linear-gradient(135deg, var(--secondary-bg) 0%, var(--hover) 100%);
            padding: 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .profile-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(255, 255, 255, 0.05) 0%, transparent 100%);
            pointer-events: none;
        }

        .profile-content {
            position: relative;
            z-index: 1;
        }

        .avatar-container {
            margin-bottom: 1.5rem;
        }

        .avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--accent);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .avatar-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--accent);
            color: var(--primary-bg);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            font-weight: 700;
            margin: 0 auto;
            border: 4px solid var(--accent);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        .profile-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .profile-email {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .profile-role {
            background: var(--accent);
            color: var(--primary-bg);
            padding: 0.5rem 1.5rem;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .member-since {
            color: var(--text-muted);
            font-size: 0.875rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
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

        .btn-sm-modern {
            padding: 0.5rem 1rem;
            font-size: 0.75rem;
        }

        /* Stats Card */
        .stats-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        .stats-card:hover {
            transform: translateY(-2px);
            border-color: var(--hover);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .stats-header {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .stats-title {
            font-size: 1rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: var(--secondary-bg);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            background: var(--hover);
            transform: translateY(-2px);
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            display: block;
        }

        .stat-number.primary {
            color: var(--accent);
        }

        .stat-number.success {
            color: var(--success);
        }

        .stat-number.warning {
            color: var(--warning);
        }

        .stat-number.info {
            color: var(--info);
        }

        .stat-label {
            color: var(--text-muted);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        /* Details Card */
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

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .info-value {
            color: var(--text-primary);
            font-size: 1rem;
            font-weight: 500;
        }

        .info-badge {
            background: var(--accent);
            color: var(--primary-bg);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            display: inline-block;
            width: fit-content;
        }

        /* Activity Table */
        /* Activity Table */
        .activity-table-container {
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .activity-table {
            width: 100%;
            background: var(--card-bg);
            display: flex;
            flex-direction: column;
        }

        .activity-header {
            background: var(--secondary-bg);
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr 1fr 80px;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .activity-header-item {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-primary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .activity-row {
            display: grid;
            grid-template-columns: 2fr 1.5fr 1fr 1fr 80px;
            gap: 1rem;
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.2s ease;
        }

        .activity-row:hover {
            background: var(--hover);
        }

        .activity-row:last-child {
            border-bottom: none;
        }

        .activity-cell {
            display: flex;
            align-items: center;
        }

        .activity-date {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .table-responsive {
            background: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
            background: var(--card-bg);
        }

        .modern-table th {
            background: var(--secondary-bg);
            color: var(--text-primary);
            font-weight: 600;
            padding: 1rem 1.5rem;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .modern-table td {
            padding: 1rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            color: var(--text-secondary);
            vertical-align: middle;
        }

        .modern-table tr:hover {
            background: var(--hover);
        }

        .modern-table tr:last-child td {
            border-bottom: none;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            font-size: 0.75rem;
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

        .status-badge.default {
            background: var(--secondary-bg);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
        }

        /* Empty State */
        .empty-state {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 4rem 2rem;
            text-align: center;
        }

        .empty-icon {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1.5rem;
        }

        .empty-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .empty-description {
            color: var(--text-secondary);
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        /* Course Info */
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

        .booking-code {
            color: var(--text-muted);
            font-size: 0.75rem;
            font-family: monospace;
        }

        .schedule-info {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .schedule-date {
            color: var(--text-secondary);
            font-size: 0.875rem;
        }

        .schedule-time {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .info-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .modern-table {
                font-size: 0.8rem;
            }

            .modern-table th,
            .modern-table td {
                padding: 0.75rem 0.5rem;
            }

            .profile-header {
                padding: 1.5rem;
            }

            .info-body {
                padding: 1.5rem;
            }
        }
    </style>
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">My Profile</h1>
        <p class="page-subtitle">Manage your personal information and account settings</p>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <!-- Profile Information -->
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-content">
                        <div class="avatar-container">
                            @if($user->avatar_path)
                                <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="{{ $user->name }}" class="avatar">
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        <h2 class="profile-name">{{ $user->name }}</h2>
                        <p class="profile-email">{{ $user->email }}</p>
                        <span class="profile-role">{{ ucfirst($user->role) }}</span>
                        <div class="member-since">
                            <i class="fa fa-calendar"></i>
                            <span>Member since {{ $user->created_at->format('F Y') }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body-modern">
                    <a href="{{ route('student.profile.edit') }}" class="modern-btn btn-primary-modern"
                        style="width: 100%;">
                        <i class="fa fa-edit"></i> Edit Profile
                    </a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="stats-card p-3">
                <div class="stats-header">
                    <h3 class="stats-title"><i class="fa fa-chart-bar"></i> Quick Stats</h3>
                </div>
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-number primary">{{ $stats['total_bookings'] }}</div>
                        <div class="stat-label">Total Bookings</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number success">{{ $stats['completed_courses'] }}</div>
                        <div class="stat-label">Completed</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number warning">{{ $stats['active_bookings'] }}</div>
                        <div class="stat-label">Active</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number info">{{ $stats['verified_payments'] }}</div>
                        <div class="stat-label">Paid</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <!-- Profile Information -->
            <div class="details-card">
                <div class="card-header-modern">
                    <h3 class="card-title-modern"><i class="fa fa-user"></i> Profile Information</h3>
                </div>
                <div class="card-body-modern">
                    <div class="info-grid">
                        <div class="info-item">
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email Address</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Account Type</div>
                            <div class="info-value">
                                <span class="status-badge approved">{{ ucfirst($user->role) }}</span>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Member Since</div>
                            <div class="info-value">{{ $user->created_at->format('F j, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            @if($recentBookings->count() > 0)
                <div class="details-card">
                    <div class="card-header-modern">
                        <h3 class="card-title-modern"><i class="fa fa-history"></i> Recent Bookings</h3>
                        <a href="{{ route('student.bookings.index') }}" class="modern-btn btn-outline-modern btn-sm-modern">View
                            All</a>
                    </div>
                    <div class="card-body-modern">
                        <div class="table-responsive">
                            <table class="modern-table">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Schedule</th>
                                        <th>Status</th>
                                        <th>Payment</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>
                                                <div class="course-info">
                                                    <div class="course-name">{{ $booking->schedule->course->name }}</div>
                                                    <div class="booking-code">{{ $booking->booking_code }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="schedule-info">
                                                    <div class="schedule-date">
                                                        {{ $booking->schedule->start_datetime->format('M j, Y') }}</div>
                                                    <div class="schedule-time">
                                                        {{ $booking->schedule->start_datetime->format('g:i A') }}</div>
                                                </div>
                                            </td>
                                            <td>
                                                @if($booking->status === 'approved')
                                                    <span class="status-badge approved">{{ ucfirst($booking->status) }}</span>
                                                @elseif($booking->status === 'pending')
                                                    <span class="status-badge pending">{{ ucfirst($booking->status) }}</span>
                                                @elseif($booking->status === 'cancelled')
                                                    <span class="status-badge cancelled">{{ ucfirst($booking->status) }}</span>
                                                @else
                                                    <span class="status-badge default">{{ ucfirst($booking->status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($booking->payment)
                                                    @if($booking->payment->status === 'verified')
                                                        <span class="status-badge verified">
                                                            <i class="fa fa-check"></i> Verified
                                                        </span>
                                                    @elseif($booking->payment->status === 'pending')
                                                        <span class="status-badge pending">
                                                            <i class="fa fa-clock-o"></i> Pending
                                                        </span>
                                                    @else
                                                        <span class="status-badge rejected">
                                                            <i class="fa fa-times"></i> {{ ucfirst($booking->payment->status) }}
                                                        </span>
                                                    @endif
                                                @else
                                                    <span class="status-badge not-paid">
                                                        <i class="fa fa-credit-card"></i> Not Paid
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('student.bookings.show', $booking) }}"
                                                    class="modern-btn btn-outline-modern btn-sm-modern">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @else
                <!-- No Activity -->
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fa fa-calendar"></i>
                    </div>
                    <h3 class="empty-title">No Bookings Yet</h3>
                    <p class="empty-description">You haven't made any course bookings yet. Start exploring our amazing courses!
                    </p>
                    <a href="{{ route('student.courses.index') }}" class="modern-btn btn-primary-modern">
                        <i class="fa fa-search"></i> Browse Courses
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection