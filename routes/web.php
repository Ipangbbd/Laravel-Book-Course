<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginRegisterController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\CourseController as AdminCourseController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ScheduleController as AdminScheduleController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Student\HomeController as StudentHomeController;
use App\Http\Controllers\Student\CourseController as StudentCourseController;
use App\Http\Controllers\Student\BookingController as StudentBookingController;
use App\Http\Controllers\Student\PaymentController as StudentPaymentController;
use App\Http\Controllers\Student\ProfileController as StudentProfileController;

// Public routes
Route::get('/', function () { return view('welcome'); })->name('welcome');

// Authentication routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [LoginRegisterController::class, 'register'])->name('register');
    Route::post('/register', [LoginRegisterController::class, 'store'])->name('register.store');
    Route::get('/login', [LoginRegisterController::class, 'login'])->name('login');
    Route::post('/login', [LoginRegisterController::class, 'authenticate'])->name('login.authenticate');
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/home', [LoginRegisterController::class, 'home'])->name('home');
    Route::post('/logout', [LoginRegisterController::class, 'logout'])->name('logout');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Category management
    Route::resource('categories', AdminCategoryController::class);
    
    // Course management
    Route::resource('courses', AdminCourseController::class);
    
    // Schedule management
    Route::resource('schedules', AdminScheduleController::class);
    
    // Booking management
    Route::resource('bookings', AdminBookingController::class);
    Route::patch('/bookings/{booking}/approve', [AdminBookingController::class, 'approve'])->name('bookings.approve');
    Route::patch('/bookings/{booking}/reject', [AdminBookingController::class, 'reject'])->name('bookings.reject');
    
    // Payment management
    Route::resource('payments', AdminPaymentController::class)->only(['index', 'show', 'update']);
    Route::patch('/payments/{payment}/verify', [AdminPaymentController::class, 'verify'])->name('payments.verify');
    Route::patch('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
    
    // User management
    Route::resource('users', AdminUserController::class);
});

// Student routes
Route::middleware(['auth', 'student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentHomeController::class, 'index'])->name('dashboard');
    
    // Course browsing
    Route::get('/courses', [StudentCourseController::class, 'index'])->name('courses.index');
    Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('courses.show');
    
    // Booking management
    Route::resource('bookings', StudentBookingController::class)->except(['edit', 'update']);
    Route::patch('/bookings/{booking}/cancel', [StudentBookingController::class, 'cancel'])->name('bookings.cancel');
    
    // Payment management
    Route::resource('payments', StudentPaymentController::class)->only(['index', 'show', 'create', 'store']);
    
    // Profile management
    Route::get('/profile', [StudentProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [StudentProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [StudentProfileController::class, 'update'])->name('profile.update');
});

// Public course browsing (for non-authenticated users)
Route::get('/courses', [StudentCourseController::class, 'index'])->name('public.courses.index');
Route::get('/courses/{course}', [StudentCourseController::class, 'show'])->name('public.courses.show');
