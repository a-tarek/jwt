<?php

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Core\Contracts\ClaimLoader;

class NotBeforeTimeClaim implements ClaimLoader
{
    public static function load($tokenType): array
    {
        return [];
    }
}