## Creating Roles
The common practice for creating roles would be to create a seed file and place your role definitions in that file. In the example below we are defining two roles `Admin` and `Forum Moderator` that will be created when we run `php artisan db:seed`.

```php
use HttpOz\Roles\Models\Role;

$adminRole = Role::create([
    'name' => 'Admin',
    'slug' => 'admin',
    'description' => '', // optional
    'group' => 'default', // optional, set as 'default' by default
]);

$moderatorRole = Role::create([
    'name' => 'Forum Moderator',
    'slug' => 'forum.moderator',
]);
```

> Because of `Sluggable` trait, if you make a mistake and for example leave a space in slug parameter, it'll be replaced with a dot automatically, because of `str_slug` function.

## Attaching, Syncing And Detaching Roles

It's really simple. You fetch a user from database and call `attachRole` method. There is `BelongsToMany` relationship between `User` and `Role` model.
Learn about [Many To Many Relationships](https://laravel.com/docs/5.3/eloquent-relationships#updating-many-to-many-relationships)

```php
use App\User;

$user = User::find($id);

$user->attachRole($adminRole); // you can pass whole object, or just an id
$user->detachRole($adminRole); // in case you want to detach role
$user->detachAllRoles(); // in case you want to detach all roles
$user->syncRoles($roles); // you can pass Eloquent collection, or just an array of ids
```

## Checking For Roles

You can now check if the user has required role.

```php
if ($user->isRole('admin')) { // you can pass an id or slug
    // or alternatively $user->hasRole('admin')
}
```

You can also do this:

```php
if ($user->isAdmin()) {
    //
}
```

And of course, there is a way to check for multiple roles:

```php
if ($user->isRole('admin|moderator')) {
    /*
    | Or alternatively:
    | $user->isRole('admin, moderator'), $user->isRole(['admin', 'moderator']),
    | $user->isOne('admin|moderator'), $user->isOne('admin, moderator'), $user->isOne(['admin', 'moderator'])
    */

    // if user has at least one role
}

if ($user->isRole('admin|moderator', true)) {
    /*
    | Or alternatively:
    | $user->isRole('admin, moderator', true), $user->isRole(['admin', 'moderator'], true),
    | $user->isAll('admin|moderator'), $user->isAll('admin, moderator'), $user->isAll(['admin', 'moderator'])
    */

    // if user has all roles
}
```

## Find users by their role
 There are multiple ways to get a list of users by their given role.

 **Using the role's id**
 ```php
 $admins = Role::find(1)->users;
 ```

 **Using the role's slug**
 ```php
 $adminRole = Role::where('slug', 'admin')->first();
 $admins = $adminRole->users;
 ```
 **Using the role's group**
 ```php
 $adminRole = Role::where('group', 'application.managers')->first();
 $admins = $adminRole->users;
 ```
