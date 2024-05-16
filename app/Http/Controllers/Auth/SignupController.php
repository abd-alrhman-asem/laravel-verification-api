<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Services\SignupService;
use Illuminate\Http\JsonResponse;

class SignupController extends Controller
{
    /**
     * @param SignupRequest $request
     * @param SignupService $signupService
     * @return JsonResponse
     */
    public function store(SignupRequest $request, SignupService $signupService): JsonResponse
    {
        try {
            $signupService->signup($request);
            return successOperationResponse(
                'Account created successfully. Please check your email for verification.',
                201);
        } catch (\Throwable $e) {
            // this for app in development
            return generalFailureResponse($e->getMessage());
            // this for app in production
            //return generalFailureResponse('general error please try again !  ');
        }
    }
}
