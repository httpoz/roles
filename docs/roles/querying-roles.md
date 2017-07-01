This package offers a couple of ways to query your roles.

### If user has role

```php

    $user = User::find(1);
    
    if ($user->isRole('admin')) { // you can pass an id or slug
        // do something
    }

    // or

    if($user->hasRole('admin')){
        // do something
    }

    // or

    if($user->isAdmin()){
        // do something
    }

```

### If user has atleast one role
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

### If user has all roles
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

### Find users by their role
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