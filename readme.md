# Atarek\Jwt

This package made for handling token based authentication in laravel projects.
It uses two types of tokens an access token and a refresh token both are generated when the user is successfully authenticated. It also support multiple table authentication.

###### This package has support for only EloquentUserProvider any other providers will not work 

## Installation
You can install it via composer
```bash
composer require atarek\jwt
```
Then add JwtServiceProvider to the list of providers in app.php
```
'providers' => [
        // ...
        Atarek\Jwt\Providers\JwtServiceProvider::class,
        //...
],
```
Next run the following to publish the package

```bash
php artisan vendor:publish --provider="Atarek\Jwt\Providers\JwtServiceProvider"
```

## Usage
Configure the auth.php guard driver to jwt 
```
'api' => [
       'driver' => 'jwt',
       'provider' => 'users',
],
```
The provider_name must match the provider name in auth.php
```
<?php
return [
    'routes' => [
        'prefix' => [
            // provider_name => url_prefix
            // 'users' => 'api/users/actions',
        ],
        'controller' => [
            // provider_name => controller_name
            // 'users' => \Atarek\Jwt\Controllers\AuthController::class,
        ],
    ],

    'encode_secret' => false,

    'access' => [
        'expiration_time' => '+1 hour',
        'env_secret' => env('ACCESS_TOKEN_SECRET'),

    ],

    'refresh' => [
        'expiration_time' => '+1 day',
        'env_secret' => env('REFRESH_TOKEN_SECRET')
    ]
];
```

In your laravel .env file add these two secret keys
```
ACCESS_TOKEN_SECRET=xxxx
REFRESH_TOKEN_SECRET=yyyy
```
You must implement the ``` TokenSubject ``` contract on the your  ```Authenticatable``` model

```
<?php

namespace App;

use Atarek\Jwt\Core\Contracts\TokenSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements TokenSubject
{
    public function addClaims($tokenType):array
    {
        /* 
         * where you add additional custom claims to the token
         * $tokenType passed is either access or refresh if
         * custom creation needed is based on tokenType
         */ 
        return [];
    }

    public function getProvider():string
    {
        // must match the auth.php provider
        return 'users';
    }

    public function getIdentifier():string
    {
        // user id 
        return $this->getAuthIdentifier();
    }
}

```


The default ```Atarek\Jwt\Controllers\AuthController::class``` contains four methods to handle token authentication and routes.

``` route_prefix/auth, @authenticate```Authenticates the request credentials and return the access and refresh token.

``` route_prefix/me, @user``` Returns the current user retrieved from the authorization bearer token

```route_prefix/revoke, @revoke``` Blacklisting the authorization bearer token

```reoute_prefix/refresh, @refresh``` Returns a new access token, you can only refresh with a refresh token

#### Extending AuthController
You can extend the default ``` Atarek\Jwt\Controllers\AuthController::class``` and add additional logic before returning the response
```
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Atarek\Jwt\Controllers\AuthController;

class UserController extends AuthController
{
    public function authenticate(Request $request, $callBack = null)
    {
        return parent($request, function($accessToken, $refreshToken){
            // do stuff here 
            // Auth::user()->doStuff();
            return response()->json([
                'access'=>$accessToken,
                'refresh'=>$refreshToken
            ]);
        });
    }    
}

```






## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)