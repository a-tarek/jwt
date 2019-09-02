<?php

namespace Atarek\Jwt\Core;

use Atarek\Jwt\Core\Token;
use Atarek\Jwt\Core\Courier;
use Atarek\Jwt\Exceptions\TokenException;

class TokenSigner
{
    public function sign(Token $token, $type): string
    {
        $header     = $this->encode($token->getHeader(),true);
        $payload    = $this->encode($token->getClaims(),true);
        $signature  = $this->signatureOf($header, $payload, Courier::getSecretFor($type));
        return $header . "." . $payload . "." . $signature;
    }

    public function checkSignature(string $header, string $payload, string $signature): array
    {
        if (
            $signature !== $this->AccessSignature($header, $payload) &&
            $signature !== $this->RefreshSignature($header, $payload)
        )
            throw new TokenException(TokenException::INVALID_TOKEN, 'TS_1000');
        return [$header, $payload, $header.$payload.$signature];
    }


    public function checkAccessSignature(string $header, string $payload, string $signature): array
    {
        if ($signature !== $this->AccessSignature($header, $payload))
            throw new TokenException(TokenException::INVALID_TOKEN, 'TS_1001');
        return [$header, $payload, $header.$payload.$signature];

    }

    public function checkRefreshSignature(string $header, string $payload, string $signature): array
    {
        if ($signature !== $this->RefreshSignature($header, $payload))
            throw new TokenException(TokenException::INVALID_TOKEN, 'TS_1002');
        return [$header, $payload, $header.$payload.$signature];

    }

    
    private function AccessSignature($header, $payload)
    {
        return $this->signatureOf($header, $payload, Courier::getSecretFor(Token::ACCESS));
    }

    private function RefreshSignature($header, $payload)
    {
        return $this->signatureOf($header, $payload, Courier::getSecretFor(Token::REFRESH));
    }

    private function signatureOf($header, $payload, $secret)
    {
        return $this->encode($this->hash($header . "." . $payload, $secret));
    }

    private function encode($subject, bool $json_encode = false)
    {
        if ($json_encode === true)
        {
            $subject = json_encode($subject);
        }
        return str_replace('=','',base64_encode($subject));
    }

    private function hash(string $data, string $key)
    {
        return Courier::jwtHash($data, $key);
    }
}
