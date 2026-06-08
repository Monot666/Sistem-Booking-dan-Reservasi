<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model {
    protected $fillable = [
        'no_pesanan',
        'user_id',
        'resource_id',
        'nama_pemesan',
        'no_hp',
        'email',
        'nama_pengunjung',
        'permintaan_khusus',
        'start_time',
        'end_time',
        'total_price',
        'tax_and_fee',
        'status'
    ];

    public function resource() { 
        return $this->belongsTo(Resource::class); 
    }

    public function user() { 
        return $this->belongsTo(User::class); 
    }

    public function payments() {
        return $this->hasMany(Payment::class);
    }

    protected $table = 'bookings';

}

