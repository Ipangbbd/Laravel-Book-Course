<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Get statistics for dashboard
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 'active')->count();
        $totalCategories = Category::count();
        $totalUsers = User::count();
        $totalStudents = User::where('role', 'student')->count();
        $totalBookings = Booking::count();
        $activeBookings = Booking::whereIn('status', ['approved', 'completed'])->count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $pendingPayments = Payment::where('status', 'pending')->count();
        $verifiedPayments = Payment::where('status', 'verified')->count();
        $totalPayments = Payment::count();
        $totalSchedules = Schedule::count();
        $scheduledSessions = Schedule::where('status', 'scheduled')->count();

        $stats = [
            'total_courses' => $totalCourses,
            'active_courses' => $activeCourses,
            'total_categories' => $totalCategories,
            'total_users' => $totalUsers,
            'total_students' => $totalStudents,
            'total_bookings' => $totalBookings,
            'active_bookings' => $activeBookings,
            'pending_bookings' => $pendingBookings,
            'pending_payments' => $pendingPayments,
            'verified_payments' => $verifiedPayments,
            'total_payments' => $totalPayments,
            'total_schedules' => $totalSchedules,
            'scheduled_sessions' => $scheduledSessions,
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
