<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Maitri;
use App\Models\FarmerUser;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
{
    protected array $allowedGuards = [
        'farmer_api' => FarmerUser::class,
        'maitri_api' => Maitri::class,
    ];

    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (! $token) {
            return $this->error('Token not found', 401);
        }

        try {
            $payload = JWTAuth::setToken($token)->getPayload();
        } catch (TokenExpiredException $e) {
            return $this->error('Token is expired', 401);
        } catch (TokenInvalidException $e) {
            return $this->error('Token is invalid', 401);
        } catch (Exception $e) {
            return $this->error('Token not found', 401);
        }

        $guard = $payload->get('guard');

        if (! $guard || ! isset($this->allowedGuards[$guard])) {
            return $this->error('Invalid token: missing guard claim', 401);
        }

        try {
            $user = Auth::guard($guard)->setToken($token)->authenticate();
        } catch (Exception $e) {
            return $this->error('Authentication failed: ' . $e->getMessage(), 401);
        }

        $expectedModel = $this->allowedGuards[$guard];

        if (! $user instanceof $expectedModel) {
            return $this->error(
                'Access denied: got ' . ($user ? get_class($user) : 'null')
                . ', expected ' . $expectedModel,
                403
            );
        }

        if (! $expectedModel::find($user->id)) {
            return $this->error('User not found or has been deleted.', 403);
        }

        Auth::guard($guard)->setUser($user);
        Auth::shouldUse($guard);
        Auth::setUser($user);
        $request->attributes->set('auth_guard', $guard);

        return $next($request);
    }

    protected function error(string $message, int $code)
    {
        return response()->json([
            'message' => $message,
            'status'  => 'error',
            'data'    => [],
        ], $code);
    }
}