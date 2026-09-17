<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\FarmerUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class FarmerApiAuth
{
    /**
     * Authenticate JWT against farmer_api guard and allow only FarmerUser.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            Auth::shouldUse('farmer_api');
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'message' => 'Token is invalid',
                    'status' => 'error',
                    'data' => [],
                ], 401);
            }

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'message' => 'Token is expired',
                    'status' => 'error',
                    'data' => [],
                ], 401);
            }

            return response()->json([
                'message' => 'Token not found',
                'status' => 'error',
                'data' => [],
            ], 401);
        }

        if (!$user instanceof FarmerUser) {
            return response()->json([
                'message' => 'Farmer access only.',
                'status' => 'error',
                'data' => [],
            ], 403);
        }

        Auth::guard('farmer_api')->setUser($user);
        Auth::setUser($user);

        return $next($request);
    }
}
