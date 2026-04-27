<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\AdminController\TesterController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\EwalletController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('landing');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginAction'])->name('login.action');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'registerAction'])->name('register.action');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| PROTECTED
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // KARTU
    Route::prefix('profile/cards')->group(function () {
        Route::get('/', [CardController::class, 'index'])->name('profile.cards');
        Route::post('/', [CardController::class, 'store'])->name('profile.cards.store');
        Route::put('/{id}', [CardController::class, 'update'])->name('profile.cards.update');
        Route::delete('/{id}', [CardController::class, 'destroy'])->name('profile.cards.destroy');
    });

    // E-WALLET (FIX CONSISTENT)
    Route::prefix('profile/e-wallet')->group(function () {
        Route::get('/', [EwalletController::class, 'index'])->name('profile.ewallet');
        Route::post('/', [EwalletController::class, 'store'])->name('profile.ewallet.store');
        Route::put('/{id}', [EwalletController::class, 'update'])->name('profile.ewallet.update');
        Route::delete('/{id}', [EwalletController::class, 'destroy'])->name('profile.ewallet.destroy');
    });

    // RESOURCES & BOOKINGS
    Route::get('/resources', [\App\Http\Controllers\ResourceController::class, 'index']);
    Route::post('/bookings', [\App\Http\Controllers\BookingController::class, 'store']);

    // Admin only Resource management
    Route::middleware('admin')->group(function () {
        Route::post('/resources', [\App\Http\Controllers\ResourceController::class, 'store']);
        Route::put('/resources/{resource}', [\App\Http\Controllers\ResourceController::class, 'update']);
        Route::delete('/resources/{resource}', [\App\Http\Controllers\ResourceController::class, 'destroy']);
    });

    // OTHER
    Route::get('/profile/orders', function () {
        return view('profile.orders');
    })->name('profile.orders');

    /*
    |--------------------------------------------------------------------------
    | ADMIN
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // TAMBAHAN (biar sidebar tidak error)
        Route::get('/rooms', fn() => view('admin.rooms'))->name('rooms');
        Route::get('/bookings', fn() => view('admin.bookings'))->name('bookings');
        Route::get('/guests', fn() => view('admin.guests'))->name('guests');
        Route::get('/finance', fn() => view('admin.finance'))->name('finance');
    });
});

/*
|--------------------------------------------------------------------------
| TEST
|--------------------------------------------------------------------------
*/
Route::get('/send-tester', [TesterController::class, 'send']);
Route::get('/test', [TesterController::class, 'index']);
