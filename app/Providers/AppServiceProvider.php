<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Kirim OTP otomatis saat pengguna baru mendaftar
        Event::listen(function (Registered $event) {
            $user = $event->user;
            if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                $user->sendEmailVerificationNotification();
            }
        });

        // Kirim OTP otomatis saat pengguna login, kecuali jika ia baru saja mendaftar (auto-login)
        Event::listen(function (Login $event) {
            $user = $event->user;
            if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                // Cegah pengiriman ganda jika login terjadi sesaat setelah register (Fortify auto-login)
                if ($user->created_at && $user->created_at->diffInSeconds(now()) < 10) {
                    return;
                }
                $user->sendEmailVerificationNotification();
            }
        });
    }
}
