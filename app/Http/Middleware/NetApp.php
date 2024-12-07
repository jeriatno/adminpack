<?php

namespace App\Http\Middleware;

use Closure;

class NetApp
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $signatures = $request->header('signature');

        if ($signatures != "N3t4pps") {
            return response()->json([
                'success' => false,
                'message' => 'Not Authorized'
            ], 403);
        }

        return $next($request);
    }
}
