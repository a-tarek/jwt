<?php 
namespace Atarek\Jwt\Core\Contracts;

use Atarek\Jwt\Core\Token;
use Atarek\Jwt\Core\Contracts\TokenSubject;

interface TokenBuilderDirectorContract
{
    public function makeAccessToken(TokenSubject $subject):Token;
    
    public function makeRefreshToken(TokenSubject $subject):Token;
}