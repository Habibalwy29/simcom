<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController; // Pastikan controller diimpor
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// ==> TAMBAHKAN RUTE RESET PASSWORD INI DI SINI <==
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
// ==> AKHIR DARI BLOK RUTE RESET PASSWORD <==

// Halaman Publik
Route::get('/', [AppController::class, 'landing'])->name('landing');

// Halaman yang membutuhkan otentikasi (gunakan middleware 'auth')
Route::middleware(['auth'])->group(function () {
    Route::get('/main-menu', [AppController::class, 'mainMenu'])->name('mainMenu');
    Route::get('/calorie-calculator', [AppController::class, 'calorieCalculator'])->name('calorieCalculator');
    Route::get('/diet-ordering', [AppController::class, 'dietOrdering'])->name('dietOrdering');
    Route::get('/payment', [AppController::class, 'payment'])->name('payment');
    Route::get('/account', [AppController::class, 'account'])->name('account');

    // Route untuk proses form
    Route::post('/calorie-calculator/calculate', [AppController::class, 'calculateCalories'])->name('calculateCalories');
    
    // Route untuk keranjang belanja dan pemesanan diet
    Route::post('/diet-ordering/add-to-cart', [AppController::class, 'addToCart'])->name('addToCart');
    // BARIS BERIKUT DIUBAH:
    Route::post('/cart/update-quantity', [AppController::class, 'updateCartQuantity'])->name('cart.updateQuantity');
    Route::post('/cart/remove', [AppController::class, 'removeFromCart'])->name('cart.remove');
    
    Route::post('/payment/process', [AppController::class, 'processPayment'])->name('processPayment');
    Route::post('/account/update-profile', [AppController::class, 'updateProfile'])->name('updateProfile');
});