<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration',
        'max_participants',
        'category_id',
        'status',
        'instructor_name',
        'image_path',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'max_participants' => 'integer',
    ];

    /**
     * Define relationship with category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define relationship with schedules
     */
    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Scope for active courses
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get formatted duration
     */
    public function getFormattedDurationAttribute()
    {
        $hours = floor($this->duration / 60);
        $minutes = $this->duration % 60;
        
        if ($hours > 0) {
            return $hours . 'h ' . ($minutes > 0 ? $minutes . 'm' : '');
        }
        
        return $minutes . 'm';
    }
}
