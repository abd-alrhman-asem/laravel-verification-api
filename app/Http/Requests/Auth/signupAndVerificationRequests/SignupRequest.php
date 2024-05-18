<?php

namespace App\Http\Requests\Auth\signupAndVerificationRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;


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
     * @return array<string, ValidationRule|array|string>
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
    protected function failedValidation(Validator $validator): void
    {
        $errorMessage = $validator->errors()->all();
        $errorMessage = (string)array_pop($errorMessage);
        throw new HttpResponseException(
            response: unprocessableResponse(
                (array)$errorMessage
            )
        );
    }

}
