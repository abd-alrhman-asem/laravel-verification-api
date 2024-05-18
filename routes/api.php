<?php

use App\Http\Controllers\Auth\LoginRefreshController;
use App\Http\Controllers\Auth\SignupController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::post('/signup', [SignupController::class, 'store']); // Using controller class reference
Route::post('/verifyAccount ', [SignupController::class, 'checkVerificationCode']); // Using controller class reference
//Route::post('/resendVerificationCode ', [SignupController::class, 'resendVerificationCode']); // Using controller class reference
Route::post('/refresh', [LoginRefreshController::class, 'refreshToken']); // Using controller class reference
//Route::group(['middleware' => ['api', 'sanctum']], function () {
//});
Route::post('/resendVerificationCode ', [SignupController::class, 'resendVerificationCode']); // Using controller class reference
