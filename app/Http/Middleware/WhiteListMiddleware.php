<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhiteListMiddleware
{
    
    public $allowedIps = ['159.65.159.90','127.0.0.1'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        Log:: info($request->ip());
        //return $next($request);



        if (!in_array($request->ip(), $this->allowedIps)) {
    
            /*
                 You can redirect to any error page. 
            */
            return response()->json(['you are not authorized to access the api.Contact support@odbus.in.']);
        }
    
        return $next($request);
    }
}
