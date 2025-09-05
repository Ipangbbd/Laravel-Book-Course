<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Schedule::with(['course', 'bookings']);

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('course', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Filter by course
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date_from')) {
            $query->whereDate('start_datetime', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->whereDate('start_datetime', '<=', $request->date_to);
        }

        $schedules = $query->latest('start_datetime')->paginate(15);
        $courses = Course::active()->get();

        return view('admin.schedules.index', compact('schedules', 'courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::active()->get();
        return view('admin.schedules.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'start_datetime' => 'required|date|after:now',
            'end_datetime' => 'required|date|after:start_datetime',
            'available_slots' => 'required|integer|min:1|max:100',
            'status' => ['required', Rule::in(['scheduled', 'cancelled', 'completed'])],
            'notes' => 'nullable|string|max:1000',
        ]);

        // Convert datetime strings to Carbon instances for proper validation
        $startDateTime = Carbon::parse($validated['start_datetime']);
        $endDateTime = Carbon::parse($validated['end_datetime']);

        // check if schedule conflicts with existing ones
        $conflictingSchedule = Schedule::where('course_id', $validated['course_id'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_datetime', [$startDateTime, $endDateTime])
                      ->orWhereBetween('end_datetime', [$startDateTime, $endDateTime])
                      ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                          $q->where('start_datetime', '<=', $startDateTime)
                            ->where('end_datetime', '>=', $endDateTime);
                      });
            })
            ->exists();

        if ($conflictingSchedule) {
            return back()->withErrors([
                'start_datetime' => 'This schedule conflicts with an existing schedule for the same course.'
            ])->withInput();
        }

        Schedule::create($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        $schedule->load(['course.category', 'bookings.user']);
        return view('admin.schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        $courses = Course::active()->get();
        return view('admin.schedules.edit', compact('schedule', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'start_datetime' => 'required|date',
            'end_datetime' => 'required|date|after:start_datetime',
            'available_slots' => 'required|integer|min:1|max:100',
            'status' => ['required', Rule::in(['scheduled', 'cancelled', 'completed'])],
            'notes' => 'nullable|string|max:1000',
        ]);

        // Don't allow past schedules to be updated to future dates
        if ($schedule->start_datetime < now() && Carbon::parse($validated['start_datetime']) > now()) {
            return back()->withErrors([
                'start_datetime' => 'Cannot reschedule a past event to a future date.'
            ])->withInput();
        }

        // Convert datetime strings to Carbon instances for proper validation
        $startDateTime = Carbon::parse($validated['start_datetime']);
        $endDateTime = Carbon::parse($validated['end_datetime']);

        // Check for conflicts (excluding current schedule)
        $conflictingSchedule = Schedule::where('course_id', $validated['course_id'])
            ->where('id', '!=', $schedule->id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($startDateTime, $endDateTime) {
                $query->whereBetween('start_datetime', [$startDateTime, $endDateTime])
                      ->orWhereBetween('end_datetime', [$startDateTime, $endDateTime])
                      ->orWhere(function ($q) use ($startDateTime, $endDateTime) {
                          $q->where('start_datetime', '<=', $startDateTime)
                            ->where('end_datetime', '>=', $endDateTime);
                      });
            })
            ->exists();

        if ($conflictingSchedule) {
            return back()->withErrors([
                'start_datetime' => 'This schedule conflicts with an existing schedule for the same course.'
            ])->withInput();
        }

        // Don't allow reducing available slots below booked slots
        $bookedSlots = $schedule->bookings()->where('status', '!=', 'cancelled')->count();
        if ($validated['available_slots'] < $bookedSlots) {
            return back()->withErrors([
                'available_slots' => "Cannot reduce available slots below {$bookedSlots} (current bookings)."
            ])->withInput();
        }

        $schedule->update($validated);

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        // Don't allow deletion if there are active bookings
        $activeBookings = $schedule->bookings()->where('status', '!=', 'cancelled')->count();
        
        if ($activeBookings > 0) {
            return back()->with('error', "Cannot delete schedule with {$activeBookings} active booking(s). Cancel the bookings first.");
        }

        $schedule->delete();

        return redirect()->route('admin.schedules.index')
            ->with('success', 'Schedule deleted successfully!');
    }
}