<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

// Laravel 8 & 9
Route::post('/pay', [PaymentController::class, 'redirectToGateway'])->name('pay');
// Laravel 8 & 9
Route::get('/payment/callback', [PaymentController::class, 'handleGatewayCallback']);