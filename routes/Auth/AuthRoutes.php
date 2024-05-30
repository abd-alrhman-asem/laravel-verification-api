<?php

use App\Http\Controllers\Auth\LoginRefreshController;
use App\Http\Controllers\Auth\SignupController;

use Illuminate\Support\Facades\Route;


Route::controller(SignupController::class)
    ->group(function () {
        Route::middleware('guest:sanctum')
            ->group(function () {
                Route::post('signup', 'store')
                    ->middleware('throttle:sendCodeLimiter');
                Route::post('resendVerificationCode', 'resendVerificationCode')
                    ->middleware('throttle:sendCodeLimiter');
                Route::post('verifyAccount', 'checkVerificationCode');
            });
    });
Route::controller(LoginRefreshController::class)
    ->group(function () {
        Route::middleware('guest:sanctum')
            ->group(function () {
                Route::post('login', 'login');
            });
        Route::middleware('auth: sanctum')
            ->group(function () {
                Route::post('logout', 'logout')->name('auth.logout');
                Route::post('refresh', 'refreshToken');
            });

    });
