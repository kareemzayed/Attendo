<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('forgot-password', 'sendPasswordResetLink');
    Route::post('reset-password', 'resetPassword');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'me');
        Route::put('update-profile', 'updateProfile');
        Route::put('update-password', 'updatePassword');
    });
});
