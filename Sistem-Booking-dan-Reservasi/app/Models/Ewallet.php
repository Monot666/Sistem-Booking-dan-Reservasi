<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ewallet extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone'
    ];

    /**
     * Get the user that owns the e-wallet.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}