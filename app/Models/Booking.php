<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $fillable = ['user_id', 'resource_id', 'start_time', 'end_time', 'total_price', 'status'];

    public function resource() { 
        return $this->belongsTo(Resource::class); 
    }

    public function user() { 
        return $this->belongsTo(User::class); 
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }
}
