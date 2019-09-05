<?php

namespace Atarek\Jwt\Middlewares;

use Closure;
use Atarek\Jwt\JwtHandler;
use Illuminate\Support\Facades\Config;

class SetDefaultProvider
{
    public function handle($request, Closure $next, $provider)
    {

        Config::set('auth.guards.api.provider', $provider);

        return $next($request);
    }
}