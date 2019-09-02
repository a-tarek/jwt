<?php

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Core\Courier;
use Atarek\Jwt\Core\Contracts\ClaimLoader;

class UniqueIdentifierClaim implements ClaimLoader
{
    public static function load($tokenType): array {

        return ['jti' => Courier::getRandomString(60)];
    }
}
