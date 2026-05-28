<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemesanan extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk membuka izin mass assignment
    protected $fillable = [
        'no_pesanan',
        'user_id',
        'nama_pemesan',
        'no_hp',
        'email',
        'nama_pengunjung',
        'permintaan_khusus',
        'room_name',
        'option_type',
        'price_per_night',
        'tax_and_fee',
        'total_price',
        'status',
    ];
}