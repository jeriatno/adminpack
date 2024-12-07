<?php

namespace App\Http\Middleware;

use Closure;

class XMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->header('X-MIDDLEWARE-KEY') != config('app.X_MIDDLEWARE_KEY')) {
            return response()->json(['error' => 'Unauthorization'], 401);
        }

        return $next($request);
    }
}
