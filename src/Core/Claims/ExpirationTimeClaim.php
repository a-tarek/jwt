<?php 

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Core\Contracts\ClaimLoader;
use Atarek\Jwt\Core\Courier;

class ExpirationTimeClaim implements ClaimLoader
{
    public static function load($tokenType):array
    {
        $expirationTime = Courier::getTokenExpirationTime($tokenType);
        return ['exp'=> $expirationTime, 'ttl'=> $expirationTime -time()];
    }
}