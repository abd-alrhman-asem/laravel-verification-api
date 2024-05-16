<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignupRequest;
use App\Services\SignupService;
use Faker\Core\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SignupController extends Controller
{

//    public function store(SignupRequest $request, SignupService $signupService){
//        return $request;
//    }
    public function store(SignupRequest $request, SignupService $signupService)
    {
//        $file = $request->file('profile_photo');
//        $fileName = microtime() . '.' . $file->getClientOriginalExtension();
//        return $file->move(storage_path('profile_photos'), $fileName);



        $signupService->signup($request);

        return response()->json([
            'message' => 'Account created successfully. Please check your email for verification.',
        ], 201);
    }
}
