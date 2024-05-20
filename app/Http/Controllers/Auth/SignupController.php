<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\signupAndVerificationRequests\checkVerificationCodeRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\resendVerificationRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\SignupRequest;
use App\Services\AuthService;
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
            $this->authService->signup($request);
            return successOperationResponse(
                'Account created successfully. Please check your email for verification.',
                201);
    }

    /**
     * @param checkVerificationCodeRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function checkVerificationCode(checkVerificationCodeRequest $request): JsonResponse
    {
            $token =  $this->authService->checkVerificationCode($request , $expiresIn);
            return loggedInSuccessfully(
                $token ,
                'Account verified successfully.welcome to  our app.',
                $expiresIn
            );
    }
    /**
     * @param resendVerificationRequest $request
     * @return JsonResponse
     */
    public function resendVerificationCode(resendVerificationRequest $request): JsonResponse
    {
         $this->authService->resendVerificationCode($request);
            return successOperationResponse(
                ' verification code resend , Please check your email for verification.'
            );
    }
}
