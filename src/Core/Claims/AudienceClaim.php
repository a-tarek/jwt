<?php

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Contracts\Claim;


class AudienceClaim implements ClaimLoader
{
    public static function load($tokenType):array
    { 
        return [];
    }
}
