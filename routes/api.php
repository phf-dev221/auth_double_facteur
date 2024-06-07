<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('get-otp', [OtpController::class, 'submitMail'])->name('submit.mail.post');
Route::get('enter-otp/{token}', [OtpController::class, 'showOtpForm'])->name('enter.otp.get');
Route::post('confirm-otp', [OtpController::class, 'confirmOtp'])->name('confirm.otp.post');

Route::post('login', [AuthController::class, 'login'])->name('login');


// Route::group([

//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {

//     Route::post('login', 'AuthController@login')->name('login');
//     Route::post('logout', 'AuthController@logout');
//     Route::post('refresh', 'AuthController@refresh');
//     Route::post('me', 'AuthController@me');

// });