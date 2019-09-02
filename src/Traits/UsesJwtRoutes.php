<?php

namespace Atarek\Jwt\Traits;

use Illuminate\Http\Request;
use Atarek\Jwt\JwtHandler;
use App\Services\ResponseService;
use Atarek\Jwt\Exceptions\TokenException;


trait UsesJwtRoutes
{
    public function authenticate(Request $request)
    {
        if (auth()->validate($request->all()) === false) {
            throw new TokenException(TokenException::INVALID_CREDENTIALS, 'A_001');
         };
        $access  = JwtHandler::instance()->makeAccessToken(auth()->user());
        $refresh = JwtHandler::instance()->makeRefreshToken(auth()->user());
        return response()->json([
            'success'=>1,
            'access' => $access,
            'refresh' => $refresh
        ]);
    }

    public function refresh()
    {
        return response()->json(["token" => JwtHandler::instance()->makeAccessToken(auth()->user())]);
    }

    public function user()
    {
        return response()->json(auth()->user());
    }

    public function revoke()
    {
        JwtHandler::instance()->revoke();
        return response()->json(['success' => 1]);
    }
}
