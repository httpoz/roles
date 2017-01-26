### Register the Roles Service Provider

Add the package to your application service providers in `config/app.php` file.

```php
'providers' => [

    /*
     * Laravel Framework Service Providers...
     */
    Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
    Illuminate\Auth\AuthServiceProvider::class,
    ...

    /**
     * Third Party Service Providers...
     */
    HttpOz\Roles\RolesServiceProvider::class,

],
```


### Publish Config File And Migrations

Publish the package config file and migrations to your application. Run this command inside your terminal.

    php artisan vendor:publish --provider="HttpOz\Roles\RolesServiceProvider"

And also run migrations.

    php artisan migrate

> This uses the default users table which is in Laravel. You should already have the migration file for the users table available and migrated.


### Enable HasRole Trait And Contract

Include `HasRole` trait and also implement `HasRole` contract inside your `User` model.

```php
use HttpOz\Roles\Traits\HasRole;
use HttpOz\Roles\Contracts\HasRole as HasRoleContract;

class User extends Authenticatable implements HasRoleContract
{
    use Notifiable, HasRole;
```

And that's it!