<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomUnit extends Model
{
    use HasFactory;

    protected $fillable = [
        'resource_id',
        'room_number',
    ];

    /**
     * Get the room type (resource) this unit belongs to.
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'resource_id');
    }

    /**
     * Get the bookings for this specific room unit.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'room_unit_id');
    }

    /**
     * Check if the room unit is booked on a specific date.
     */
    public function isBookedOn($date)
    {
        $checkDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
        
        return $this->bookings()
            ->where('status', '!=', \App\Enums\BookingStatus::Cancelled)
            ->whereDate('start_time', '<=', $checkDate)
            ->whereDate('end_time', '>', $checkDate)
            ->exists();
    }

    /**
     * Get the active booking for this room unit on a specific date.
     */
    public function getActiveBookingOn($date)
    {
        $checkDate = \Carbon\Carbon::parse($date)->format('Y-m-d');
        
        return $this->bookings()
            ->where('status', '!=', \App\Enums\BookingStatus::Cancelled)
            ->whereDate('start_time', '<=', $checkDate)
            ->whereDate('end_time', '>', $checkDate)
            ->first();
    }
}
