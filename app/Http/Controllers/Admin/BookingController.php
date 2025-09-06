<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'schedule.course', 'payment']);

        $bookings = $query->latest('booked_at')->paginate(15);
        $schedules = Schedule::with('course')->get();
        $users = User::where('role', 'student')->get();

        return view('admin.bookings.index', compact('bookings', 'schedules', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $schedules = Schedule::with('course')
                            ->where('status', 'scheduled')
                            ->where('start_datetime', '>', now())
                            ->get();
        $users = User::where('role', 'student')->where('status', 'active')->get();
        
        return view('admin.bookings.create', compact('schedules', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected', 'cancelled', 'completed'])],
            'notes' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Check if user is student
        $user = User::find($validated['user_id']);
        if ($user->role !== 'student') {
            return back()->withErrors([
                'user_id' => 'Only students can make bookings.'
            ])->withInput();
        }

        // Check if schedule is available
        $schedule = Schedule::find($validated['schedule_id']);
        if ($schedule->status !== 'scheduled') {
            return back()->withErrors([
                'schedule_id' => 'This schedule is not available for booking.'
            ])->withInput();
        }

        // Check if schedule is full
        if ($schedule->isFull()) {
            return back()->withErrors([
                'schedule_id' => 'This schedule is fully booked.'
            ])->withInput();
        }

        // Check if user already booked this schedule
        $existingBooking = Booking::where('user_id', $validated['user_id'])
                                    ->where('schedule_id', $validated['schedule_id'])
                                    ->where('status', '!=', 'cancelled')
                                    ->exists();

        if ($existingBooking) {
            return back()->withErrors([
                'schedule_id' => 'This user has already booked this schedule.'
            ])->withInput();
        }

        $booking = Booking::create($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        $booking->load(['user', 'schedule.course.category', 'payment']);
        return view('admin.bookings.show', compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        $schedules = Schedule::with('course')
                            ->where('status', 'scheduled')
                            ->get();
        $users = User::where('role', 'student')->get();
        
        return view('admin.bookings.edit', compact('booking', 'schedules', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'schedule_id' => 'required|exists:schedules,id',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected', 'cancelled', 'completed'])],
            'notes' => 'nullable|string|max:1000',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Check if user is student
        $user = User::find($validated['user_id']);
        if ($user->role !== 'student') {
            return back()->withErrors([
                'user_id' => 'Only students can make bookings.'
            ])->withInput();
        }

        // Check for duplicate booking (excluding current booking)
        $existingBooking = Booking::where('user_id', $validated['user_id'])
                                    ->where('schedule_id', $validated['schedule_id'])
                                    ->where('status', '!=', 'cancelled')
                                    ->where('id', '!=', $booking->id)
                                    ->exists();

        if ($existingBooking) {
            return back()->withErrors([
                'schedule_id' => 'This user has already booked this schedule.'
            ])->withInput();
        }

        $booking->update($validated);

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        // Check if booking has verified payment
        if ($booking->payment && $booking->payment->isVerified()) {
            return back()->with('error', 'Cannot delete booking with verified payment. Cancel the booking instead.');
        }

        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking deleted successfully!');
    }

    /**
     * Approve a booking
     */
    public function approve(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be approved.');
        }

        $booking->update([
            'status' => 'approved',
            'admin_notes' => 'Approved by admin: ' . auth()->user()->name
        ]);

        return back()->with('success', 'Booking approved successfully!');
    }

    /**
     * Reject a booking
     */
    public function reject(Request $request, Booking $booking)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be rejected.');
        }

        $booking->update([
            'status' => 'cancelled',
            'admin_notes' => 'Rejected by admin: ' . auth()->user()->name . ' - Reason: ' . $request->rejection_reason
        ]);

        return back()->with('success', 'Booking rejected successfully!');
    }
}
