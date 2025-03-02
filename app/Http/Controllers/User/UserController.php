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

    /**
     * @OA\Post(
     *     path="/user/register",
     *     summary="Create new account",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data",
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Nour alden"),
     *             @OA\Property(property="last_name", type="string", example="khlil"),
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="password", type="string", example="1234567890"),
     *             @OA\Property(property="password_confirmation", type="string", example="1234567890"),
     *             @OA\Property(property="phone", type="string", example="0987654321"),
     *             @OA\Property(property="address", type="string", example="Syria, Damascus, Al Sayeda Zeinab"),
     *             @OA\Property(property="birth_date", type="string", example="23/9/2004"),
     *             @OA\Property(property="gender", type="string", example="Male"),
     *             @OA\Property(property="image", type="string", format="binary", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User registered successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Nour alden"),
     *             @OA\Property(property="last_name", type="string", example="khlil"),
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="0987654321"),
     *             @OA\Property(property="address", type="string", example="Syria, Damascus, Al Sayeda Zeinab"),
     *             @OA\Property(property="birth_date", type="string", example="23/9/2004"),
     *             @OA\Property(property="gender", type="string", example="Male"),
     *             @OA\Property(property="image", type="string", format="url", example="https://example.com/images/photo.jpg")
     *         )
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function register(RegisterRequest $request)
    {
        return $this->userService->register($request);
    }

    /**
     * @OA\Post(
     *     path="/user/emailVerify",
     *     summary="Account verification using a OTP",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Account verification information",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="otp", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Email Verified successfully"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function emailVerify(EmailVerifyRequest $request)
    {
        return $this->userService->emailVerify($request);
    }

    /**
     * @OA\Post(
     *     path="/user/login",
     *     summary="Log in using email and password",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Login information",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="password", type="string", example="1234567890"),
     *             @OA\Property(property="fcm_token", type="string", example="dpTcAzVoQFil-nyJYaTJd7:APA91bGmhBPVV1MtbKFGrYcIqyMaEycdGXPzOgahYSfM3iLaYQTXQGSG5D-YomRDo7-VqvxWsJOYTYYG3Ae_btPHnZZ_b6XoNahkdo7B5bO4sk-I6AeP7_Q"),
     *             @OA\Property(property="remember_me", type="boolean", example=true)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Nour alden"),
     *             @OA\Property(property="last_name", type="string", example="khlil"),
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="0987654321"),
     *             @OA\Property(property="address", type="string", example="Syria, Damascus, Al Sayeda Zeinab"),
     *             @OA\Property(property="birth_date", type="string", example="23/9/2004"),
     *             @OA\Property(property="gender", type="string", example="Male"),
     *             @OA\Property(property="image", type="string", format="url", example="https://example.com/images/photo.jpg"),
     *             @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *         )
     *     ),
     *     @OA\Response(response=401, description="Incorrect password"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function login(LoginRequest $request)
    {
        return $this->userService->login($request);
    }

    /**
     * @OA\Post(
     *     path="/user/logout",
     *     summary="Log out of account",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Logged out successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function logout(Request $request)
    {
        return $this->userService->logout($request);
    }

    /**
     * @OA\Get(
     *     path="/user/profile",
     *     summary="Show user profile",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\Response(response=200, description="Get profile successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="first_name", type="string", example="Nour alden"),
     *              @OA\Property(property="last_name", type="string", example="khlil"),
     *              @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *              @OA\Property(property="phone", type="string", example="0987654321"),
     *              @OA\Property(property="address", type="string", example="Syria, Damascus, Al Sayeda Zeinab"),
     *              @OA\Property(property="birth_date", type="string", example="23/9/2004"),
     *              @OA\Property(property="gender", type="string", example="Male"),
     *              @OA\Property(property="image", type="string", format="url", example="https://example.com/images/photo.jpg")
     *          )
     * ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function getProfile()
    {
        return $this->userService->getProfile();
    }

    /**
     * @OA\Post(
     *     path="/user/update",
     *     summary="Update user information",
     *     tags={"User"},
     *     security={{"bearerAuth": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         description="New data",
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Nour alden"),
     *             @OA\Property(property="last_name", type="string", example="khlil"),
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="phone", type="string", example="0987654321"),
     *             @OA\Property(property="address", type="string", example="Syria, Damascus, Al Sayeda Zeinab"),
     *             @OA\Property(property="birth_date", type="string", example="23/9/2004"),
     *             @OA\Property(property="gender", type="string", example="Male"),
     *             @OA\Property(property="image", type="string", format="binary", example="")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Profile updated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="Nour alden"),
     *             @OA\Property(property="last_name", type="string", example="khlil"),
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="phone", type="string", example=""),
     *             @OA\Property(property="address", type="string", example="S0987654321yria, Damascus, Al Sayeda Zeinab"),
     *             @OA\Property(property="birth_date", type="string", example="23/9/2004"),
     *             @OA\Property(property="gender", type="string", example="Male"),
     *             @OA\Property(property="image", type="string", format="url", example="https://example.com/images/photo.jpg")
     *         )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        return $this->userService->updateProfile($request);
    }

    /**
     * @OA\Post(
     *     path="/user/forgetPassword",
     *     summary="Send a otp to the user to reset the password",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User email",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Check your email for reset password"
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function forgetPassword(ForgetPasswordRequest $request)
    {
        return $this->userService->forgetPassword($request);
    }

    /**
     * @OA\Post(
     *     path="/user/resetPassword",
     *     summary="Reset password using a otp",
     *     tags={"User"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Email, new password and otp",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com"),
     *             @OA\Property(property="password", type="string", example="1234567890"),
     *             @OA\Property(property="password_confirmation", type="string", example="1234567890"),
     *             @OA\Property(property="otp", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Password reset successfully"),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        return $this->userService->resetPassword($request);
    }

    /**
     * @OA\Post(
     *     path="/user/resendOTP",
     *     summary="Resend a otp to the user to reset the password or email verification, depending on the subject value",
     *     tags={"User"},
     *      @OA\Parameter(
     *            name="subject",
     *            in="query",
     *            required=true,
     *            description="notification subject",
     *            @OA\Schema(
     *                type="string"
     *            )
     *        ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="User email",
     *         @OA\JsonContent(
     *             @OA\Property(property="email", type="string", example="khlilnoor0@gmail.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="resend OTP successfully"
     *     ),
     *     @OA\Response(response=400, description="Bad Request")
     * )
     */
    public function resendOTP(ResendOTPRequest $request)
    {
        return $this->userService->resendOTP($request);
    }

    /**
     * @OA\Delete(
     *     path="/user/delete",
     *     summary="Delete account",
     *     security={{"bearerAuth": {}}},
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Account deleted successfully"
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function deleteAccount()
    {
        return $this->userService->deleteAccount();
    }

    /**
     * @OA\Post(
     *     path="/user/refreshToken",
     *     summary="Refresh jwt after expired it",
     *     security={{"bearerAuth": {}}},
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed",
     *         @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9..."),
     *          )
     *     ),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function refreshToken(Request $request)
    {
        return $this->userService->refreshToken($request);
    }
}
