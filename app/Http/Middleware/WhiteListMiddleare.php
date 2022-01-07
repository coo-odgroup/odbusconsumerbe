<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WhiteListMiddleare
{
    
    public $allowedIps = ['192.168.1.1', '127.0.0.1'];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);

        if (!in_array($request->ip(), $this->allowedIps)) {
    
            /*
                 You can redirect to any error page. 
            */
            return response()->json(['your ip address is not valid.']);
        }
    
        return $next($request);
    }
}
