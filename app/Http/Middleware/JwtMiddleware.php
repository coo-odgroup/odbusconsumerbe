<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;    
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

    class JwtMiddleware extends BaseMiddleware
    {
        use ApiResponser;
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next)
        {
            try {
                $user = JWTAuth::parseToken()->authenticate();
            } catch (Exception $e) {
                if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException){
                    return $this->errorResponse(Config::get('constants.TOKEN_INVALID'),
                    Response::HTTP_OK);
                }else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException){
                    return $this->errorResponse(Config::get('constants.TOKEN_EXPIRED'),
                    Response::HTTP_OK);
                    
                }else{
                    return $this->errorResponse(Config::get('constants.TOKEN_NOTFOUND'),
                    Response::HTTP_OK);
                }
            }
            return $next($request);
        }
    }