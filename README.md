# Laravel 7 With Passport Authentication Rest API

- Run laravel installation if php installed is 7+
```
composer create-project --prefer-dist laravel/laravel project-name-goes-here
```

### Install Laravel Passport Package
> Laravel Passport provides a full OAuth2 server implementation for your Laravel application in a matter of minutes.
```
composer require laravel/passport
```

### Run migration
> The Passport migrations will create the tables your application needs to store clients and access tokens, before this you should have already created and configured the connection to your database.
```
php artisan migrate
```

### Generate keys
> You may run the passport:install command with the --uuids option present. This flag will instruct Passport that you would like to use UUIDs instead of auto-incrementing integers as the Passport Client model's primary key values.
```
php artisan passport:install --uuids
```
![OAthKeys-Capture](https://user-images.githubusercontent.com/47104485/90283248-2368de00-de70-11ea-83a7-ed2ee4e0690c.PNG)

### Passport config
> Navigate to App\User model then add in - use Laravel\Passport\HasApiTokens
```
namespace App;use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;
}
```
> Next, you should call the Passport::routes method within the boot method of your AuthServiceProvider. This method will register the routes necessary to issue access tokens and revoke access tokens, clients, and personal access tokens. [App\Providers\AuthServiceProvider.php]
```
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // This method will register the routes necessary to issue access tokens and revoke access tokens, clients, and personal access tokens
        Passport::routes();

    }
}
```
> Finally, in your config/auth.php configuration file, you should set the driver option of the api authentication guard to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests.
```
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
]
```

### Create API Routes
>  Laravel provide routes/api.php file for write web services route. So, let’s add new route on that file.
```
use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'AuthController@login');
    Route::post('signup', 'AuthController@signup');

    Route::group([
        'middleware' => 'auth:api',
    ], function () {
        Route::get('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
    });
});
```

### Test the application
```
php artisan serve
```

### Open up postman.rest file or Postman app
> add these in the header section
```
Content-Type: application/json
X-Requested-With: XMLHttpRequest
```
> Register Account
![postman-Capture](https://user-images.githubusercontent.com/47104485/90283284-39769e80-de70-11ea-9ab6-c89f6b37f165.PNG)

> Login
![postman-login-Capture](https://user-images.githubusercontent.com/47104485/90283330-53b07c80-de70-11ea-922e-384d72ada3e0.PNG)

> Add in the generated access_token in order to view in your account
![user-Capture](https://user-images.githubusercontent.com/47104485/90283398-7478d200-de70-11ea-9150-0180747c14f4.PNG)

> Then run logout with the same access_token to distroy or revoke it.