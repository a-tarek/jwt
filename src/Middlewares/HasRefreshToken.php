<?php

namespace Atarek\Jwt\Middlewares;


use Closure;
use Atarek\Jwt\JwtHandler;

class HasRefreshToken
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
        JwtHandler::instance()->handleForRefresh($request);
        
        return $next($request);
    }
}
