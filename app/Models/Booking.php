<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Booking model — represents a room reservation made by a user.
 */
class Booking extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'no_pesanan',
        'user_id',
        'resource_id',
        'room_unit_id',
        'nama_pemesan',
        'no_hp',
        'email',
        'nama_pengunjung',
        'permintaan_khusus',
        'room_name',
        'room_price',
        'start_time',
        'end_time',
        'guest_count',
        'total_price',
        'tax_and_fee',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_time'  => 'datetime',
            'end_time'    => 'datetime',
            'total_price' => 'decimal:2',
            'tax_and_fee' => 'decimal:2',
            'status'      => \App\Enums\BookingStatus::class,
        ];
    }

    /**
     * Get the room that this booking belongs to.
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'resource_id');
    }

    /**
     * Get the physical room unit assigned to this booking.
     */
    public function roomUnit()
    {
        return $this->belongsTo(RoomUnit::class, 'room_unit_id');
    }

    /**
     * Get the user who made this booking.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the transactions for this booking.
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }



    /**
     * Legacy alias for the room() relationship.
     *
     * @deprecated Use room() instead.
     */
    public function resource()
    {
        return $this->room();
    }
}
