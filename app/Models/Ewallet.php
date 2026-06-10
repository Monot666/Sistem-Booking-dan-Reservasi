<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Ewallet model — represents a saved e-wallet for a user.
 */
class Ewallet extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'phone',
    ];

    /**
     * Get the user that owns the e-wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}