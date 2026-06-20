<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\OTPVerificationController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\RoomController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\CardController;
use App\Http\Controllers\User\EwalletController;
use App\Http\Controllers\User\PageController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RoomController as AdminRoomController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\UserController;

/*
|--------------------------------------------------------------------------
| PUBLIC & INFORMATIONAL ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $banner = \App\Models\Banner::where('is_active', true)
                ->where('layout_name', 'Dashboard')
                ->inRandomOrder()
                ->limit(1)
                ->first();
                
    $exploreBanners = \App\Models\Banner::where('is_active', true)
                ->where('layout_name', 'Dashboard Explore')
                ->orderBy('position')
                ->limit(4)
                ->get();
                
    return view('welcome', compact('banner', 'exploreBanners'));
})->name('home');

Route::get('/how-to-book', [PageController::class, 'howToBook'])->name('how-to-book');
Route::get('/contact', [PageController::class, 'contactUs'])->name('contact');
Route::get('/help', [PageController::class, 'helpCenter'])->name('help');
Route::get('/about', [PageController::class, 'aboutUs'])->name('about');
Route::get('/privacy', [PageController::class, 'privacyNotice'])->name('privacy');
Route::get('/terms', [PageController::class, 'termsAndConditions'])->name('terms');

/*
|--------------------------------------------------------------------------
| AUTH ROUTES (Managed by Fortify)
|--------------------------------------------------------------------------
*/
// Login, register, logout, etc. are automatically handled by Fortify.

// Custom OTP Verification Route
Route::middleware(['auth'])->group(function () {
    Route::post('/email/verify-otp', [OTPVerificationController::class, 'verify'])
        ->name('verification.verify-otp');
});

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Must be logged in and verified)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified'])->group(function () {

    // --- PROFILE ---
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/orders', function () {
        return view('profile.orders');
    })->name('profile.orders');
    Route::get('/profile/refunds', function () {
        return view('profile.refunds');
    })->name('profile.refunds');

    // --- CARDS ---
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

    // --- ROOMS (Browse & Search) ---
    Route::get('/rooms', [RoomController::class, 'index'])->name('rooms.index');
    Route::get('/rooms/{room}', [RoomController::class, 'show'])->name('rooms.show');

    // --- BOOKINGS ---
    Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('bookings.show')->where('id', '[0-9]+');

    /*
    |--------------------------------------------------------------------------
    | BOOKING FLOW & ROLES
    |--------------------------------------------------------------------------
    */

    // --- BOOKING FLOW (Review → Store → Payment) ---
        Route::get('/bookings/review', [BookingController::class, 'review'])->name('bookings.review');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{id}/payment', [BookingController::class, 'payment'])->name('bookings.payment');
        Route::post('/bookings/process-payment', [BookingController::class, 'processPayment'])->name('bookings.processPayment');
        Route::get('/bookings/payment-instructions', fn() => view('user.instruksi-pembayaran'))->name('bookings.payment.instructions');
        Route::get('/bookings/payment-success', fn() => view('user.sukses-pembayaran'))->name('bookings.payment.success');

        /*
        |--------------------------------------------------------------------------
        | ADMIN ONLY
        |--------------------------------------------------------------------------
        */
        Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/kamar', [AdminRoomController::class, 'index'])->name('kamar');
            Route::post('/rooms', [AdminRoomController::class, 'store'])->name('rooms.store');
            Route::put('/rooms/{room}', [AdminRoomController::class, 'update'])->name('rooms.update');
            Route::delete('/rooms/{room}', [AdminRoomController::class, 'destroy'])->name('rooms.destroy');
            Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings');
            Route::get('/guests', [\App\Http\Controllers\Admin\GuestController::class, 'index'])->name('guests');
            Route::get('/finance', [AdminPaymentController::class, 'index'])->name('finance');
            Route::post('/payments', [BookingController::class, 'processPayment'])->name('payments.store');
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        });

        // --- FINANCE ONLY ---
        Route::middleware('finance')->group(function () {
            Route::get('/finance/dashboard', [\App\Http\Controllers\Finance\DashboardController::class, 'index'])->name('finance.dashboard');
            Route::post('/finance/transactions', [\App\Http\Controllers\Finance\DashboardController::class, 'store'])->name('finance.transactions.store');
        });

        // --- CONTENT CREATOR ONLY ---
        Route::middleware('content_creator')->group(function () {
            Route::get('/content/dashboard', [\App\Http\Controllers\ContentCreator\DashboardController::class, 'index'])->name('content.dashboard');
            Route::post('/content/upload', [\App\Http\Controllers\ContentCreator\DashboardController::class, 'upload'])->name('content.upload');
    });
});

/*
|--------------------------------------------------------------------------
| TESTING ROUTES (Deprecated — for development only)
|--------------------------------------------------------------------------
*/
// @deprecated These routes are for development/testing only.
// Route::get('/send-tester', [TesterController::class, 'send']);
// Route::get('/test', [TesterController::class, 'index']);