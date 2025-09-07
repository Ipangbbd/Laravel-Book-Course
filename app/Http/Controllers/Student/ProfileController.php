<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Show the user profile.
     */
    public function show()
    {
        $user = auth()->user();

        // Load user statistics
        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'completed_courses' => $user->bookings()
                ->where('status', 'completed')
                ->count(),
            'active_bookings' => $user->bookings()
                ->whereIn('status', ['pending', 'approved'])
                ->count(),
            'total_payments' => $user->bookings()
                ->whereHas('payment')
                ->count(),
            'verified_payments' => $user->bookings()
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'verified');
                })
                ->count(),
        ];

        // Get recent bookings
        $recentBookings = $user->bookings()
            ->with(['schedule.course', 'payment'])
            ->latest('booked_at')
            ->limit(5)
            ->get();

        return view('student.profile.show', compact('user', 'stats', 'recentBookings'));
    }

    /**
     * Show the form for editing the user profile.
     */
    public function edit()
    {
        $user = auth()->user();
        return view('student.profile.edit', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'remove_avatar' => 'nullable|boolean',
            'current_password' => 'nullable|string',
            'password' => [
                'nullable',
                'required_with:current_password',
                'confirmed',
                Password::defaults()
            ],
        ]);

        // Verify current password if changing password
        if ($request->filled('current_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'The current password is incorrect.'
                ]);
            }
        }

        try {
            // Handle avatar removal
            if ($request->filled('remove_avatar') && $request->remove_avatar) {
                // Delete old avatar if exists
                if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                    Storage::disk('public')->delete($user->avatar_path);
                }
                $validated['avatar_path'] = null;
            }
            // Handle avatar upload
            elseif ($request->hasFile('avatar')) {
                // Delete old avatar if exists
                if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                    Storage::disk('public')->delete($user->avatar_path);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar_path'] = $avatarPath;
            }

            // Update password if provided
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($request->password);
            } else {
                unset($validated['password']);
                unset($validated['current_password']);
            }

            // Remove fields that shouldn't be mass assigned
            unset($validated['avatar']);
            unset($validated['remove_avatar']);
            unset($validated['current_password']);

            // Update user
            $user->update($validated);

            $message = 'Profile updated successfully!';
            if ($request->filled('password')) {
                $message .= ' Password has been changed.';
            }

            return redirect()->route('student.profile.show')
                ->with('success', $message);

        } catch (\Exception $e) {
            // Clean up uploaded avatar if update fails
            if (isset($avatarPath) && Storage::disk('public')->exists($avatarPath)) {
                Storage::disk('public')->delete($avatarPath);
            }

            return back()->withErrors([
                'error' => 'An error occurred while updating your profile. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Get profile statistics.
     */
    public function getStats()
    {
        $user = auth()->user();

        $stats = [
            'total_bookings' => $user->bookings()->count(),
            'completed_courses' => $user->bookings()
                ->where('status', 'completed')
                ->count(),
            'active_bookings' => $user->bookings()
                ->whereIn('status', ['pending', 'approved'])
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
            'total_spent' => $user->bookings()
                ->whereHas('payment', function ($q) {
                    $q->where('status', 'verified');
                })
                ->with('payment')
                ->get()
                ->sum(function ($booking) {
                    return $booking->payment->amount ?? 0;
                }),
        ];

        return view('student.profile.stats', compact('stats'));
    }

    /**
     * Get activity timeline.
     */
    public function getActivity(Request $request)
    {
        $user = auth()->user();
        $limit = $request->get('limit', 10);

        // Get recent bookings
        $bookings = $user->bookings()
            ->with(['schedule.course', 'payment'])
            ->latest('booked_at')
            ->limit($limit)
            ->get()
            ->map(function ($booking) {
                $activity = [
                    'type' => 'booking',
                    'title' => 'Booked: ' . $booking->schedule->course->name,
                    'date' => $booking->booked_at->format('M j, Y g:i A'),
                    'status' => $booking->status,
                    'icon' => 'calendar',
                    'url' => route('student.bookings.show', $booking)
                ];

                // Add payment info if exists
                if ($booking->payment) {
                    $activity['payment_status'] = $booking->payment->status;
                    $activity['payment_date'] = $booking->payment->paid_at->format('M j, Y');
                }

                return $activity;
            });

        // Get recent payments
        $payments = $user->bookings()
            ->whereHas('payment')
            ->with(['payment', 'schedule.course'])
            ->latest('created_at')
            ->limit($limit)
            ->get()
            ->map(function ($booking) {
                return [
                    'type' => 'payment',
                    'title' => 'Payment for: ' . $booking->schedule->course->name,
                    'date' => $booking->payment->paid_at->format('M j, Y g:i A'),
                    'status' => $booking->payment->status,
                    'amount' => $booking->payment->amount,
                    'icon' => 'credit-card',
                    'url' => route('student.payments.show', $booking->payment)
                ];
            });

        // Combine and sort activities
        $activities = $bookings->concat($payments)
            ->sortByDesc('date')
            ->values()
            ->take($limit);

        return view('student.profile.activity', compact('activities', 'limit'));
    }

    /**
     * Upload avatar.
     */
    public function uploadAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        try {
            $user = auth()->user();

            // Delete old avatar if exists
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            // Store new avatar
            $avatarPath = $request->file('avatar')->store('avatars', 'public');

            // Update user
            $user->update(['avatar_path' => $avatarPath]);

            $uploadResult = [
                'success' => true,
                'message' => 'Avatar updated successfully!',
                'avatar_url' => Storage::url($avatarPath)
            ];

            return redirect()->back()->with('success', $uploadResult['message'])
                ->with('avatar_url', $uploadResult['avatar_url']);

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'avatar' => 'Failed to upload avatar. Please try again.'
            ]);
        }
    }

    /**
     * Remove avatar.
     */
    public function removeAvatar()
    {
        try {
            $user = auth()->user();

            // Delete avatar file if exists
            if ($user->avatar_path && Storage::disk('public')->exists($user->avatar_path)) {
                Storage::disk('public')->delete($user->avatar_path);
            }

            // Update user
            $user->update(['avatar_path' => null]);

            return redirect()->back()->with('success', 'Avatar removed successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
                'avatar' => 'Failed to remove avatar. Please try again.'
            ]);
        }
    }
}