<?php

namespace Atarek\Jwt\Core;

class TokenExtractor
{
    public function extract($request)
    {
        return Courier::extractBearerToken($request);
    }
}