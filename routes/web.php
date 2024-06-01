<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JwtController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::post('/form', [JwtController::class, 'generateStripeCheckout']);
Route::get('/payment_success', [JwtController::class, 'paymentSuccess']);
Route::get('/payment_failed', [JwtController::class, 'paymentFailed']);
Route::get("/dashboard", [DashboardController::class, 'index']);
Route::post("/dashboard/{sessionId}/capture_full", [DashboardController::class, 'captureFull']);
Route::post("/dashboard/{sessionId}/capture_partials", [DashboardController::class, 'capturePartial']);
Route::post("/dashboard/{sessionId}/refund", [DashboardController::class, 'refundPayment']);
