<?php

use Atarek\Jwt\Exceptions\TokenException;
try{

    foreach (config("jwt.routes.prefix") as $provider => $prefix) {
        # code...
        if(array_key_exists($provider,config('auth.providers')) === false)
        {
            continue;
        }
        Route::prefix($prefix)->group(function () use ($provider){
            
            // use a default controller 
            $controller = config("jwt.routes.controller.$provider",\Atarek\Jwt\Controllers\AuthController::class);
            Route::post('auth', "{$controller}@authenticate")->middleware("set.default.provider:$provider");
            
            Route::middleware('has.refresh')->group(function () use($controller) {
                Route::get('refresh', "{$controller}@refresh");
            });
            
            Route::middleware('has.access')->group(function () use($controller){
                Route::get('revoke', "{$controller}@revoke");
                Route::get('me', "{$controller}@user");
            });
        });
    }
}
 catch (\Throwable $th) {
}