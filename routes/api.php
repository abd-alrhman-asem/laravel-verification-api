<?php

use App\Http\Controllers\Auth\LoginRefreshController;
use App\Http\Controllers\Auth\SignupController;
use App\Http\Requests\Auth\loginAndRefreshRequest\loginRequest;
use Illuminate\Http\Request;
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

/* Auth Routes
|  login , signup , refresh token ,logout
|  send verification code , resend verification code
*/
Route::prefix('Auth')->group(function () {
// Auth Routes
    include __DIR__ . "/Auth";
});
//fallback route handling
Route::fallback(function (){
    return notFoundResponse('invalid Url , ulr not found');
});















/*////Route::middleware('auth:sanctum')->get('/user', function (Request request) {
//    return request->user();*/
////});
//Route::post('/signup', [SignupController::class, 'store']); // Using controller class reference
//Route::post('/verifyAccount ', [SignupController::class, 'checkVerificationCode']); // Using controller class reference
//Route::post('/refresh', [LoginRefreshController::class, 'refreshToken']); // Using controller class reference
//Route::post('/resendVerificationCode ', [SignupController::class, 'resendVerificationCode']); // Using controller class reference
////Route::group(['middleware' => ['api', 'sanctum']], function () {
////});
//Route::post('/login', [LoginRefreshController::class, 'login']); // Using controller class reference
////Route::post('/login', function (loginRequest request){
////    return request;
////}); // Using controller class reference
