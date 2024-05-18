<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class LoginRefreshController extends Controller
{
    public function refreshToken(
        Request     $request,
        AuthService $authService
    ): JsonResponse
    {
        try {
            $token = $authService->refreshUserToken($request, $TokenExpireTime);
            return loggedInSuccessfully(
                $token,
                'the user refreshed successfully ',
                $TokenExpireTime
            );
        } catch (\Throwable $e) {
            return generalFailureResponse($e->getMessage()); // this for app in development
            //return generalFailureResponse('general error please try again ! '); // this for app in production
        }
    }


}
