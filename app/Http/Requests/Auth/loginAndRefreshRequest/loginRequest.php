<?php

namespace App\Http\Requests\Auth\loginAndRefreshRequest;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class loginRequest extends FormRequest
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
            'phone_number' => 'required',
            'password' => 'required|string|min:8', // Password rules and confirmation
        ];
    }

    /**
     * @param Validator $validator
     * @return void
     */
    protected function failedValidation(Validator $validator): void
    {
        $errorMessage = $validator->errors()->all();
        throw new HttpResponseException(
            response: unprocessableResponse(
                $errorMessage
            )
        );
    }
}
