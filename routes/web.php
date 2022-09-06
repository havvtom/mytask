<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenerateOTPController;

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

Route::get('/', function () {
    return view('welcome');
})->name('home');

//////////////////////////////////////////////
Route::post('/sendotpmail', [GenerateOTPController::class, 'sendOtp'])->name('sendOtp');
Route::view('/verifyotp', 'verifyotp')->name('verify_otp_view');
Route::post('/verifyonetimepin', [GenerateOTPController::class, 'verifyOtp'])->name('verifyotp');
//////////////////////////////////////////////

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
