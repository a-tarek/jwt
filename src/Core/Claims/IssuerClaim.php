<?php

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Core\Contracts\ClaimLoader;

class IssuerClaim implements ClaimLoader
{
    public static function load($tokenType): array
    {
        return ['iss' =>url()->current()];
    }
}