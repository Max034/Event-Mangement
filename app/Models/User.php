<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use MongoDB\Laravel\Auth\User as Authenticatable;
use MongoDB\Laravel\Eloquent\HybridRelations;

class User extends Authenticatable
{
    use Notifiable, HybridRelations;

    protected $connection = 'mongodb';
    protected $collection = 'users';

    public const ROLE_ADMIN = 'admin';
    public const ROLE_ORGANIZER = 'organizer';
    public const ROLE_ATTENDEE = 'attendee';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isOrganizer(): bool
    {
        return $this->role === self::ROLE_ORGANIZER;
    }

    public function isAttendee(): bool
    {
        return $this->role === self::ROLE_ATTENDEE;
    }

    public function events()
    {
        return $this->hasMany(Event::class, 'organizer_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }
}
