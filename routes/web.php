<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\EwalletController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PilihKamarController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\AdminController\TesterController;
use App\Http\Controllers\user\PemesananController;

/*
|--------------------------------------------------------------------------
| PUBLIC & INFORMATIONAL ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('landing');

Route::get('/cara-pesan', [PageController::class, 'caraPesan'])->name('cara-pesan');
Route::get('/hubungi-kami', [PageController::class, 'hubungiKami'])->name('hubungi-kami');
Route::get('/pusat-bantuan', [PageController::class, 'pusatBantuan'])->name('pusat-bantuan');
Route::get('/tentang-kami', [PageController::class, 'tentangKami'])->name('tentang-kami');
Route::get('/pemberitahuan-privasi', [PageController::class, 'privasi'])->name('privasi');
Route::get('/syarat-ketentuan', [PageController::class, 'syaratKetentuan'])->name('syarat-ketentuan');

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
    Route::get('/booking', [BookingController::class, 'index'])->name('booking');
    Route::get('/user/booking', [BookingController::class, 'index'])->name('user.booking');
    Route::post('/booking', [BookingController::class, 'store'])->name('bookings.store');
    Route::get('/user/booking/{id}', [BookingController::class, 'show'])->name('bookings.show');

    // --- USER ROUTE GROUP (Review, Pilih Pembayaran, Instruksi, & Sukses) ---
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/review-pemesanan', [PemesananController::class, 'review'])->name('review');
        Route::post('/review-pemesanan', [PemesananController::class, 'store'])->name('review.store');

        Route::get('/pembayaran/{id}', [PemesananController::class, 'pembayaran'])->name('pembayaran');

        // Halaman Perantara: Instruksi Pembayaran (Menampilkan Nomor VA / Rekening / Kode Kasir)
        Route::get('/instruksi-pembayaran', function () {
            return view('user.instruksi-pembayaran');
        })->name('pembayaran.instruksi');

        // Halaman Akhir: Status Sukses Terverifikasi (Diakses setelah klik "Saya Sudah Bayar")
        Route::get('/sukses-pembayaran', function () {
            return view('user.sukses-pembayaran');
        })->name('pembayaran.sukses');
    });

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

    // --- PILIH KAMAR ---
    Route::get('/component', [PilihKamarController::class, 'index'])->name('bookingdua.index');
    Route::get('/pilih-kamar', [PilihKamarController::class, 'index'])->name('pilih-kamar');
    Route::get('/resources/{resource}', [ResourceController::class, 'show'])->name('pilih-kamar.show');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ONLY
    |--------------------------------------------------------------------------
    */
    Route::middleware('admin')->group(function () {
        Route::post('/resources', [ResourceController::class, 'store'])->name('resources.store');
        Route::put('/resources/{resource}', [ResourceController::class, 'update'])->name('resources.update');
        Route::delete('/resources/{resource}', [ResourceController::class, 'destroy'])->name('resources.destroy');

        Route::prefix('admin')->name('admin.')->group(function () {
            Route::post('/payments', [PembayaranController::class, 'store'])->name('payments.store');
            Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
            Route::get('/rooms', fn() => view('admin.kamar'))->name('rooms');
            Route::get('/bookings', fn() => view('admin.bookings'))->name('bookings');
            Route::get('/guests', fn() => view('admin.guests'))->name('guests');
            Route::get('/finance', [AdminPaymentController::class, 'index'])->name('finance');
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