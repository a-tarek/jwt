<?php

namespace Atarek\Jwt\Middlewares;

use Closure;
use Atarek\Jwt\JwtHandler;

class HasToken
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
        JwtHandler::instance()->handle($request);

        return $next($request);
    }
}
