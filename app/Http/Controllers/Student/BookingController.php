<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Display a listing of the user's bookings.
     */
    public function index(Request $request)
    {
        $query = auth()->user()
            ->bookings()
            ->with(['schedule.course.category', 'payment']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by booking code
        if ($request->filled('booking_code')) {
            $query->where('booking_code', 'like', '%' . $request->booking_code . '%');
        }

        // Filter by course name
        if ($request->filled('course_name')) {
            $query->whereHas('schedule.course', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->course_name . '%');
            });
        }

        // Sort by most recent bookings first
        $bookings = $query->latest('booked_at')->paginate(10)->withQueryString();

        return view('student.bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create(Request $request)
    {
        $scheduleId = $request->get('schedule_id');
        $schedule = null;

        if ($scheduleId) {
            $schedule = Schedule::with(['course.category'])
                ->available()
                ->find($scheduleId);

            if (!$schedule) {
                return redirect()->route('student.courses.index')
                    ->with('error', 'Schedule not found or not available.');
            }
        }

        // Get all available schedules for dropdown
        $availableSchedules = Schedule::with(['course'])
            ->available()
            ->orderBy('start_datetime')
            ->get()
            ->groupBy('course.name');

        return view('student.bookings.create', compact('schedule', 'availableSchedules'));
    }

    /**
     * Store a newly created booking in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'schedule_id' => 'required|exists:schedules,id',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            DB::beginTransaction();

            // Get the schedule and verify it's available
            $schedule = Schedule::with('course')->find($validated['schedule_id']);

            // Validation checks
            if ($schedule->status !== 'scheduled') {
                return back()->withErrors([
                    'schedule_id' => 'This schedule is not available for booking.'
                ])->withInput();
            }

            if ($schedule->start_datetime <= now()) {
                return back()->withErrors([
                    'schedule_id' => 'Cannot book past schedules.'
                ])->withInput();
            }

            if ($schedule->isFull()) {
                return back()->withErrors([
                    'schedule_id' => 'This schedule is fully booked.'
                ])->withInput();
            }

            // Check if user already booked this schedule
            $existingBooking = Booking::where('user_id', auth()->id())
                ->where('schedule_id', $validated['schedule_id'])
                ->where('status', '!=', 'cancelled')
                ->exists();

            if ($existingBooking) {
                return back()->withErrors([
                    'schedule_id' => 'You have already booked this schedule.'
                ])->withInput();
            }

            // Create the booking
            $booking = Booking::create([
                'user_id' => auth()->id(),
                'schedule_id' => $validated['schedule_id'],
                'status' => 'pending',
                'notes' => $validated['notes'],
                'booked_at' => now(),
            ]);

            DB::commit();

            return redirect()->route('student.bookings.show', $booking)
                ->with('success', 'Booking created successfully! Your booking code is: ' . $booking->booking_code);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'error' => 'An error occurred while creating your booking. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $booking->load(['schedule.course.category', 'payment']);

        return view('student.bookings.show', compact('booking'));
    }

    /**
     * Cancel a booking.
     */
    public function cancel(Request $request, Booking $booking)
    {
        // Ensure user can only cancel their own bookings
        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        // Validate cancellation reason
        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        // Check if booking can be cancelled
        if (!$booking->canBeCancelled()) {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        // Check if booking has a verified payment
        if ($booking->payment && $booking->payment->isVerified()) {
            return back()->with('error', 'Cannot cancel booking with verified payment. Please contact admin for refund.');
        }

        // Update booking status and add cancellation notes
        $booking->update([
            'status' => 'cancelled',
            'notes' => $booking->notes . '\n\nCancelled by student: ' . $request->cancellation_reason
        ]);

        return redirect()->route('student.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }

    /**
     * Get booking history with filters.
     */
    public function history(Request $request)
    {
        $query = auth()->user()
            ->bookings()
            ->with(['schedule.course', 'payment']);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->where('booked_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('booked_at', '<=', $request->to_date . ' 23:59:59');
        }

        $bookings = $query->latest('booked_at')
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'booking_code' => $booking->booking_code,
                    'course_name' => $booking->schedule->course->name,
                    'schedule_date' => $booking->schedule->start_datetime->format('M j, Y g:i A'),
                    'status' => $booking->status,
                    'payment_status' => $booking->payment ? $booking->payment->status : 'unpaid',
                    'booked_at' => $booking->booked_at->format('M j, Y'),
                    'can_cancel' => $booking->canBeCancelled(),
                    'url' => route('student.bookings.show', $booking)
                ];
            });

        return view('student.bookings.history', compact('bookings'));
    }

    /**
     * Check schedule availability.
     */
    public function checkAvailability(Request $request)
    {
        $scheduleId = $request->get('schedule_id');

        if (!$scheduleId) {
            return back()->withErrors(['schedule_id' => 'Schedule ID required']);
        }

        $schedule = Schedule::with('course')->find($scheduleId);

        if (!$schedule) {
            return back()->withErrors(['schedule_id' => 'Schedule not found']);
        }

        // Check if user already booked this schedule
        $alreadyBooked = Booking::where('user_id', auth()->id())
            ->where('schedule_id', $scheduleId)
            ->where('status', '!=', 'cancelled')
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['schedule_id' => 'You have already booked this schedule']);
        }

        $available = $schedule->status === 'scheduled' &&
            !$schedule->isFull() &&
            $schedule->start_datetime > now();

        $message = '';
        if (!$available) {
            if ($schedule->status !== 'scheduled') {
                $message = 'Schedule is not available';
            } elseif ($schedule->isFull()) {
                $message = 'Schedule is fully booked';
            } elseif ($schedule->start_datetime <= now()) {
                $message = 'Schedule has already started';
            }
        }

        $availabilityData = [
            'available' => $available,
            'message' => $message,
            'available_slots' => $schedule->available_slots,
            'booked_slots' => $schedule->booked_slots,
            'price' => $schedule->course->price
        ];

        if ($available) {
            return view('student.bookings.availability-check', compact('availabilityData', 'schedule'));
        } else {
            return back()->withErrors(['schedule_id' => $message]);
        }
    }
}