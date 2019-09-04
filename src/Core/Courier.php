<?php

namespace Atarek\Jwt\Core;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class Courier
{

    public static function getAccessPipe()
    {
        return [
            [\Atarek\Jwt\Core\TokenExtractor::class => 'extract'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkFormat'],
            [\Atarek\Jwt\Core\TokenSigner::class => 'checkAccessSignature'],
            [\Atarek\Jwt\Core\TokenParser::class => 'parse'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkRevoked'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkExpirationTime'],
        ];
    }

    public static function getRefreshPipe()
    {
        return [
            [\Atarek\Jwt\Core\TokenExtractor::class => 'extract'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkFormat'],
            [\Atarek\Jwt\Core\TokenSigner::class => 'checkRefreshSignature'],
            [\Atarek\Jwt\Core\TokenParser::class => 'parse'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkRevoked'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkExpirationTime'],
        ];
    }

    public static function getTokenPipe()
    {
        return [
            [\Atarek\Jwt\Core\TokenExtractor::class => 'extract'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkFormat'],
            [\Atarek\Jwt\Core\TokenSigner::class => 'checkSignature'],
            [\Atarek\Jwt\Core\TokenParser::class => 'parse'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkRevoked'],
            [\Atarek\Jwt\Core\TokenValidator::class => 'checkExpirationTime'],
        ];
    }

    public static function cacheRevokedToken($token, $ttl)
    {
        return Cache::put($token, 1, $ttl);
    }

    public static function isTokenRevoked($key)
    {
        return Cache::get($key);
    }


    public static function getRandomString($len = 16)
    {
        return Str::random($len);
    }
    public static function getTokenExpirationTime(string $tokenType)
    {
        return strtotime("now " . config("jwt.$tokenType.expiration_time",'+1 hour'));
    }


    public static function extractBearerToken(Request $request)
    {
        return \Request::bearerToken();
    }


    public static function getDefaultTokenHeader(string $tokenType): array
    {
        return [
                'alg' => 'HS256',
                'typ' => 'JWT',
        ];
    }


    public static function getDefaultTokenClaims(string $tokenType): array
    {
        $loaders = [
            \Atarek\Jwt\Core\Claims\IssuerClaim::class,
            \Atarek\Jwt\Core\Claims\ExpirationTimeClaim::class,
            \Atarek\Jwt\Core\Claims\IssuedTimeClaim::class,
            \Atarek\Jwt\Core\Claims\UniqueIdentifierClaim::class,
        ];
        $claims = [];
        foreach ($loaders as $loader) {
            $claims = array_merge($claims, $loader::load($tokenType));
        }
        return $claims;
    }

    public static function jwtHash($data, $key)
    {
        return hash_hmac('sha256', $data, $key);
    }

    public static function getSecretFor(string $tokenType): string
    {
        $env_key = config("jwt.$tokenType.env_secret");
        if ($env_key === null) {
            throw new \Exception('env_key not configured');
        }

        $secret = env($env_key,1234);
        if ($secret === null) {
            throw new \Exception("$env_key not provided or is null");
        }

        if (config("jwt.$tokenType.encode_secret",false)) {
            $secret = base64_encode($secret);
        }

        return $secret;
    }
}
