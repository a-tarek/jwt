<?php

namespace Atarek\Jwt\Middlewares;

use Closure;
use Atarek\Jwt\Jwt;
use Atarek\Jwt\JwtHandler;

class HasAccessToken
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
        JwtHandler::instance()->handleForAccess($request);

        return $next($request);
    }
}
