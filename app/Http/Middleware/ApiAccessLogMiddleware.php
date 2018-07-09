<?php

namespace App\Http\Middleware;

use Closure;
use App\ApiAccessLog;

class ApiAccessLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        $log = ApiAccessLog::create([
            'ip' => $_SERVER['REMOTE_ADDR'],
            'full_url' => $request->fullUrl(),
            'type' => $request->method()
        ]);
        
        return $next($request);
    }
}
