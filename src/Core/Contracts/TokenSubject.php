<?php

namespace Atarek\Jwt\Core\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;


interface TokenSubject extends Authenticatable
{
    public function addClaims($tokenType):Array;

    public function getProvider():string;

    public function getIdentifier():string;
}