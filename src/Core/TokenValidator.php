<?php

namespace Atarek\Jwt\Core;

use Atarek\Jwt\Exceptions\TokenException;

class TokenValidator
{
    const TOKEN_PARTS = 3;

    public function validate(Token $token)
    { }

    public function checkFormat(string $tokenString)
    {
        if ($tokenString === '') {
            throw new TokenException(TokenException::MISSING_TOKEN, 'TV_1000');
        }

        $tokenParts = explode('.', $tokenString);
        if (sizeof($tokenParts) !== self::TOKEN_PARTS) {
            throw new TokenException(TokenException::INVALID_TOKEN, 'TV_1001');
        }

        return $tokenParts;
    }

    public function checkExpirationTime(Token $token)
    {
        /// if token expiration time is smaller than current time the validation fails
        if ($token->getClaim('exp') < time())
            throw new TokenException(TokenException::EXPIRED_TOKEN, 'TV_1002');

        return $token;
    }

    public function checkRevoked(Token $token) 
    {
        // check if token is stored in cache, if yes then the validatation fails
        if (Courier::isTokenRevoked($token->getClaim('jti')))
            throw new TokenException(TokenException::EXPIRED_TOKEN, 'TV_1003');

        return $token;
    }
}
