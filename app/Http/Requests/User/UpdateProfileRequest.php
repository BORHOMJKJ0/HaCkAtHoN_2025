<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Helpers\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;

class UpdateProfileRequest extends FormRequest
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
            'first_name' =>'sometimes',
            'last_name' =>'sometimes',
            'email' => 'sometimes|unique:users,email,'.$this->user()->email,
            'address' => 'sometimes',
            'birthday' => 'sometimes',
            'gender' => 'sometimes',
            'phone' => 'sometimes',
        ];
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
