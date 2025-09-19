<?php

use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\ProvidersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/providers/register', [ProvidersController::class, 'register']);

Route::get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke']);
