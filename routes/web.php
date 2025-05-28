<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppController; // Pastikan controller diimpor
use App\Http\Controllers\Auth\LoginController; // Untuk Auth::routes()
use App\Http\Controllers\Auth\RegisterController; // Untuk Auth::routes()

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Auth Routes (Laravel Breeze/Jetstream/UI akan membuatnya otomatis)
// Untuk contoh ini, kita definisikan secara manual jika tidak menggunakan starter kit
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Halaman Publik
Route::get('/', [AppController::class, 'landing'])->name('landing');

// Halaman yang membutuhkan otentikasi (gunakan middleware 'auth')
Route::middleware(['auth'])->group(function () {
    Route::get('/main-menu', [AppController::class, 'mainMenu'])->name('mainMenu');
    Route::get('/calorie-calculator', [AppController::class, 'calorieCalculator'])->name('calorieCalculator');
    Route::get('/diet-ordering', [AppController::class, 'dietOrdering'])->name('dietOrdering');
    Route::get('/payment', [AppController::class, 'payment'])->name('payment');
    Route::get('/account', [AppController::class, 'account'])->name('account');

    // Contoh rute untuk memproses form (jika menggunakan Blade biasa)
    Route::post('/calorie-calculator/calculate', [AppController::class, 'calculateCalories'])->name('calculateCalories');
    Route::post('/diet-ordering/add-to-cart', [AppController::class, 'addToCart'])->name('addToCart');
    Route::post('/payment/process', [AppController::class, 'processPayment'])->name('processPayment');
    Route::post('/account/update-profile', [AppController::class, 'updateProfile'])->name('updateProfile');
});

// Redirect default Laravel jika Anda tidak ingin menggunakan route '/'
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');