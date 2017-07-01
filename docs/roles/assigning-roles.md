Assigning roles has 2 very simple use cases - when you are creating a user or when attaching a role to an existing user ([explained here](/roles/managing-roles)).

### On creating a user
Assuming you are on a fresh install of Laravel, you would need to create a users table seeder. If you are creating users dynamically in a controller, then you do not need to create a seeder file.

```bash
    php artisan make:seeder UsersTableSeeder
```

In the run function of your UsersTableSeeder (or controller), you would need to execute the following 3 steps:

```php
    // 1. query the Roles by the slug
    $adminRole = \HttpOz\Roles\Models\Role::findBySlug('admin');
    $moderatorRole = \HttpOz\Roles\Models\Role::findBySlug('forum.moderator');

    // 2a. Create admin
    $admin = \App\User::create([
        'name' => 'Oscar Mwanandimai',
        'email' => 'oscar@github.com',
        'password' => bcrypt('password')
    ]);

    // 2b. Create forum moderator
    $moderator = \App\User::create([
        'name' => 'John Doe',
        'email' => 'john@github.com',
        'password' => bcrypt('password')
    ]);

    // 3. Attach a role to the user object / assign a role to a user
    $admin->attachRole($adminRole);
    $moderator->attachRole($moderatorRole);
```

If you took the database seeder route
```bash
    php artisan db:seed
```