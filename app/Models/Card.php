<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Card model — represents a saved bank card for a user.
 */
class Card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'bank_name',
        'account_number',
        'card_name',
    ];

    /**
     * Get the user that owns the card.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}