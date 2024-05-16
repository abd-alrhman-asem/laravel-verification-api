<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string', // Optional field
            'username' => 'required|string|unique:users,username',
            'profile_photo' => 'nullable|file|image|max:2048', // Validate profile photo size and type
            'certificate' => 'nullable|file|mimetypes:application/pdf|max:10240', // Validate certificate type and size
            'password' => 'required|string|min:8', // Password rules and confirmation
        ];
    }
}
