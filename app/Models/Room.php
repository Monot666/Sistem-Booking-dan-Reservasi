<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Room model — represents a bookable hotel room.
 *
 * Uses the legacy 'resources' table to avoid migration changes.
 */
class Room extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'resources';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'type',
        'description',
        'image',
        'capacity',
        'max_adults',
        'max_children',
        'size',
        'facilities',
        'price_per_hour',
        'is_active',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_per_hour' => 'decimal:2',
            'is_active'      => 'boolean',
            'capacity'       => 'integer',
            'max_adults'     => 'integer',
            'max_children'   => 'integer',
        ];
    }

    /**
     * Get the bookings for this room.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'resource_id');
    }
}
