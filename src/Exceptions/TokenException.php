<?php

namespace Atarek\Jwt\Exceptions;

use Exception;

class TokenException extends Exception
{
    const INVALID_TOKEN = [
        'Invalid token',
        400,
        ["Authorization" => "The token provided is invalid"]
    ];

    const EXPIRED_TOKEN = [
        'Expired token',
        400,
        ["Authorization" => "The token provided is expired"]
    ];

    const MISSING_TOKEN = [
        'Missing Token',
        401,
        ["Authorization" => "The authorization bearer token is required for this resource"]
    ];

    const INVALID_CREDENTIALS = [
        'Invalid credentials',
        400,
        ['Authorization'=> 'The credentials given was invalid']
    ];

    const INVALID_PROVIDER = [
        'Invalid provider',
        400,
        ['Configuration'=> 'The provider configured is invalid']
    ];

    public function __construct(array $response, $exceptionCode)
    {
        $response[2] = array_merge($response['2'],['exception_number'=>$exceptionCode]);  
        $this->errors = $response[2];
        
        parent::__construct($response[0],$response[1]);
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
