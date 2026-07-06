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
                ->where('layout_name', 'Fasilitas Hotel')
                ->orderBy('position')
                ->limit(3)
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
| AUTH ROUTES (Manual — tanpa Fortify)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'store']);

    // Password Reset
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

// OTP Verification (must be logged in, but not necessarily verified)
Route::middleware(['auth'])->group(function () {
    Route::get('/email/verify', [AuthController::class, 'showOtpForm'])->name('verification.notice');
    Route::post('/email/verify-otp', [OTPVerificationController::class, 'verify'])->name('verification.verify-otp');
    Route::post('/email/resend-otp', [AuthController::class, 'resendOTP'])->name('verification.send');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
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
    Route::get('/profile/orders', [ProfileController::class, 'orders'])->name('profile.orders');
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
    Route::get('/bookings/{id}/receipt', [BookingController::class, 'receipt'])->name('bookings.receipt')->where('id', '[0-9]+');

    /*
    |--------------------------------------------------------------------------
    | BOOKING FLOW & ROLES
    |--------------------------------------------------------------------------
    */

    // --- BOOKING FLOW (Review → Store → Payment) ---
        Route::get('/bookings/review', [BookingController::class, 'review'])->name('bookings.review');
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');
        Route::get('/bookings/{id}/payment', [BookingController::class, 'payment'])->name('bookings.payment');
        Route::post('/bookings/charge', [BookingController::class, 'chargePayment'])->name('bookings.charge');
        Route::get('/bookings/{id}/status', [BookingController::class, 'checkStatus'])->name('bookings.status');
        Route::post('/bookings/process-payment', [BookingController::class, 'processPayment'])->name('bookings.processPayment');
        Route::get('/bookings/payment-instructions', [BookingController::class, 'paymentInstructions'])->name('bookings.payment.instructions');
        Route::get('/bookings/{id}/payment-success', [BookingController::class, 'paymentSuccess'])->name('bookings.payment.success');
        Route::post('/bookings/{id}/refund', [BookingController::class, 'requestRefund'])->name('bookings.refund');

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
            Route::get('/room-units', [\App\Http\Controllers\Admin\RoomUnitController::class, 'index'])->name('room_units');
            Route::get('/bookings', [\App\Http\Controllers\Admin\BookingController::class, 'index'])->name('bookings');
            Route::get('/guests', [\App\Http\Controllers\Admin\GuestController::class, 'index'])->name('guests');
            Route::get('/finance', [AdminPaymentController::class, 'index'])->name('finance');
            Route::get('/finance/export', [AdminPaymentController::class, 'export'])->name('finance.export');
            Route::post('/payments', [BookingController::class, 'processPayment'])->name('payments.store');
            Route::get('/users', [UserController::class, 'index'])->name('users.index');
            Route::put('/users/{id}/role', [UserController::class, 'updateRole'])->name('users.updateRole');
        });

        // --- FINANCE ONLY ---
        Route::middleware('finance')->group(function () {
            Route::get('/finance/dashboard', [\App\Http\Controllers\Finance\DashboardController::class, 'index'])->name('finance.dashboard');
            Route::get('/finance/export', [\App\Http\Controllers\Finance\DashboardController::class, 'export'])->name('finance.export');
            Route::post('/finance/transactions', [\App\Http\Controllers\Finance\DashboardController::class, 'store'])->name('finance.transactions.store');
            Route::put('/finance/transactions/{id}', [\App\Http\Controllers\Finance\DashboardController::class, 'update'])->name('finance.transactions.update');
            Route::delete('/finance/transactions/{id}', [\App\Http\Controllers\Finance\DashboardController::class, 'destroy'])->name('finance.transactions.destroy');
            Route::post('/finance/refunds/{id}/confirm', [\App\Http\Controllers\Finance\DashboardController::class, 'confirmRefund'])->name('finance.refunds.confirm');
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

// Midtrans Webhook Route (Publicly accessible, excluded from CSRF)
Route::post('/api/midtrans-callback', [\App\Http\Controllers\MidtransController::class, 'webhook']);