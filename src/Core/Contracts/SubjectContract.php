<?php

namespace Atarek\Jwt\Core\Contracts;

use Illuminate\Contracts\Auth\Authenticatable;


interface SubjectContract extends Authenticatable
{
    public function payload($tokenType):Array;

    public function getSubjectIdentifier();
}