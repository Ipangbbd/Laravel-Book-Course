<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'booking_id',
        'amount',
        'proof_path',
        'payment_method',
        'status',
        'transaction_reference',
        'paid_at',
        'verified_at',
        'verified_by',
        'admin_notes',
        'rejection_reason',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    /**
     * Define relationship with booking
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    /**
     * Define relationship with verified by user (admin)
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for verified payments
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Scope for rejected payments
     */
    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Check if payment is verified
     */
    public function isVerified()
    {
        return $this->status === 'verified';
    }

    /**
     * Check if payment is pending
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Check if payment is rejected
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    /**
     * Mark payment as verified
     */
    public function markAsVerified($adminId, $notes = null)
    {
        $this->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $adminId,
            'admin_notes' => $notes,
        ]);
    }

    /**
     * Mark payment as rejected
     */
    public function markAsRejected($adminId, $reason = null, $notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'verified_at' => now(),
            'verified_by' => $adminId,
            'rejection_reason' => $reason,
            'admin_notes' => $notes,
        ]);
    }
}
