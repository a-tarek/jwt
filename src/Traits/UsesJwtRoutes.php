<?php

namespace Atarek\Jwt\Traits;

use Illuminate\Http\Request;
use Atarek\Jwt\JwtHandler;
use Atarek\Jwt\Exceptions\TokenException;


trait UsesJwtRoutes
{
    public function authenticate(Request $request, $callBack = null)
    {
        if (auth('api')->validate($request->all()) === false) {
            throw new TokenException(TokenException::INVALID_CREDENTIALS, 'A_001');
        };
        $accessToken  = JwtHandler::instance()->makeAccessToken(auth('api')->user());
        $refreshToken = JwtHandler::instance()->makeRefreshToken(auth('api')->user());
        if (is_callable($callBack)) {
            return call_user_func($callBack, $accessToken, $refreshToken);
        }
        return response()->json([
            'success' => 1,
            'access' => $accessToken,
            'refresh' => $refreshToken
        ]);
    }

    public function refresh($callBack = null)
    {
        $accessToken = JwtHandler::instance()->makeAccessToken(auth('api')->user());
        if (is_callable($callBack)) {
            return call_user_func($callBack, $accessToken);
        }
        return response()->json([
            'success' => 1,
            'access' => $accessToken
        ]);
    }

    public function user()
    {
        return response()->json(auth('api')->user());
    }

    public function revoke($callBack = null)
    {
        JwtHandler::instance()->revoke();
        if (is_callable($callBack)) {
            return call_user_func($callBack);
        }
        return response()->json(['success' => 1]);
    }
}
