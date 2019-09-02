<?php 
namespace Atarek\Jwt\Core\Contracts;

use Atarek\Jwt\Core\Token;
use Atarek\Jwt\Core\Contracts\SubjectContract;

interface TokenBuilderDirectorContract
{
    public function makeAccessToken(SubjectContract $subject):Token;
    
    public function makeRefreshToken(SubjectContract $subject):Token;
}