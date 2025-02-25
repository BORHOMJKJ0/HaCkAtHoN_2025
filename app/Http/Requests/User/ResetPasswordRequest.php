<?php

namespace App\Http\Requests\User;

use Ichtrojan\Otp\Otp;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;

class ResetPasswordRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required',
            'otp' => ['required', 'numeric', 'digits:4', function($attribute, $value, $fail) {
                $otp = new Otp();
                $isValid = $otp->validate(request('email'), $value);

                if (!$isValid->status) {
                    $fail('The provided OTP is invalid.');
                }
        }]];
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            ResponseHelper::jsonResponse(
                $validator->errors(),
                'Validation failed',
                400,
                false
            )
        );
    }
}
