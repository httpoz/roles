This package comes with `VerifyRole` and `VerifyGroup` middleware. You must add them inside your `app/Http/Kernel.php` file.

```php
/**
 * The application's route middleware.
 *
 * @var array
 */
protected $routeMiddleware = [

    // ...

    'role' => \HttpOz\Roles\Middleware\VerifyRole::class,
    'group' => \HttpOz\Roles\Middleware\VerifyGroup::class,
];
```

Now you can easily protect your routes.

```php
$router->get('/example', [
    'as' => 'example',
    'middleware' => 'role:admin',
    'uses' => 'ExampleController@index',
]);

$router->get('/example', [
    'as' => 'example',
    'middleware' => 'group:application.managers',
    'uses' => 'ExampleController@index',
]);
```

It throws `\HttpOz\Roles\Exceptions\RoleDeniedException` or `\HttpOz\Roles\Exceptions\GroupDeniedException` exceptions if it goes wrong.

You can catch these exceptions inside `app/Exceptions/Handler.php` file and do whatever you want, example below.
