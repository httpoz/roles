There are multiple ways to work with your roles once you have created them. This package provides different ways to manage the relationship between your `User` and `Role` models.

!!! tip "Many to Many Relationships"
    Read about many to many relationships in [Laravel Docs](https://laravel.com/docs/5.3/eloquent-relationships#updating-many-to-many-relationships).

## Attaching Roles
Attaching a role a user is as simple as querying the Role model for the desired role and then attaching that role to a given user.
```php
    $adminRole = HttpOz\Roles\Models\Roles::findBySlug('admin');
    $user = App\User::find($id);
    
    $user->attachRole($adminRole); // you can pass whole object, or just an id
```

## Detaching Roles
You can choose to detach only one role or all the roles assigned to the user object.
```php
    $adminRole = HttpOz\Roles\Models\Roles::findBySlug('admin');
    $user = App\User::find($id);
    
    $user->detachRole($adminRole); // in case you want to detach one role
    $user->detachAllRoles(); // in case you want to detach all roles
```

## Syncing Roles
You may also use the sync method to attach roles to a user model. Any roles that are not passed into the method will be detached from the user's roles. So, after this operation is complete, only the roles passed into the method will be attached to the user:
```php
    $adminRole = HttpOz\Roles\Models\Roles::findBySlug('admin');
    $user = App\User::find($id);

    $roles = [1, 4, 6]; // using the role IDs we want to assign to a user
    
    $user->detachRole($adminRole); // in case you want to detach role
    $user->syncRoles($roles); // you can pass Eloquent collection, or just an array of ids
```