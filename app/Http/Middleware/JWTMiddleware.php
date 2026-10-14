<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Maitri;
use App\Models\FarmerUser;
use App\Traits\V2\FormatResponseTraitV2;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
{
    use FormatResponseTraitV2;

    protected array $allowedGuards = [
        'farmer_api' => FarmerUser::class,
        'maitri_api' => Maitri::class,
    ];

    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if (! $token) {
            return $this->errorResponse('Token not found', 'TOKEN_NOT_FOUND', 401);
        }

        try {
            $payload = JWTAuth::setToken($token)->getPayload();
        } catch (TokenExpiredException $e) {
            return $this->errorResponse('Token is expired', 'EXPIRED_TOKEN', 401);
        } catch (TokenInvalidException $e) {
            return $this->errorResponse('Token is invalid', 'INVALID_TOKEN', 401);
        } catch (Exception $e) {
            return $this->errorResponse('Token not found', 'TOKEN_NOT_FOUND', 401);
        }

        $guard = $payload->get('guard');

        if (! $guard || ! isset($this->allowedGuards[$guard])) {
            return $this->errorResponse('Invalid token: missing guard claim', 'INVALID_TOKEN', 401);
        }

        try {
            $user = Auth::guard($guard)->setToken($token)->authenticate();
        } catch (Exception $e) {
            return $this->errorResponse('Authentication failed: ' . $e->getMessage(), 'UNAUTHENTICATED', 401);
        }

        $expectedModel = $this->allowedGuards[$guard];

        if (! $user instanceof $expectedModel) {
            return $this->errorResponse(
                'Access denied: got ' . ($user ? get_class($user) : 'null')
                . ', expected ' . $expectedModel, 'ACCESS_DENIED',
                403
            );
        }

        if (! $expectedModel::find($user->id)) {
            return $this->errorResponse('User not found or has been deleted.', 'DATA_NOT_FOUND', 403);
        }

        Auth::guard($guard)->setUser($user);
        Auth::shouldUse($guard);
        Auth::setUser($user);
        $request->attributes->set('auth_guard', $guard);

        return $next($request);
    }
}