<?php

namespace App\Http\Requests\Auth\signupAndVerificationRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class checkVerificationCodeRequest extends FormRequest
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
            'email' => 'required|email',
            'verification_code' => 'required'
        ];
    }
    protected function failedValidation(Validator $validator): void
    {
        $errorMessages = $validator->errors()->all();
        throw new HttpResponseException(
            response: unprocessableResponse(
                $errorMessages
            )
        );
    }
}
