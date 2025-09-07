<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Category;
use App\Models\Schedule;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of active courses with search and filter functionality.
     */
    public function index(Request $request)
    {
        $query = Course::with(['category', 'schedules'])
            ->active(); // Only show active courses to students

        // Search functionality by name, description, or instructors
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                    ->orWhere('description', 'like', '%' . $searchTerm . '%')
                    ->orWhere('instructor_name', 'like', '%' . $searchTerm . '%');
            });
        }

        // Filter by category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Filter by duration range
        if ($request->filled('min_duration')) {
            $query->where('duration', '>=', $request->min_duration);
        }

        if ($request->filled('max_duration')) {
            $query->where('duration', '<=', $request->max_duration);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'name');
        $sortOrder = $request->get('sort_order', 'asc');

        $allowedSorts = ['name', 'price', 'duration', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder === 'desc' ? 'desc' : 'asc');
        }

        $courses = $query->paginate(12)->withQueryString();

        // Get active categories for filter dropdown
        $categories = Category::active()->get();

        return view('student.courses.index', compact('courses', 'categories'));
    }

    /**
     * Display the specified course with available schedules.
     */
    public function show(Course $course)
    {
        // Only allow viewing active courses
        if ($course->status !== 'active') {
            abort(404, 'Course not found');
        }

        // Load relationships
        $course->load([
            'category',
            'schedules' => function ($query) {
                $query->available() // Only show available schedules
                    ->with('bookings')
                    ->orderBy('start_datetime');
            }
        ]);

        // Check if user is authenticated and has existing bookings for this course
        $userBookings = collect();
        if (auth()->check() && auth()->user()->isStudent()) {
            $userBookings = auth()->user()
                ->bookings()
                ->whereHas('schedule', function ($query) use ($course) {
                    $query->where('course_id', $course->id);
                })
                ->with('schedule')
                ->get();
        }

        return view('student.courses.show', compact('course', 'userBookings'));
    }

    /**
     * Get available schedules for a specific course.
     */
    public function getSchedules(Course $course)
    {
        $schedules = $course->schedules()
            ->available()
            ->with('bookings')
            ->get()
            ->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'start_datetime' => $schedule->start_datetime->format('Y-m-d H:i:s'),
                    'end_datetime' => $schedule->end_datetime->format('Y-m-d H:i:s'),
                    'available_slots' => $schedule->available_slots,
                    'booked_slots' => $schedule->booked_slots,
                    'is_full' => $schedule->isFull(),
                    'formatted_date' => $schedule->start_datetime->format('M j, Y'),
                    'formatted_time' => $schedule->start_datetime->format('g:i A') . ' - ' . $schedule->end_datetime->format('g:i A'),
                ];
            });

        return view('student.courses.schedules', compact('schedules', 'course'));
    }

    /**
     * Search courses (for autocomplete).
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            $courses = collect();
            return view('student.courses.search-results', compact('courses', 'query'));
        }

        $courses = Course::active()
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                    ->orWhere('instructor_name', 'like', '%' . $query . '%');
            })
            ->limit(10)
            ->get(['id', 'name', 'instructor_name', 'price'])
            ->map(function ($course) {
                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'instructor' => $course->instructor_name,
                    'price' => $course->price,
                    'url' => route('student.courses.show', $course->id)
                ];
            });

        return view('student.courses.search-results', compact('courses', 'query'));
    }
}