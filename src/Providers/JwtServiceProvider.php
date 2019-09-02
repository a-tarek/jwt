<?php

namespace Atarek\Jwt\Providers;

use Atarek\Jwt\JwtGuard;
use Atarek\Jwt\JwtHandler;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Atarek\Jwt\Core\TokenBuilderDirector;
use Atarek\Jwt\Controllers\AuthController;
use Atarek\Jwt\Core\Contracts\TokenBuilderDirectorContract;

class JwtServiceProvider extends ServiceProvider
{
    public $singletons = [
        JwtGuard::class => JwtGuard::class,
        JwtHandler::class => JwtHandler::class,
    ];

    public $bindings = [
        TokenBuilderDirectorContract::class => TokenBuilderDirector::class,
    ];
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(JwtHandler::class);
        $this->app->bind(TokenBuilderDirectorContract::class, TokenBuilderDirector::class);
        $this->app->bind(TokenBuilderDirectorContract::class, TokenBuilderDirector::class);
        $this->app->make(AuthController::class);

        $this->app['router']->aliasMiddleware('has.access' , \Atarek\Jwt\Middlewares\HasAccessToken::class);
        $this->app['router']->aliasMiddleware('has.refresh' , \Atarek\Jwt\Middlewares\HasRefreshToken::class);
        $this->app['router']->aliasMiddleware('has.token' , \Atarek\Jwt\Middlewares\HasToken::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes.php');

        //
        Auth::extend('jwt', function ($app, $name, array $config) {
            return new JwtGuard(Auth::createUserProvider($config['provider']));
        });

        $this->publishes([
            __DIR__ . '/../config' => base_path('config'),
        ]);
    }
}
