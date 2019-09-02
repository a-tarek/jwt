<?php

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Core\Contracts\SubjectContract;

class SubjectClaim 
{
    public static function load(SubjectContract $subject): array
    {
        return ['sub'=> $subject->getSubjectIdentifier()];
    }
}