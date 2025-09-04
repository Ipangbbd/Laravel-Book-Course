<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Schedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'course_id',
        'start_datetime',
        'end_datetime',
        'available_slots',
        'status',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
        'available_slots' => 'integer',
    ];

    /**
     * Define relationship with course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Define relationship with bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Scope for scheduled sessions
     */
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    /**
     * Scope for available schedules (has slots and is scheduled)
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'scheduled')
                    ->where('available_slots', '>', 0)
                    ->where('start_datetime', '>', now());
    }

    /**
     * Get booked slots count
     */
    public function getBookedSlotsAttribute()
    {
        return $this->bookings()->where('status', '!=', 'cancelled')->count();
    }

    /**
     * Check if schedule is full
     */
    public function isFull()
    {
        return $this->available_slots <= $this->booked_slots;
    }
}
