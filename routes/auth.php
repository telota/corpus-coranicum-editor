<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Authentication routes...

Route::middleware('guest')->group(function () {

    Route::get('auth/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('auth/login', [AuthenticatedSessionController::class, 'store'])
        ->name('store-login');


});

Route::middleware('auth')->group(function () {

    Route::get('auth/reset', [UserController::class, 'getReset'])->name('reset-password');
    Route::post('auth/reset', [UserController::class, 'postReset'])->name('store-password-reset');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
