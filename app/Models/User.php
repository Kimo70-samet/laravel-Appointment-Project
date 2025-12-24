<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // User roles
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';

    // User statuses
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Check if user is approved
     */
    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Check if user is pending approval
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if user can edit/delete appointments
     */
    public function canManageAppointments(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can manage all appointments (admin only)
     */
    public function canManageAllAppointments(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Check if user can manage specific appointment
     */
    public function canManageAppointment($appointment): bool
    {
        return $this->isAdmin() || $appointment->user_id === $this->id;
    }

    /**
     * Get pending users
     */
    public static function pending()
    {
        return self::where('status', self::STATUS_PENDING);
    }

    /**
     * Get approved users
     */
    public static function approved()
    {
        return self::where('status', self::STATUS_APPROVED);
    }

    /**
     * Get the appointments for the user.
     */
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}
