<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AdminController\TesterController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\EwalletController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\BookingController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('landing');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction'])->name('login.action');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerAction'])->name('register.action');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Harus Login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // --- BOOKING SYSTEM ---
    // Nama rute 'booking' mengarah ke halaman booking step
    Route::get('/booking', fn () => view('user.booking'))->name('booking');

    Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/user/booking/{id}', [BookingController::class, 'show'])->name('bookings.show');

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/orders', function () {
        return view('profile.orders');
    })->name('profile.orders');

    // --- KARTU ---
    Route::prefix('profile/cards')->group(function () {
        Route::get('/', [CardController::class, 'index'])->name('profile.cards');
        Route::post('/', [CardController::class, 'store'])->name('profile.cards.store');
        Route::put('/{id}', [CardController::class, 'update'])->name('profile.cards.update');
        Route::delete('/{id}', [CardController::class, 'destroy'])->name('profile.cards.destroy');
    });

    // --- E-WALLET ---
    Route::prefix('profile/e-wallet')->group(function () {
        Route::get('/', [EwalletController::class, 'index'])->name('profile.ewallet');
        Route::post('/', [EwalletController::class, 'store'])->name('profile.ewallet.store');
        Route::put('/{id}', [EwalletController::class, 'update'])->name('profile.ewallet.update');
        Route::delete('/{id}', [EwalletController::class, 'destroy'])->name('profile.ewallet.destroy');
    });

    // --- RESOURCES ---
    Route::get('/component', [ResourceController::class, 'index'])->name('bookingdua.index');
    Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('bookingdua.show');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
   Route::middleware('admin')->group(function () {
        // Management Resource oleh Admin
        Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
        Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
        Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');

        // Admin Panel Group
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/rooms', fn() => view('admin.rooms'))->name('rooms');
            Route::get('/bookings', fn() => view('admin.bookings'))->name('bookings');
            Route::get('/guests', fn() => view('admin.guests'))->name('guests');
            Route::get('/finance', fn() => view('admin.finance'))->name('finance');
        });
    });
});

/*
|--------------------------------------------------------------------------
| TESTING ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/send-tester', [TesterController::class, 'send']);
Route::get('/test', [TesterController::class, 'index']);