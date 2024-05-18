<?php

namespace App\Services;

use App\Events\SignupEvent;
use App\Http\Requests\Auth\signupAndVerificationRequests\checkVerificationCodeRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\resendVerificationRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\SignupRequest;
use App\Listeners\SendEmailVerificationCodeListener;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function __construct(public FileService $fileService)
    {
    }

    public function signup(SignupRequest $request)
    {
        $validatedData = $request->validated(); // Get all validated data

        $photoPath = 'app/public/profiles_photos';
        $CPath = 'app/certificates';
        $user = User::create([
            'email' => $validatedData['email'], // Access specific field
            'phone_number' => $validatedData['phone_number'] ?? null, // Optional field
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'certificate' => $this->fileService->handleFile($request, 'certificate', $CPath),
            'profile_photo' => $this->fileService->handleFile($request, 'profile_photo', $photoPath),

        ]);
        event(new SignupEvent($user));

        return $user;
    }


    /**
     * @param checkVerificationCodeRequest $request
     * @return string
     * @throws Exception
     */
    public function checkVerificationCode(checkVerificationCodeRequest $request , &$userVerificationCodeExpireTime): string
    {

        if (!$user = User::where('email', $request->email)->first())
            throw new  Exception('there is no user for this email');
        if ($user->email_verified_at)
            throw new  Exception('this email is used (verified) please inter another email ');
        if ($user->verification_code != $request->verification_code)
            throw new Exception('invalid user verification code ');
        $userVerificationCodeExpireTime =Carbon::parse( $user->code_sent_at)->addMinutes(3);
        if (Carbon::now()->isAfter($userVerificationCodeExpireTime)) {
            throw new Exception('the code is expired , please  try to send the code again ');
        } else {
            $token = $user->createToken('my-api-token')->plainTextToken; // Replace with a descriptive token name
        }
        $user->email_verified_at = Carbon::now();
        $user->remember_token = $token;
        $user->save();
        return $token;
    }

    /**
     * @param $request
     * @param $TokenExpireTime
     * @return string
     */
    public function refreshUserToken($request, &$TokenExpireTime): string
    {
        $TokenExpireTime = Carbon::now()->addMinutes(config('sanctum.refresh_expiration'));
        $user = User::where('email', $request->email)->first();
        $user->tokens()->delete();
        $accessToken = $user->createToken(
            'refresh_token',
            '*',
            $TokenExpireTime
        );
        return $accessToken->plainTextToken;
    }

    public function resendVerificationCode(resendVerificationRequest $request): void
    {
        $userEmail = $request->email;
        if (!$user = User::where('email', $userEmail)->first())
            throw new  Exception('there is no user for this email');
        $user->verification_code = null;
        $user->code_sent_at = Carbon::now();
        event(new SignupEvent($user));
    }
}
