<?php

namespace Atarek\Jwt\Core;

use JsonSerializable;
use Atarek\Jwt\Core\TokenSigner;
use Atarek\Jwt\Core\TokenRevoker;

class Token implements JsonSerializable
{
    const ACCESS = 'access';

    const REFRESH = 'refresh';

    protected $header;

    protected $claims;

    protected $representation;
    
    public function jsonSerialize()
    {
        return $this->representation;
    }
    

    public function __toString()
    {
        return $this->representation;
    }

   

    public function __construct(array $header = [], array  $claims = [], $representation='')
    {
        $this->claims   = $claims;
        $this->header   = $header;
        $this->representation = $representation;
    }

    public function sign(string $with = Token::ACCESS)
    {
        return $this->representation = (new TokenSigner)->sign($this, $with);
    }


    public function revoke()
    { 
        return (new TokenRevoker)->revoke($this);
    }


    public function setHeader(array $header)
    {
        $this->header = $header;
    }

    public function addClaims(array $additionals = [])
    {
        $this->claims = array_merge($this->claims, $additionals);
    }


    public function getHeader()
    {
        return $this->header;
    }


    public function getClaims()
    {
        return $this->claims;
    }


    public function getClaim($key)
    {
        try {
            return $this->claims[$key];
        } catch (\Throwable $th) {
            return null;
        }
    }
}
