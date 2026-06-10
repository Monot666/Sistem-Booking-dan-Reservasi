<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Payment model — represents a payment transaction for a booking.
 */
class Payment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'booking_id',
        'amount',
        'method',
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
            'amount' => 'decimal:2',
            'status' => \App\Enums\PaymentStatus::class,
        ];
    }

    /**
     * Get the booking that this payment belongs to.
     */
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
