# Roles for Laravel
Simple package for handling roles in Laravel.

[![Build Status](https://travis-ci.org/httpoz/roles.svg)](https://travis-ci.org/httpoz/roles)
[![Total Downloads](https://poser.pugx.org/httpoz/roles/d/total.svg)](https://packagist.org/packages/httpoz/roles)
[![codecov](https://codecov.io/gh/httpoz/roles/branch/master/graph/badge.svg)](https://codecov.io/gh/httpoz/roles)
[![Latest Stable Version](https://poser.pugx.org/httpoz/roles/v/stable.svg)](https://packagist.org/packages/httpoz/roles)

## Installation
This package is very easy to set up. There are only a couple of steps.

### Previous Versions

For Previous versions please see the [releases page](https://github.com/httpoz/roles/releases)

### Composer
Add the package to your project via composer.
```bash
composer require httpoz/roles:^v9.0
```

### Config File And Migrations
To publish the package config's file and migrations to your application. Run this command inside your terminal.
```bash
php artisan vendor:publish --provider="HttpOz\Roles\RolesServiceProvider"
php artisan migrate
```

### Enable HasRole Trait And Contract
Include `HasRole` trait and also implement `HasRole` contract inside your User model.
```php
<?php

use HttpOz\Roles\Traits\HasRole;
use HttpOz\Roles\Contracts\HasRole as HasRoleContract;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements HasRoleContract
{
    use Notifiable, HasRole;

    ///
}
```
And that's it!

## Usage

### Creating Roles

```php
$adminRole = \HttpOz\Roles\Models\Role::create([
    'name' => 'Admin',
    'slug' => 'admin',
    'description' => 'Custodians of the system.', // optional
    'group' => 'default' // optional, set as 'default' by default
]);

$moderatorRole = \HttpOz\Roles\Models\Role::create([
    'name' => 'Forum Moderator',
    'slug' => 'forum.moderator',
]);
```

> Because of `Sluggable` trait, if you make a mistake and for example leave a space in slug parameter, it'll be replaced with a dot automatically, because of `str_slug` function.

### Attaching And Detaching Roles

It's really simple. You fetch a user from database and call `attachRole` method. There is `BelongsToMany` relationship between `User` and `Role` model.

```php
use App\User;

$user = User::find($id);

$user->attachRole($adminRole); // you can pass whole object, or just an id
```

```php
$user->detachRole($adminRole); // in case you want to detach role
$user->detachAllRoles(); // in case you want to detach all roles
```

### Syncing Roles
You may also use the sync method to attach roles to a user model. Any roles that are not passed into the method will be detached from the user's roles. So, after this operation is complete, only the roles passed into the method will be attached to the user:
```php
$user = App\User::find($id);

$roles = [1, 4, 6]; // using the role IDs we want to assign to a user

$user->syncRoles($roles); // you can pass Eloquent collection, or just an array of ids
```

### Checking For Roles

You can now check if the user has required role.

```php
if ($user->isRole('admin')) { // you can pass an id or slug
    // do something
}

// or

if($user->hasRole('admin')) {
    // do something
}

// or

if ($user->isAdmin()) {
    //
}
```

And of course, there is a way to check for multiple roles:

In this case, a user has to have at least one of the given roles. Multiple options have been illustrated below that achieve the same goal.

```php
    if ($user->isRole('admin|forum.moderator')) {
        // do something
    }

    if($user->isRole('admin, forum.moderator')){
        // do something
    }

    if($user->isRole(['admin', 'forum.moderator'])){
        // do something
    }

    if($user->isOne('admin|forum.moderator')){
        // do something
    }

    if($user->isOne('admin, forum.moderator')){
        // do something
    }

    if($user->isOne(['admin', 'forum.moderator'])){
        // do something
    }
```

In this case, a user has to have all the given roles. Multiple options have been illustrated below that achieve the same goal.

```php
    if ($user->isRole('admin|forum.moderator', true)) {
        // do something
    }

    if($user->isRole('admin, forum.moderator', true)){
        // do something
    }

    if($user->isRole(['admin', 'forum.moderator'], true)){
        // do something
    }

    if($user->isAll('admin|forum.moderator')){
        // do something
    }

    if($user->isAll('admin, forum.moderator')){
        // do something
    }

    if($user->isAll(['admin', 'forum.moderator'])){
        // do something
    }
```

### Find users by role
There are multiple ways to get a list of users by their given role.

 **Using the role's id**
 ```php
    $admins = Role::find(1)->users;
 ```

 **Using the role's slug**
 ```php
    $adminRole = Role::findBySlug('admin');
    $admins = $adminRole->users;
 ```
 **Using the role's group**
 ```php
    $adminRole = Role::where('group', 'forum.moderator')->first();
    $admins = $adminRole->users;
 ```
> If you use soft delete on your Users model, and want to include deleted users, you can use `usersWithTrashed` method instead of `users`. 

### Groups
```php
if ($user->group() == 'application.managers') {
    //
}

if ($user->inGroup('application.managers')) {
    // if true do something
}
```

> If a user has multiple roles, method `group` returns the first one in alphabetical order (a better implementation of this will be explored).

`Group` is intended to collectively organise and assign permissions (Laravel's built-in authorization feature) to a role group that can be shared by multiple roles (examples and implementation to be added to documentation in future).

### Blade Extensions

There are two Blade extensions. Basically, it is replacement for classic if statements.

```php
@role('admin') // @if(Auth::check() && Auth::user()->isRole('admin'))
    // user is admin
@endrole

@group('application.managers') // @if(Auth::check() && Auth::user()->group() == 'application.managers')
    // user belongs to 'application.managers' group
@endgroup

@role('admin|moderator', 'all') // @if(Auth::check() && Auth::user()->isRole('admin|moderator', 'all'))
    // user is admin and also moderator
@else
    // something else
@endrole
```

### Middleware

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

There are two kinds of exceptions that are thrown when a user fails to meet the role or group requirements:
- `\HttpOz\Roles\Exceptions\RoleDeniedException`
- `\HttpOz\Roles\Exceptions\GroupDeniedException`

You can catch these exceptions inside `app/Exceptions/Handler.php` file and do whatever you want. 

You can control the error page that your application users see when they try to open a page their role is not allowed to. This package already has a view bundled with it that should have been published to `resources/views/vendor/roles/error.blade.php` when you published the package. Simply add the below condition inside your `app\Exceptions\Handler.php`'s render function. Feel free to point to another view of your choice.

```php
/**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        if ($exception instanceof \HttpOz\Roles\Exceptions\RoleDeniedException || $exception instanceof \HttpOz\Roles\Exceptions\GroupDeniedException) {
            return response()->view('vendor.roles.error', compact('exception'), 403);
        }

        return parent::render($request, $exception);
    }
```

### Config File
You can change connection for models, slug separator, models path and there is also a handy pretend feature. Have a look at config file for more information.

### Caching
The configuration for cache expiry is defaulted to 2 weeks (in seconds). You can update this value to suit your project specific needs.

## License

This package is free software distributed under the terms of the MIT license.
