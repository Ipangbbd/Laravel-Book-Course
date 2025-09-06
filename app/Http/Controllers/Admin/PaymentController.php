<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.user', 'booking.schedule.course', 'verifiedBy']);

        $payments = $query->latest('paid_at')->paginate(15);

        return view('admin.payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $bookingId = $request->get('booking_id');
        $booking = null;
        
        if ($bookingId) {
            $booking = Booking::with(['user', 'schedule.course'])->find($bookingId);
        }
        
        // Get bookings that don't have payments yet
        $bookingsWithoutPayments = Booking::with(['user', 'schedule.course'])
                                            ->whereDoesntHave('payment')
                                            ->whereIn('status', ['pending', 'approved'])
                                            ->get();
        
        return view('admin.payments.create', compact('booking', 'bookingsWithoutPayments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => ['required', Rule::in(['bank_transfer', 'credit_card', 'cash', 'other'])],
            'transaction_reference' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(['pending', 'verified'])],
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        // Check if booking already has a payment
        $existingPayment = Payment::where('booking_id', $validated['booking_id'])->exists();
        if ($existingPayment) {
            return back()->withErrors([
                'booking_id' => 'This booking already has a payment record.'
            ])->withInput();
        }

        $paymentData = $validated;
        $paymentData['paid_at'] = now();
        
        if ($validated['status'] === 'verified') {
            $paymentData['verified_at'] = now();
            $paymentData['verified_by'] = auth()->id();
        }

        $payment = Payment::create($paymentData);
        
        // Update booking status if payment is verified
        if ($validated['status'] === 'verified') {
            $payment->booking->update(['status' => 'approved']);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment created successfully!');
    }

    public function show(Payment $payment)
    {
        $payment->load(['booking.user', 'booking.schedule.course.category', 'verifiedBy']);
        return view('admin.payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $payment->load(['booking.user', 'booking.schedule.course']);
        
        return view('admin.payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
            'payment_method' => ['required', Rule::in(['bank_transfer', 'credit_card', 'cash', 'other'])],
            'transaction_reference' => 'nullable|string|max:255',
            'status' => ['required', Rule::in(['pending', 'verified', 'rejected'])],
            'admin_notes' => 'nullable|string|max:1000',
            'rejection_reason' => 'required_if:status,rejected|nullable|string|max:500',
        ]);

        $oldStatus = $payment->status;
        
        if ($validated['status'] === 'verified' && $oldStatus !== 'verified') {
            $payment->update([
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'transaction_reference' => $validated['transaction_reference'],
                'admin_notes' => $validated['admin_notes'],
            ]);
            
            $payment->markAsVerified(
                auth()->id(), 
                $validated['admin_notes'] ?? null
            );
            
            // Also update booking status if payment is verified
            $payment->booking->update(['status' => 'approved']);
            
            $message = 'Payment updated and verified successfully!';
        } elseif ($validated['status'] === 'rejected') {
            $payment->update([
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'transaction_reference' => $validated['transaction_reference'],
                'admin_notes' => $validated['admin_notes'],
            ]);
            
            $payment->markAsRejected(
                auth()->id(),
                $validated['rejection_reason'] ?? null,
                $validated['admin_notes'] ?? null
            );
            
            $message = 'Payment updated and rejected successfully!';
        } else {
            $payment->update([
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'transaction_reference' => $validated['transaction_reference'],
                'status' => $validated['status'],
                'admin_notes' => $validated['admin_notes'] ?? null,
            ]);
            
            $message = 'Payment updated successfully!';
        }

        return redirect()->route('admin.payments.index')
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        $booking = $payment->booking;
        $payment->delete();

        // Reset booking status if payment is deleted
        if ($booking->status === 'approved') {
            $booking->update(['status' => 'pending']);
        }

        return redirect()->route('admin.payments.index')
            ->with('success', 'Payment deleted successfully!');
    }


    /**
     * Verify a payment
     */
    public function verify(Request $request, Payment $payment)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Only pending payments can be verified.');
        }

        $payment->markAsVerified(
            auth()->id(), 
            $request->admin_notes
        );
        
        // Update booking status
        $payment->booking->update(['status' => 'approved']);

        return back()->with('success', 'Payment verified successfully!');
    }

    /**
     * Reject a payment
     */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        if ($payment->status !== 'pending') {
            return back()->with('error', 'Only pending payments can be rejected.');
        }

        $payment->markAsRejected(
            auth()->id(),
            $request->rejection_reason,
            $request->admin_notes
        );

        return back()->with('success', 'Payment rejected successfully!');
    }
}
