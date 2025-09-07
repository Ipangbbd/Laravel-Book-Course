<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Display a listing of the user's payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.schedule.course', 'verifiedBy'])
            ->whereHas('booking', function ($q) {
                $q->where('user_id', auth()->id());
            });

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by transaction reference
        if ($request->filled('transaction_reference')) {
            $query->where('transaction_reference', 'like', '%' . $request->transaction_reference . '%');
        }

        // Filter by booking code
        if ($request->filled('booking_code')) {
            $query->whereHas('booking', function ($q) use ($request) {
                $q->where('booking_code', 'like', '%' . $request->booking_code . '%');
            });
        }

        $payments = $query->latest('paid_at')->paginate(10)->withQueryString();

        return view('student.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create(Request $request)
    {
        $bookingId = $request->get('booking_id');
        $booking = null;

        if ($bookingId) {
            // Get specific booking if provided
            $booking = Booking::with(['schedule.course', 'payment'])
                ->where('user_id', auth()->id())
                ->find($bookingId);

            if (!$booking) {
                return redirect()->route('student.bookings.index')
                    ->with('error', 'Booking not found.');
            }

            // Check if booking already has a payment
            if ($booking->payment) {
                return redirect()->route('student.payments.show', $booking->payment)
                    ->with('info', 'This booking already has a payment.');
            }
        }

        // Get all bookings withjout payments for dropdown
        $bookingsWithoutPayments = Booking::with(['schedule.course'])
            ->where('user_id', auth()->id())
            ->whereDoesntHave('payment')
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('booked_at', 'desc')
            ->get();

        return view('student.payments.create', compact('booking', 'bookingsWithoutPayments'));
    }

    /**
     * Store a newly created payment in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => ['required', Rule::in(['bank_transfer', 'credit_card', 'e_wallet', 'other'])],
            'transaction_reference' => 'nullable|string|max:255',
            'proof_file' => 'required|file|mimes:jpeg,jpg,png,pdf|max:5120', // 5MB max
        ]);

        // Verify the booking belongs to the authenticated user
        $booking = Booking::with(['schedule.course'])
            ->where('user_id', auth()->id())
            ->find($validated['booking_id']);

        if (!$booking) {
            return back()->withErrors([
                'booking_id' => 'Invalid booking selected.'
            ])->withInput();
        }

        // Check if booking already has a payment
        if ($booking->payment) {
            return back()->withErrors([
                'booking_id' => 'This booking already has a payment.'
            ])->withInput();
        }

        // Validate payment amount matches course price
        if ($validated['amount'] != $booking->schedule->course->price) {
            return back()->withErrors([
                'amount' => 'Payment amount must match the course price: $' . number_format((float) $booking->schedule->course->price, 2)
            ])->withInput();
        }

        try {
            // Handle file upload
            $proofPath = null;
            if ($request->hasFile('proof_file')) {
                $file = $request->file('proof_file');
                $filename = 'payment_proof_' . Str::random(10) . '_' . time() . '.' . $file->getClientOriginalExtension();
                $proofPath = $file->storeAs('payment_proofs', $filename, 'public');
            }

            // Create payment record
            $payment = Payment::create([
                'booking_id' => $validated['booking_id'],
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'transaction_reference' => $validated['transaction_reference'],
                'proof_path' => $proofPath,
                'status' => 'pending',
                'paid_at' => now(),
            ]);

            return redirect()->route('student.payments.show', $payment)
                ->with('success', 'Payment submitted successfully! It will be reviewed by admin.');

        } catch (\Exception $e) {
            // Clean up uploaded file if payment creation fails
            if ($proofPath && Storage::disk('public')->exists($proofPath)) {
                Storage::disk('public')->delete($proofPath);
            }

            return back()->withErrors([
                'error' => 'An error occurred while submitting your payment. Please try again.'
            ])->withInput();
        }
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        // Ensure user can only view their own payments
        if ($payment->booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }

        $payment->load(['booking.schedule.course.category', 'verifiedBy']);

        return view('student.payments.show', compact('payment'));
    }

    /**
     * Get payment status for a booking.
     */
    public function getPaymentStatus(Request $request)
    {
        $bookingId = $request->get('booking_id');

        if (!$bookingId) {
            return back()->withErrors(['booking_id' => 'Booking ID required']);
        }

        $booking = Booking::with(['payment', 'schedule.course'])
            ->where('user_id', auth()->id())
            ->find($bookingId);

        if (!$booking) {
            return back()->withErrors(['booking_id' => 'Booking not found']);
        }

        $paymentStatus = [
            'has_payment' => $booking->payment ? true : false,
            'payment_status' => $booking->payment ? $booking->payment->status : null,
            'amount' => $booking->payment ? $booking->payment->amount : $booking->schedule->course->price,
            'course_price' => $booking->schedule->course->price,
            'verified_at' => $booking->payment && $booking->payment->verified_at ?
                $booking->payment->verified_at->format('M j, Y g:i A') : null,
        ];

        return view('student.payments.payment-status', compact('paymentStatus', 'booking'));
    }

    /**
     * Get payment history with filters.
     */
    public function history(Request $request)
    {
        $query = Payment::with(['booking.schedule.course'])
            ->whereHas('booking', function ($q) {
                $q->where('user_id', auth()->id());
            });

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->where('paid_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('paid_at', '<=', $request->to_date . ' 23:59:59');
        }

        $payments = $query->latest('paid_at')
            ->get()
            ->map(function ($payment) {
                return [
                    'id' => $payment->id,
                    'booking_code' => $payment->booking->booking_code,
                    'course_name' => $payment->booking->schedule->course->name,
                    'amount' => $payment->amount,
                    'payment_method' => $payment->payment_method,
                    'status' => $payment->status,
                    'paid_at' => $payment->paid_at->format('M j, Y'),
                    'verified_at' => $payment->verified_at ? $payment->verified_at->format('M j, Y') : null,
                    'url' => route('student.payments.show', $payment)
                ];
            });

        return view('student.payments.history', compact('payments'));
    }

    /**
     * Download payment proof file.
     */
    public function downloadProof(Payment $payment)
    {
        // Ensure user can only download their own payment proofs
        if ($payment->booking->user_id !== auth()->id()) {
            abort(403, 'Unauthorized access.');
        }
    
        if (!$payment->proof_path || !Storage::disk('public')->exists($payment->proof_path)) {
            abort(404, 'File not found.');
        }
    
        $filePath = Storage::disk('public')->path($payment->proof_path);
        $filename = basename($filePath);
    
        return response()->download($filePath, $filename);
    }

    /**
     * Get unpaid bookings for dropdown.
     */
    public function getUnpaidBookings()
    {
        $bookings = Booking::with(['schedule.course'])
            ->where('user_id', auth()->id())
            ->whereDoesntHave('payment')
            ->whereIn('status', ['pending', 'approved'])
            ->orderBy('booked_at', 'desc')
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'booking_code' => $booking->booking_code,
                    'course_name' => $booking->schedule->course->name,
                    'schedule_date' => $booking->schedule->start_datetime->format('M j, Y g:i A'),
                    'amount' => $booking->schedule->course->price,
                    'status' => $booking->status
                ];
            });

        return view('student.payments.unpaid-bookings', compact('bookings'));
    }
}