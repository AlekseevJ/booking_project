<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\MailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('index');

Route::controller(HotelController::class)->prefix('hotels')->middleware('auth')->group(function () {
    Route::get('/', 'getHotels')->name('hotels.index');
    Route::get('/{hotel}', 'getHotel')->name('hotels.show');
});

Route::controller(BookingController::class)->prefix('bookings')->middleware('auth')->group(function () {
    Route::get('/', 'getBooking')->name('bookings.index');
    Route::post('/', 'storeBooking')->name('bookings.store');
    Route::get('/show', 'show')->name('bookings.show');
    Route::get('/reject', 'bookReject')->name('bookings.reject');
});

Route::get('/verify/book/{token}', [MailController::class, 'acceptBookEmail'])->name('book.accept.email')->middleware('auth');

// Authentification
Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
