<?php

namespace Atarek\Jwt\Core;

use Atarek\Jwt\Core\Token;
use Atarek\Jwt\Core\TokenBuilder;
use Atarek\Jwt\Core\Claims\SubjectClaim;
use Atarek\Jwt\Core\Contracts\SubjectContract;
use Atarek\Jwt\Core\Contracts\TokenBuilderDirectorContract;

class TokenBuilderDirector implements TokenBuilderDirectorContract
{
    /*
        $tokenBuilder->new('access')
                    ->claims( $subject->getPayload('access') );
    */ 
    protected $tokenBuilder;
    
    public function __construct()
    {
        $this->tokenBuilder = new TokenBuilder;
    }

    public function makeAccessToken(SubjectContract $subject):Token
    {
        $claims = array_merge($subject->payload(Token::ACCESS),SubjectClaim::load($subject));

        return $this->tokenBuilder->new(Token::ACCESS)->claims($claims)->build();
    }

    public function makeRefreshToken(SubjectContract $subject):Token
    {
        $claims = array_merge($subject->payload(Token::REFRESH),SubjectClaim::load($subject));

        return $this->tokenBuilder->new(Token::REFRESH)->claims($claims)->build();
    }
}
