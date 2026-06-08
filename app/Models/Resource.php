<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model {
    use HasFactory;

    protected $fillable = ['name', 'type', 'description', 'image', 'capacity', 'max_adults', 'max_children', 'size', 'facilities', 'price_per_hour', 'is_active'];

    public function bookings() { 
        return $this->hasMany(Booking::class); 
    }
}
