<?php

namespace App\Services;

use App\Events\SignupEvent;
use App\Http\Requests\Auth\loginAndRefreshRequest\loginRequest;
use App\Http\Requests\Auth\loginAndRefreshRequest\refreshTokenRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\checkVerificationCodeRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\resendVerificationRequest;
use App\Http\Requests\Auth\signupAndVerificationRequests\SignupRequest;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class AuthService
{
    /**
     * @param FileService $fileService
     */
    public function __construct(public FileService $fileService)
    {
    }

    /**
     * @param SignupRequest $request
     * @return mixed
     */
    public function signup(SignupRequest $request): mixed
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
     * @param $userVerificationCodeExpireTime
     * @return string
     * @throws Exception
     */
    public function checkVerificationCode(checkVerificationCodeRequest $request, &$userVerificationCodeExpireTime): string
    {
        $requestValidated = $request->validated();
        if (!$user = User::where('email', $requestValidated['email'])->first())
            throw new  ModelNotFoundException(
                'there is no user for this email'
            );
        if ($user->email_verified_at)
            throw new  UnprocessableEntityHttpException(
                'this email is used (verified),
                 please inter another email');
        if ($user->verification_code != $requestValidated['verification_code'])
            throw new UnprocessableEntityHttpException(
                'invalid user verification code
                ');
        $userVerificationCodeExpireTime = Carbon::parse($user->code_sent_at)->addMinutes(3);
        if (Carbon::now()->isAfter($userVerificationCodeExpireTime)) {
            throw new UnprocessableEntityHttpException(
                'the code is expired , please  try to send the code again '
            );
        } else {
            $token = $user->createToken('signup-token')->plainTextToken; // Replace with a descriptive token name
        }
        $user->email_verified_at = Carbon::now();
        $user->remember_token = $token;
        $user->save();
        return $token;
    }

    /**
     * @param refreshTokenRequest $request
     * @param $TokenExpireTime
     * @return string
     */
    public function refreshUserToken(refreshTokenRequest $request, &$TokenExpireTime): string
    {
        $request = $request->validated();
        $TokenExpireTime = Carbon::now()->addMinutes(config('sanctum.refresh_expiration'));
        if (!$user = User::where('email', $request->email)->first()) {
            throw new  ModelNotFoundException('there is no user for this email');
        }
        $user->tokens()->delete();
        $accessToken = $user->createToken(
            'refresh_token',
            '*',
            $TokenExpireTime
        );
        return $accessToken->plainTextToken;
    }

    /**
     * @param resendVerificationRequest $request
     * @return void
     * @throws Exception
     */
    public function resendVerificationCode(resendVerificationRequest $request): void
    {
        $userEmail = $request->email;
        if (!$user = User::where('email', $userEmail)->first())
            throw new  ModelNotFoundException('there is no user for this email');
        $user->verification_code = null;
        $user->code_sent_at = Carbon::now();
        event(new SignupEvent($user));
    }

    /**
     * @param loginRequest $request
     * @param $TokenExpireTime
     * @return string
     * @throws Exception|ModelNotFoundException |InvalidArgumentException
     */
    public function logInUser(loginRequest $request, &$TokenExpireTime): string
    {
        $validatedData = $request->validated(); // Access validated data from the request
        if (!$user = User::where('email', $validatedData['email'])->first())
            throw new ModelNotFoundException('there is no user for this email ');
        if (!Auth::attempt($request->only('email', 'password')))
            throw new InvalidArgumentException('Invalid credentials');
        if (!$token = $user->createToken('login-token')->plainTextToken)
            throw new Exception('there is some thing error please try again ');
        $TokenExpireTime = Carbon::now()->addMinutes(config('sanctum.expiration') / 60);
        $user->remember_token = $token;
        $user->save();
        return $token;
    }

    /**
     * @param $request
     * @return void
     */
    public function logoutUser($request)
    {

        auth()->user()->tokens()->delete(); // Revoke all user tokens
        return;
    }
}
