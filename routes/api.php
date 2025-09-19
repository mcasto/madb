<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProvidersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Provider Registration
Route::post('/providers/register', [ProvidersController::class, 'register']);
Route::post('/providers/resend-verification-email', [ProvidersController::class, 'resendVerificationEmail']);
Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke']);
// ---

// Provider Auth
Route::post('/providers/login', [ProvidersController::class, 'login']);
