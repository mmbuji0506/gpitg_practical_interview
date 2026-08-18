<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\PatientController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/products', [RatingController::class, 'index']);
    Route::post('/products/{product}/rate', [RatingController::class, 'rate']);
    Route::put('/products/{product}/rate', [RatingController::class, 'update']);
    Route::delete('/products/{product}/rate', [RatingController::class, 'remove']);

    // bonus
    Route::post('/patient-registration', [PatientController::class, 'register']);
});