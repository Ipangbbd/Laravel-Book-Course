<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'schedule_id',
        'booking_code',
        'status',
        'booked_at',
        'notes',
        'admin_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'booked_at' => 'datetime',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_code)) {
                $booking->booking_code = 'BK-' . strtoupper(Str::random(8));
            }
            if (empty($booking->booked_at)) {
                $booking->booked_at = now();
            }
        });
    }

    /**
     * Define relationship with user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define relationship with schedule
     */
    public function schedule()
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Define relationship with payment
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    /**
     * Scope for pending bookings
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved bookings
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Check if booking is active (approved or completed)
     */
    public function isActive()
    {
        return in_array($this->status, ['approved', 'completed']);
    }

    /**
     * Check if booking can be cancelled
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'approved']) && 
               $this->schedule->start_datetime > now();
    }
}
