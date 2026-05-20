<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Event extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'events';

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLISHED = 'published';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'title',
        'slug',
        'description',
        'venue',
        'address',
        'city',
        'starts_at',
        'ends_at',
        'price',
        'capacity',
        'seats_booked',
        'image',
        'status',
        'category_id',
        'organizer_id',
        'is_featured',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'price' => 'float',
        'capacity' => 'integer',
        'seats_booked' => 'integer',
        'is_featured' => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'event_id');
    }

    public function seatsRemaining(): int
    {
        return max(0, (int) $this->capacity - (int) ($this->seats_booked ?? 0));
    }

    public function isSoldOut(): bool
    {
        return $this->seatsRemaining() <= 0;
    }

    public function isUpcoming(): bool
    {
        return $this->starts_at && $this->starts_at->isFuture();
    }
}
