<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'gender',    // Tambahkan ini
        'birthdate', // Tambahkan ini
        'city',      // Tambahkan ini
        'phone',     // Tambahkan ini
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'birthdate' => 'date', // Tambahkan cast date agar mudah diolah
        ];
    }
<<<<<<< HEAD
}
=======

    /**
     * Get the bookings for the user.
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    /**
     * Get the cards for the user.
     */
    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    /**
     * Get the e-wallets for the user.
     */
    public function ewallets()
    {
        return $this->hasMany(Ewallet::class);
    }
}
>>>>>>> 88f4aec (feat: setup dynamic resource seeder)
