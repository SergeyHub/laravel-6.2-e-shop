<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Class CheckCRMToken
 *
 * Checking API request for match CRM secret token
 *
 * @package App\Http\Middleware
 */

class CheckCRMToken
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
        if (env("TOKEN_BYPASS"))
        {
            return $next($request);
        }
        $token = $request->get("token");
        $date = $request->get("date");
        $time = $request->get("time");
        //check fields available
        if ($token && $date && $time) {
            $secret = config('crm.token');
            //check token match
            if ($token == md5($secret . md5($time) . $date . md5($secret))) {
                return $next($request);
            }
        }
        //return error
        return response([
            "status" => 0,
            "message" => "Sync token mismatch"
        ])->setStatusCode(403);
    }
}
