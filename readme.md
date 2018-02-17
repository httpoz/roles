# Roles for Laravel 5.3 to 5.6
Powerful package for handling roles in Laravel

[![Build Status](https://travis-ci.org/httpoz/roles.svg)](https://travis-ci.org/httpoz/roles)
[![codecov](https://codecov.io/gh/httpoz/roles/branch/master/graph/badge.svg)](https://codecov.io/gh/httpoz/roles)
[![Total Downloads](https://poser.pugx.org/httpoz/roles/d/total.svg)](https://packagist.org/packages/httpoz/roles)
[![PHPPackages Rank](http://phppackages.org/p/httpoz/roles/badge/rank.svg)](http://phppackages.org/p/httpoz/roles)
[![PHPPackages Referenced By](http://phppackages.org/p/httpoz/roles/badge/referenced-by.svg)](http://phppackages.org/p/httpoz/roles)
[![Latest Stable Version](https://poser.pugx.org/httpoz/roles/v/stable.svg)](https://packagist.org/packages/httpoz/roles)
[![Latest Unstable Version](https://poser.pugx.org/httpoz/roles/v/unstable.svg)](https://packagist.org/packages/httpoz/roles)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/307f89bf-52b1-4d2e-9a62-350d1f5de141/small.png)](https://insight.sensiolabs.com/projects/307f89bf-52b1-4d2e-9a62-350d1f5de141)

|Laravel Version |Roles Version  |
|--------|----------|
| 5.3.*  | [Roles 1.4.x](https://github.com/httpoz/roles/tree/1.4) |
| 5.4.*  | [Roles 2.3.x](https://github.com/httpoz/roles/tree/2.3) |
| 5.5.*  | [Roles 3.0.x](https://github.com/httpoz/roles/tree/3.0) |
| 5.6.*  | Roles 3.1.x

#### History
This project was largely inspired by Roman's [romanbican/roles](https://github.com/romanbican/roles/) Laravel package. However at the time Laravel 5.3 was released his package was not actively maintained. I have ommitted permissions in this package in favour of Laravel's [Authorization](https://laravel.com/docs/5.3/authorization). I intend to keep this package as simple and minimal as is possible.

- [Installation](#installation)
    - [Composer](#composer)
    - [Config File And Migrations](#config-file-and-migrations)
    - [HasRoleAndPermission Trait And Contract](#hasroleandpermission-trait-and-contract)
- [Usage](#usage)
    - [Creating Roles](#creating-roles)
    - [Attaching And Detaching Roles](#attaching-and-detaching-roles)
    - [Syncing Roles](#syncing-roles)
    - [Checking For Roles](#checking-for-roles)
    - [Find users by role](#find-users-by-role)
    - [Groups](#groups)
    - [Blade Extensions](#blade-extensions)
    - [Middleware](#middleware)
    - [Caching](#caching)
- [Config File](#config-file)
- [License](#license)

## Installation
This package is very easy to set up. There are only couple of steps.

### Composer
Add the package to your project via composer.
```bash
composer require httpoz/roles 3.1.*
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

> Because of `Slugable` trait, if you make a mistake and for example leave a space in slug parameter, it'll be replaced with a dot automatically, because of `str_slug` function.

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

`Group` is intended to collectively organise and assign permissions (Laravel's built in authorization feature) to a role group that can be shared by multiple roles (examples and implementation to be added to documentation in future).

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

It throws `\HttpOz\Roles\Exceptions\RoleDeniedException` or `\HttpOz\Roles\Exceptions\GroupDeniedException` exceptions if it goes wrong.

You can catch these exceptions inside `app/Exceptions/Handler.php` file and do whatever you want. You can control the error page that your application users see when they try to open a page their role is not allowed to. This package already has a view bundled with it that should have been published to `resources/views/vendor/roles/error.blade.php` when you published the package. Simply add the below condition inside your `app\Exceptions\Handler.php`'s render function. Feel free to point to another view of your choice.

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
The configuration for cache expiry is defaulted to 2 weeks (in minutes). You can update this value to suit your project specific needs.

## License

This package is free software distributed under the terms of the MIT license.
