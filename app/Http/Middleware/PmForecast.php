<?php

namespace App\Http\Middleware;

use App\Models\GlobalEnvironment;
use Closure;

class PmForecast
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

        $apiKey = GlobalEnvironment::getValueByKeyAndAppName('API_KEY', 'PM_FORECAST_SUMMARY');

        if (!$apiKey) {
            return response()->json([
                'status' => 'failed',
                'message' => 'api key not set please contact pic'
            ], 403);
        }

        if ($apiKey != $signatures) {
            return response()->json([
                'status' => 'failed',
                'message' => 'invalid api key'
            ], 403);
        }

        return $next($request);
    }
}
