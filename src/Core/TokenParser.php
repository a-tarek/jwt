<?php

namespace Atarek\Jwt\Core;

class TokenParser
{
    const TOKEN_PARTS = 3;

    public function parse($header, $payload, $full):Token
    {
        return new Token($this->decode($header), $this->decode($payload), $full);
    }

    private function decode($subject)
    {
        return json_decode(base64_decode($subject), true) ?? [];
    }
}
