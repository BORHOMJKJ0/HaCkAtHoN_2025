<?php

namespace App\Http\Middleware;

use App\Helpers\ResponseHelper;
use App\Models\User\User;
use Closure;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;

class checkEmailVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = JWTAuth::user();
        if(!$user){
            $user = User::where('email', $request->email)->first();
        }
        if(!$user->email_verified_at)
            return ResponseHelper::jsonResponse([],'Your email is not verified.', 401, false);
        return $next($request);
    }
}
