<?php

namespace Atarek\Jwt\Controllers;

use App\Http\Controllers\Controller;
use Atarek\Jwt\Traits\UsesJwtRoutes;

class AuthController extends Controller
{
    use UsesJwtRoutes;
}
