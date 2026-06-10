<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description',
        'type',
        'amount',
        'method',
        'status',
    ];

    protected $casts = [
        'type' => \App\Enums\TransactionType::class,
    ];
}
