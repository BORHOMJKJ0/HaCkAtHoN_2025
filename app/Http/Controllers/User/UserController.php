<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\EmailVerifyRequest;
use App\Http\Requests\User\ForgetPasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResendOTPRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Services\User\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService){
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request)
    {
        return $this->userService->register($request);
    }

    public function emailVerify(EmailVerifyRequest $request)
    {
        return $this->userService->emailVerify($request);
    }

    public function login(LoginRequest $request)
    {
        return $this->userService->login($request);
    }

    public function logout(Request $request)
    {
        return $this->userService->logout($request);
    }

    public function getProfile()
    {
        return $this->userService->getProfile();
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->userService->updateProfile($request);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return $this->userService->forgetPassword($request);
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->userService->resetPassword($request);
    }

    public function resendOTP(ResendOTPRequest $request)
    {
        return $this->userService->resendOTP($request);
    }

    public function deleteAccount()
    {
        return $this->userService->deleteAccount();
    }

    public function refreshToken(Request $request)
    {
        return $this->userService->refreshToken($request);
    }
}
