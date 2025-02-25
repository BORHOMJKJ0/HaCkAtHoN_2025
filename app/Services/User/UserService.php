<?php

namespace App\Services\User;

use App\Helpers\ResponseHelper;
use App\Http\Requests\User\EmailVerifyRequest;
use App\Http\Requests\User\ForgetPasswordRequest;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Http\Requests\User\ResendOTPRequest;
use App\Http\Requests\User\ResetPasswordRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Notifications\OTPNotification;
use App\Repositories\UserRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException;
use PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Storage;

class UserService
{
    protected $userRepository;
    protected $imageService;

    public function __construct(UserRepository $userRepository, ImageService $imageService)
    {
        $this->userRepository = $userRepository;
        $this->imageService = $imageService;
    }
    public function register(RegisterRequest $request)
    {
        $inputs = $request->except('password_confirmation');
        if($request->hasFile('image')){
            $inputs['image'] = $this->imageService->upload($request->file('image'));
        }
        $user = $this->userRepository->create($inputs);
        $user->notify(new OTPNotification('emailVerify'));
        $data = [
            'user' => UserResource::make($user)
        ];
        return ResponseHelper::jsonResponse(
            $data,
            'User registered successfully! ,check your email for verification code',
            201
        );
    }

    public function emailVerify(EmailVerifyRequest $request)
    {
        $email = $request->input('email');
        $this->userRepository->markEmailAsVerified($email);
        return ResponseHelper::jsonResponse([], 'Email Verified successfully, You can login now',);
    }

    public function login(LoginRequest $request)
    {
        $inputs = $request->all();

        if (isset($inputs['remember_me']) && $inputs['remember_me']) {
            JWTAuth::factory()->setTTL(60 * 24 * 30 * 3);
        }

        $credentials = $request->only('email', 'password');
        $token = JWTAuth::attempt($credentials);

        if (! $token) {
            return ResponseHelper::jsonResponse([], 'Incorrect password', 401, false);
        }

        $user = JWTAuth::user();
        $this->userRepository->setFcmToken($inputs['fcm_token']);

        $data = [
            'user' => UserResource::make($user),
            'token' => $token,
        ];

        return ResponseHelper::jsonResponse($data, 'Logged in successfully');
    }

    public function logout(Request $request)
    {
        $token = $request->header('Authorization');
        JWTAuth::invalidate($token);

        return ResponseHelper::jsonResponse([], 'Logged out successfully!');
    }

    public function getProfile()
    {
        $user = JWTAuth::user();
        $data = [
            'user' => UserResource::make($user),
        ];
        return ResponseHelper::jsonResponse($data, 'Get profile successfully');
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $inputs = $request->all();
        $user = JWTAuth::user();
        if ($request->hasFile('image')) {
            $inputs['image'] = $this->imageService->update($user->image, $request->file('image'));
        }
        $user = $this->userRepository->update($inputs);
        $data = [
            'user' => UserResource::make($user),
        ];
        return ResponseHelper::jsonResponse($data, 'profile updated successfully', 201);
    }

    public function forgetPassword(ForgetPasswordRequest $request)
    {
        $email = $request->email;
        $user = $this->userRepository->findByEmail($email);
        if (! $user) {
            return ResponseHelper::jsonResponse([], 'This email is not found', 400, false);
        }
        $user->notify(new OTPNotification('resetPassword'));
        return ResponseHelper::jsonResponse([], 'Check your email for reset password!');
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $data = $request->all();
        $this->userRepository->updatePassword($data['email'], $data['password']);
        return ResponseHelper::jsonResponse([], 'Password reset successfully!');
    }

    public function resendOTP(ResendOTPRequest $request)
    {
        $email = $request->input('email');
        $user = $this->userRepository->findByEmail($email);
        if(!$user){
            return ResponseHelper::jsonResponse([], 'This email is not found', 400, false);
        }
        $user->notify(new OTPNotification($request->query('subject')));
        return ResponseHelper::jsonResponse([], 'resend OTP successfully!');
    }

    public function deleteAccount()
    {
        $this->userRepository->delete();
        return ResponseHelper::jsonResponse([], 'Account deleted successfully!');
    }

    public function refreshToken(Request $request)
    {
        try {
            $new_token = JWTAuth::parseToken()->refresh();
        } catch (TokenInvalidException $ex) {
            return ResponseHelper::jsonResponse([], 'Invalid token', 401, false);
        } catch (TokenExpiredException $ex) {
            return ResponseHelper::jsonResponse([], 'Expired token', 401, false);
        } catch (JWTException $ex) {
            return ResponseHelper::jsonResponse([], 'Unauthenticated', 401, false);
        }
        $data = [
            'token' => $new_token,
        ];

        return ResponseHelper::jsonResponse($data, 'Token refreshed');
    }
}
