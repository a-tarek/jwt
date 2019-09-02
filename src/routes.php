<?php

Route::prefix(config('jwt.routes.prefix','api/users/actions'))->group(function () {
    $controller = config('jwt.routes.controller',\Atarek\Jwt\Controllers\AuthController::class);

    Route::post('auth', "{$controller}@authenticate");

    Route::middleware('has.refresh')->group(function () use($controller) {
        Route::get('refresh', "{$controller}@refresh");
    });

    Route::middleware('has.token')->group(function () use($controller){
        Route::get('revoke', "{$controller}@revoke");
        Route::get('me', "{$controller}@user");
    });
});
