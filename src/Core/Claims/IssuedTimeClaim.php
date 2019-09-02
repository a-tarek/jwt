<?php

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Core\Contracts\ClaimLoader;

class IssuedTimeClaim implements ClaimLoader
{
    public static function load($tokenType): array
    {
        return ['iat'=>time()];
    }
}