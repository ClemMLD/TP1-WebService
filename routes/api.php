<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\DashboardController;

Route::match(['POST', 'GET'], '/stringCheckout', [JwtController::class, 'generateStripeCheckout']);
Route::match(['POST', 'GET'], '/sendMail/{transactionId}', [MailController::class, 'sendMail'])
    ->name("send-success-mail");
Route::match(['POST', 'GET'], '/succeededPayment', [DashboardController::class, 'succeededPayment']);
