<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\loginAndRefreshRequest\loginRequest;
use App\Http\Requests\Auth\loginAndRefreshRequest\refreshTokenRequest;
use App\Services\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;


class LoginRefreshController extends Controller
{
    /**
     * @param AuthService $authService
     */
    public function __construct(public AuthService $authService)
    {
    }

    /**
     * @param refreshTokenRequest $request
     * @return JsonResponse
     */
    public function refreshToken(refreshTokenRequest $request): JsonResponse
    {
        $token = $this->authService->refreshUserToken($request, $TokenExpireTime);
        return loggedInSuccessfully(
            $token,
            'the user refreshed successfully ',
            $TokenExpireTime
        );
    }

    /**
     * @param loginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(loginRequest $request): JsonResponse
    {
        $token = $this->authService->logInUser($request, $TokenExpireTime);
        return loggedInSuccessfully(
            $token,
            'the user logged in successfully',
            $TokenExpireTime
        );
    }


}
