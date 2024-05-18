<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\signupAndVerificationRequests\checkVerificationCodeRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\resendVerificationRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\SignupRequest;
use App\Services\AuthService;

use Carbon\Carbon;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;


class SignupController extends Controller
{
    public function __construct(public AuthService $authService)
    {
    }

    /**
     * @param SignupRequest $request
     * @return JsonResponse
     */
    public function store(SignupRequest $request,): JsonResponse
    {
        try {
            $this->authService->signup($request);
            return successOperationResponse(
                'Account created successfully. Please check your email for verification.',
                201);
        } catch (\Throwable $e) {
            return generalFailureResponse($e->getMessage());
        }
    }
    /**
     * @param checkVerificationCodeRequest $request
     * @return JsonResponse
     */
    public function checkVerificationCode(checkVerificationCodeRequest $request): JsonResponse
    {
        try {
            $token =  $this->authService->checkVerificationCode($request , $expiresIn);
            return loggedInSuccessfully(
                $token ,
                'Account verified successfully.welcome to  our app.',
                $expiresIn
            );
        } catch (\Throwable $e) {
            return generalFailureResponse($e->getMessage());
        }
    }

    /**
     * @param resendVerificationRequest $request
     * @return JsonResponse
     */
    public function resendVerificationCode(resendVerificationRequest $request): JsonResponse
    {
        try {
         $this->authService->resendVerificationCode($request);
            return successOperationResponse(
                ' verification code resend , Please check your email for verification.'
            );
        } catch (\Throwable $e) {
            return generalFailureResponse($e->getMessage());
        }
    }
}
