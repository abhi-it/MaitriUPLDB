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

        if (!$user instanceof Maitri) {
            return response()->json([
                'message' => 'Maitri access only.',
                'status' => 'error',
                'data' => [],
            ], 403);
        }

        Auth::guard('maitri_api')->setUser($user);
        Auth::setUser($user);

        return $next($request);
    }
}
