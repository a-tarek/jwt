<?php 

namespace Atarek\Jwt\Core\Contracts;

interface ClaimLoader
{
    public static function load($tokenType): array;

}