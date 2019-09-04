<?php

namespace Atarek\Jwt\Core;

use Atarek\Jwt\Core\Token;
use Atarek\Jwt\Core\TokenBuilder;
use Atarek\Jwt\Core\Claims\SubjectClaim;
use Atarek\Jwt\Core\Contracts\TokenSubject;
use Atarek\Jwt\Core\Contracts\TokenBuilderDirectorContract;

class TokenBuilderDirector implements TokenBuilderDirectorContract
{
    protected $tokenBuilder;
    
    public function __construct()
    {
        $this->tokenBuilder = new TokenBuilder;
    }

    public function makeAccessToken(TokenSubject $subject):Token
    {
        $claims = array_merge($subject->addClaims(Token::ACCESS),SubjectClaim::load($subject));

        return $this->tokenBuilder->new(Token::ACCESS)->claims($claims)->build();
    }

    public function makeRefreshToken(TokenSubject $subject):Token
    {
        $claims = array_merge($subject->addClaims(Token::REFRESH),SubjectClaim::load($subject));

        return $this->tokenBuilder->new(Token::REFRESH)->claims($claims)->build();
    }
}
