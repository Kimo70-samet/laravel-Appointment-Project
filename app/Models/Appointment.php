<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'start_time',
        'end_time',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getDurationAttribute(): int
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }

    public function getIsTodayAttribute(): bool
    {
        return $this->start_time->isToday();
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now());
    }

    public function scopePast($query)
    {
        return $query->where('end_time', '<', now());
    }

    /**
     * Get the user that owns the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}