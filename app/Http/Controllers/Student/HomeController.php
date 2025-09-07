<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Display the student dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        // Dashboard statistics
        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'active_bookings' => $user->bookings()
                ->whereIn('status', ['pending', 'approved'])
                ->count(),
            'completed_courses' => $user->bookings()
                ->where('status', 'completed')
                ->count(),
            'pending_payments' => $user->bookings()
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'pending');
                })
                ->count(),
        ];

        // Recent bookings
        $recentBookings = $user->bookings()
            ->with(['schedule.course', 'payment'])
            ->latest('booked_at')
            ->limit(5)
            ->get();

        // Upcoming schedules (for approved bookings)
        $upcomingSchedules = $user->bookings()
            ->where('status', 'approved')
            ->with(['schedule.course'])
            ->whereHas('schedule', function ($q) {
                $q->where('start_datetime', '>', now())
                    ->orderBy('start_datetime');
            })
            ->limit(3)
            ->get();

        // Featured courses (active courses that user hasn't booked)
        $featuredCourses = Course::active()
            ->with('category')
            ->whereDoesntHave('schedules.bookings', function ($q) use ($user) {
                $q->where('user_id', $user->id)
                    ->where('status', '!=', 'cancelled');
            })
            ->limit(4)
            ->get();

        return view('student.dashboard', compact(
            'stats',
            'recentBookings',
            'upcomingSchedules',
            'featuredCourses'
        ));
    }

    /**
     * Get dashboard statistics.
     */
    public function getStats()
    {
        $user = auth()->user();

        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'active_bookings' => $user->bookings()
                ->whereIn('status', ['pending', 'approved'])
                ->count(),
            'completed_courses' => $user->bookings()
                ->where('status', 'completed')
                ->count(),
            'cancelled_bookings' => $user->bookings()
                ->where('status', 'cancelled')
                ->count(),
            'total_payments' => $user->bookings()
                ->whereHas('payment')
                ->count(),
            'verified_payments' => $user->bookings()
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'verified');
                })
                ->count(),
            'pending_payments' => $user->bookings()
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'pending');
                })
                ->count(),
        ];

        return view('student.dashboard.stats', compact('stats'));
    }

    /**
     * Get recent activity.
     */
    public function getRecentActivity(Request $request)
    {
        $user = auth()->user();
        $limit = $request->get('limit', 10);

        $activities = collect();

        // Recent bookings
        $recentBookings = $user->bookings()
            ->with(['schedule.course'])
            ->latest('booked_at')
            ->limit($limit)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'booking',
                    'message' => 'Booked course: ' . $booking->schedule->course->name,
                    'date' => $booking->booked_at,
                    'status' => $booking->status,
                    'url' => route('student.bookings.show', $booking),
                    'icon' => 'calendar'
                ];
            });

        // Recent payments
        $recentPayments = $user->bookings()
            ->whereHas('payment')
            ->with(['payment', 'schedule.course'])
            ->latest('created_at')
            ->limit($limit)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'payment',
                    'message' => 'Payment for: ' . $booking->schedule->course->name,
                    'date' => $booking->payment->paid_at,
                    'status' => $booking->payment->status,
                    'url' => route('student.payments.show', $booking->payment),
                    'icon' => 'credit-card'
                ];
            });

        $activities = $recentBookings->concat($recentPayments)
            ->sortByDesc('date')
            ->take($limit)
            ->values();

        return view('student.dashboard.activity', compact('activities', 'limit'));
    }
}