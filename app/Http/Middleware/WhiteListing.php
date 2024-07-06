<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WhiteListing
{
    
    public $allowedIps = ['192.168.29.242:8080','127.0.0.1'];

    //,'157.41.151.8'
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
       $server_ip= $_SERVER["HTTP_HOST"];

        if (!in_array($server_ip, $this->allowedIps)) { 
            return abort(401,'you are not authorized to access the api.Contact support@odbus.in.');
        }
    
        return $next($request);
    }
}
