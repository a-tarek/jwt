<?php

namespace Atarek\Jwt\Core\Claims;

use Atarek\Jwt\Core\Contracts\TokenSubject;

class SubjectClaim
{
    public static function load(TokenSubject $subject): array
    {
        return [
            'sub' => $subject->getIdentifier(),
            'pvr'=> $subject->getProvider()
        ];
    }
}
