<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
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
            'password' => 'required',
            'remember_me' => 'required|boolean',
            'fcm_token' => 'required',
        ];
    }

    /**
     * Prepare the data for validation by processing specific fields.
     */
    public function prepareForValidation()
    {
        // معالجة remember_me لتحويلها إلى قيمة boolean
        if ($this->has('remember_me')) {
            $this->merge([
                'remember_me' => filter_var($this->remember_me, FILTER_VALIDATE_BOOLEAN),
            ]);
        }
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
