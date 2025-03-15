<?php

namespace App\Http\Requests\User;

use App\Http\Requests\BaseRequest;

class RegisterRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|unique:users,first_name',
            'last_name' => 'required|string|unique:users,last_name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required|same:password',
            'image' => 'sometimes|nullable',
        ];
    }
}
