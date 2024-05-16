<?php

namespace App\Services;

use App\Events\SignupEvent;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignupService
{
    public function __construct(public FileService $fileService)
    {
    }

    public function signup($request,)
    {
        $validatedData = $request->validated(); // Get all validated data

        $photoPath = 'app/public/profiles_photos';
        $CPath = 'app/certificates';
        $user = User::create([
            'email' => $validatedData['email'], // Access specific field
            'phone_number' => $validatedData['phone_number'] ?? null, // Optional field
            'username' => $validatedData['username'],
            'password' => Hash::make($validatedData['password']),
            'certificate' => $this->fileService->handleFile($request, 'certificate',  $CPath),
            'profile_photo' => $this->fileService->handleFile($request, 'profile_photo',$photoPath ),
        ]);
        event(new SignupEvent($user));
        return $user;
    }
}
