<?php

namespace Atarek\Jwt;

use Atarek\Jwt\Core\Token;
use Atarek\Jwt\Core\Courier;
use Illuminate\Http\Request;
use Atarek\Jwt\Core\StreamPipeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Atarek\Jwt\Core\Contracts\TokenSubject;
use Atarek\Jwt\Core\Contracts\TokenBuilderDirectorContract;

class JwtHandler
{
    protected $token;

    protected $tokenBuilder;

    protected $guard;

    public function __construct(TokenBuilderDirectorContract $tokenBuilder)
    {
        $this->tokenBuilder = $tokenBuilder;
    }

    public static function instance(): JwtHandler
    {
        return resolve(JwtHandler::class);
    }

    public function makeAccessToken(TokenSubject $subject)
    {
        return $this->tokenBuilder->makeAccessToken($subject);
    }

    public function makeRefreshToken(TokenSubject $subject)
    {
        return $this->tokenBuilder->makeRefreshToken($subject);
    }


    public function handleForAccess(Request $request)
    {
        $this->run($request, Courier::getAccessPipe());
        return $this;
    }


    public function handleForRefresh(Request $request)
    {
        $this->run($request, Courier::getRefreshPipe());
        return $this;
    }

    public function handle(Request $request)
    {
        $this->run($request, Courier::getTokenPipe());
        return $this;
    }

    private function run($request, $pipe)
    {
        (new StreamPipeline)->send($request)->through($pipe)->then(function (Token $token) {
            $this->token = $token;
            Auth::guard()->setProvider($token->getClaim('pvr'));
            auth('api')->setUserByUserId($token->getClaim('sub'));
        });
    }

    public function claims($claim = null)
    {
        if ($claim === null) {
            return $this->token->getClaims();
        }
        if ($this->token) {
            return $this->token->getClaim($claim);
        }
    }

    public function token()
    {
        return $this->token;
    }


    public function revoke()
    {
        if ($this->token) {
            return $this->token->revoke();
        }
    }

    public function user()
    {
        return auth()->user();
    }
}
