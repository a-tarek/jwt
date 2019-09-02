<?php

namespace Atarek\Jwt\Core;

class TokenRevoker
{
    public function revoke(Token $token)
    {
        return Courier::cacheRevokedToken(
            $token->getClaim('jti'),
            $token->getClaim('exp')- time()
        );
    }
}
