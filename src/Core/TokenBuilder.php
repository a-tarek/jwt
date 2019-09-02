<?php

namespace Atarek\Jwt\Core;

use Atarek\Jwt\Core\Token;


class TokenBuilder
{
    protected $token;

    protected $tokenType;

    public function new($tokenType) : TokenBuilder
    {
        $this->token = new Token();

        $this->tokenType = $tokenType;

        $this->initialLoad();

        return $this;
    }

    public function claims(array $additional = []): TokenBuilder
    {
        $this->token->addClaims($additional);
        return $this;
    }


    public function build()
    {
        $this->token->sign($this->tokenType);
        return $this->token;
    }

    public function reset()
    {
        $this->token = null;
        $this->type = null;
        return $this;
    }

    private function initialLoad()
    {
        $this->setTokenHeader();
        $this->setTokenClaims();
    }


    private function setTokenHeader()
    {
        $this->token->setHeader(Courier::getDefaultTokenHeader($this->tokenType));
    }


    private function setTokenClaims()
    {
        $this->token->addClaims(Courier::getDefaultTokenClaims($this->tokenType));
    }
}
