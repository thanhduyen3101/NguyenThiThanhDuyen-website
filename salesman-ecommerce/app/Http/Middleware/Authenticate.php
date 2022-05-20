<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenBlacklistedException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class Authenticate extends Middleware
{
    /**
    //  * Get the path the user should be redirected to when they are not authenticated.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return string|null
    //  */
    // protected function redirectTo($request)
    // {
    //     if (! $request->expectsJson()) {
    //         return route('login');
    //     }
    // }

    /**
     * Exclude these routes from authentication check.
     *
     * @var array
     */
    protected $except = [
        'api/logout',
        'api/refresh',
    ];

    /**
     * Ensure the user is authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            foreach ($this->except as $excluded_route) {
                if ($request->path() === $excluded_route) {
                    return $next($request);
                }
            }
            JWTAuth::parseToken()->authenticate();


            return $next($request);
        } catch (TokenExpiredException $e) {
            return response()->json([
                'message' => 'token_expired',
                "success" => false,
            ]);
        } catch (TokenInvalidException $e) {
            return response()->json([
                'success' => false,
                'message' => 'token_invalid',
            ], 401);
        } catch (TokenBlacklistedException $e) {
            return response()->json([
                'success' => false,
                'message' => 'token_blacklisted',
            ], 401);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'token_absent',
            ], 401);

        }

    }
}
