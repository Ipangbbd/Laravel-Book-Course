@extends('layouts.app')

@section('title', 'My Bookings - Xperium Academy')

@section('content')
    <style>
        /* Booking Index Styles */
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

        /* Filter Card */
        .filter-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .filter-header {
            background: var(--secondary-bg);
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
        }

        .filter-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .filter-body {
            padding: 2rem;
        }

        /* Form Styles */
        .form-label {
            color: var(--text-primary);
            font-weight: 500;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            background: var(--secondary-bg);
            border: 1px solid var(--border-color);
            color: var(--text-primary);
            border-radius: 10px;
            padding: 0.55rem 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: var(--secondary-bg);
            border-color: var(--accent);
            color: var(--text-primary);
            box-shadow: 0 0 0 2px rgba(255, 255, 255, 0.1);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-control option {
            background: var(--secondary-bg);
            color: var(--text-primary);
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

        .btn-success-modern {
            background: var(--success);
            color: var(--primary-bg);
        }

        .btn-danger-modern {
            background: var(--error);
            color: var(--primary-bg);
        }

        .btn-sm-modern {
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        /* Action Bar */
        .action-bar {
            margin-bottom: 2rem;
        }

        /* Booking Cards */
        .bookings-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .booking-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .booking-card:hover {
            transform: translateY(-4px);
            border-color: var(--hover);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .booking-header {
            background: var(--secondary-bg);
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .booking-code {
            font-weight: 600;
            color: var(--text-primary);
            font-family: monospace;
            font-size: 0.875rem;
        }

        .booking-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .course-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .course-category {
            color: var(--text-muted);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .booking-details {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            margin-bottom: 1rem;
            flex: 1;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-weight: 600;
        }

        .detail-value {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
        }

        .detail-value.primary {
            color: var(--text-primary);
            font-weight: 600;
        }

        .booking-notes {
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
        }

        .notes-text {
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-style: italic;
        }

        .booking-footer {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border-color);
            background: var(--secondary-bg);
            margin-top: auto;
        }

        .button-group {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .button-group .modern-btn {
            flex: 1;
            min-width: 80px;
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

        .status-completed {
            background: rgba(59, 130, 246, 0.15);
            color: var(--info);
            border: 1px solid rgba(59, 130, 246, 0.3);
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

        /* Empty State */
        .empty-state {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 16px;
            padding: 4rem 2rem;
            text-align: center;
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

        /* Pagination */
        .pagination {
            justify-content: center;
            margin-top: 2rem;
        }

        .page-link {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            color: var(--text-secondary);
            padding: 0.75rem 1rem;
            margin: 0 0.125rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background: var(--hover);
            border-color: var(--hover);
            color: var(--text-primary);
        }

        .page-item.active .page-link {
            background: var(--accent);
            border-color: var(--accent);
            color: var(--primary-bg);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .page-title {
                font-size: 2rem;
            }

            .filter-body {
                padding: 1.5rem;
            }

            .bookings-grid {
                grid-template-columns: 1fr;
            }

            .button-group {
                flex-direction: column;
            }

            .button-group .modern-btn {
                flex: none;
            }
        }
    </style>

    <div class="page-header">
        <h2 class="page-title">My Bookings</h2>
        <p class="page-subtitle">Manage your course bookings and track their status</p>
    </div>

    <!-- Filter Form -->
    <div class="filter-card">
        <div class="filter-header">
            <h5 class="filter-title">
                <i class="fa fa-filter"></i>
                Filter Bookings
            </h5>
        </div>
        <div class="filter-body">
            <form method="GET" action="{{ route('student.bookings.index') }}">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                            </option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed
                            </option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="booking_code" class="form-label">Booking Code</label>
                        <input type="text" class="form-control" id="booking_code" name="booking_code"
                            value="{{ request('booking_code') }}" placeholder="Search by booking code">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="course_name" class="form-label">Course Name</label>
                        <input type="text" class="form-control" id="course_name" name="course_name"
                            value="{{ request('course_name') }}" placeholder="Search by course name">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="modern-btn btn-primary-modern">
                                <i class="fa fa-search"></i> Filter
                            </button>
                            <a href="{{ route('student.bookings.index') }}" class="modern-btn btn-outline-modern">
                                Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="action-bar">
        <a href="{{ route('student.courses.index') }}" class="modern-btn btn-primary-modern">
            <i class="fa fa-plus"></i> Book New Course
        </a>
    </div>

    @if($bookings->count() > 0)
        <!-- Bookings List -->
        <div class="bookings-grid">
            @foreach($bookings as $booking)
                <div class="booking-card">
                    <div class="booking-header">
                        <div class="booking-code">{{ $booking->booking_code }}</div>
                        @if($booking->status === 'approved')
                            <span class="status-badge status-approved">{{ ucfirst($booking->status) }}</span>
                        @elseif($booking->status === 'pending')
                            <span class="status-badge status-pending">{{ ucfirst($booking->status) }}</span>
                        @elseif($booking->status === 'cancelled')
                            <span class="status-badge status-cancelled">{{ ucfirst($booking->status) }}</span>
                        @elseif($booking->status === 'completed')
                            <span class="status-badge status-completed">{{ ucfirst($booking->status) }}</span>
                        @else
                            <span class="status-badge">{{ ucfirst($booking->status) }}</span>
                        @endif
                    </div>

                    <div class="booking-body">
                        <h6 class="course-title">{{ $booking->schedule->course->name }}</h6>
                        <p class="course-category">{{ $booking->schedule->course->category->name }}</p>

                        <div class="booking-details">
                            <div class="detail-item">
                                <div class="detail-label">Schedule</div>
                                <div class="detail-value primary">{{ $booking->schedule->start_datetime->format('M j, Y') }}</div>
                                <div class="detail-value">{{ $booking->schedule->start_datetime->format('g:i A') }} -
                                    {{ $booking->schedule->end_datetime->format('g:i A') }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Booked On</div>
                                <div class="detail-value">{{ $booking->booked_at->format('M j, Y') }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Instructor</div>
                                <div class="detail-value">{{ $booking->schedule->course->instructor_name }}</div>
                            </div>

                            <div class="detail-item">
                                <div class="detail-label">Payment Status</div>
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
                            </div>
                        </div>

                        @if($booking->notes)
                            <div class="booking-notes">
                                <div class="detail-label">Notes</div>
                                <p class="notes-text">{{ Str::limit($booking->notes, 80) }}</p>
                            </div>
                        @endif
                    </div>

                    <div class="booking-footer">
                        <div class="button-group">
                            <a href="{{ route('student.bookings.show', $booking) }}"
                                class="modern-btn btn-outline-modern btn-sm-modern">
                                <i class="fa fa-eye"></i> View
                            </a>

                            @if(!$booking->payment)
                                <a href="{{ route('student.payments.create', ['booking_id' => $booking->id]) }}"
                                    class="modern-btn btn-success-modern btn-sm-modern">
                                    <i class="fa fa-credit-card"></i> Pay
                                </a>
                            @endif

                            @if($booking->canBeCancelled())
                                <button type="button" class="modern-btn btn-danger-modern btn-sm-modern" data-toggle="modal"
                                    data-target="#cancelModal{{ $booking->id }}">
                                    <i class="fa fa-times"></i> Cancel
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Cancel Modal -->
                @if($booking->canBeCancelled())
                    <div class="modal fade" id="cancelModal{{ $booking->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form method="POST" action="{{ route('student.bookings.cancel', $booking) }}">
                                    @csrf
                                    @method('PATCH')

                                    <div class="modal-header">
                                        <h5 class="modal-title">Cancel Booking</h5>
                                        <button type="button" class="close" data-dismiss="modal">
                                            <span>&times;</span>
                                        </button>
                                    </div>

                                    <div class="modal-body">
                                        <p>Are you sure you want to cancel your booking for
                                            <strong>{{ $booking->schedule->course->name }}</strong>?
                                        </p>

                                        <div class="form-group">
                                            <label for="cancellation_reason{{ $booking->id }}" class="form-label">Reason for
                                                cancellation:</label>
                                            <textarea class="form-control" id="cancellation_reason{{ $booking->id }}"
                                                name="cancellation_reason" rows="3" required
                                                placeholder="Please provide a reason for cancelling this booking"></textarea>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="modern-btn btn-outline-modern" data-dismiss="modal">
                                            Keep Booking
                                        </button>
                                        <button type="submit" class="modern-btn btn-danger-modern">
                                            Cancel Booking
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="row">
            <div class="col-12">
                {{ $bookings->links() }}
            </div>
        </div>
    @else
        <!-- No Bookings -->
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fa fa-calendar-o"></i>
            </div>
            <h5>No Bookings Found</h5>
            @if(request()->hasAny(['status', 'booking_code', 'course_name']))
                <p>No bookings match your search criteria. Try adjusting your filters.</p>
                <a href="{{ route('student.bookings.index') }}" class="modern-btn btn-primary-modern">
                    Clear Filters
                </a>
            @else
                <p>You haven't made any bookings yet. Start by browsing our available courses.</p>
                <a href="{{ route('student.courses.index') }}" class="modern-btn btn-primary-modern">
                    Browse Courses
                </a>
            @endif
        </div>
    @endif
@endsection