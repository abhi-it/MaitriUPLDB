<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Maitri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class MaitriApiAuth
{
    /**
     * Authenticate JWT against maitri_api guard and allow only Maitri.
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            Auth::shouldUse('maitri_api');
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return response()->json([
                    'message' => 'Token is invalid',
                    'error_type' => 'INVALID_TOKEN',
                    'status' => 'error',
                    'data' => null,
                ], 401);
            }

            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return response()->json([
                    'message' => 'Token is expired',
                    'error_type' => 'EXPIRED_TOKEN',
                    'status' => 'error',
                    'data' => null,
                ], 401);
            }

            return response()->json([
                'message' => 'Token not found',
                'error_type' => 'TOKEN_NOT_FOUND',
                'status' => 'error',
                'data' => null,
            ], 401);
        }

        if (!$user instanceof Maitri) {
            return response()->json([
                'message' => 'Maitri access only.',
                'error_type' => 'PERMISSION_DENIED',
                'status' => 'error',
                'data' => null,
            ], 403);
        }

        Auth::guard('maitri_api')->setUser($user);
        Auth::setUser($user);

        return $next($request);
    }
}
