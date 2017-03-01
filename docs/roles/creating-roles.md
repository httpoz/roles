## Create seeder file
!!! summary "Use Case"
    We will be creating an Admin and Forum Moderator role.

First we need to create the seeder file using `php artisan`.
```sh
    php artisan make:seeder UserRolesSeeder
```

### Define roles in seeder file
In the seeder file we created above, which should be located at `database\seeds\UserRolesSeeder.php`, we will define the roles in the `run` method.

```php
    \HttpOz\Roles\Models\Role::create([
        'name' => 'Admin',
        'slug' => 'admin',
        'description' => 'Custodians of the system.', // optional
        'group' => 'default' // optional, set as 'default' by default
    ]);

    \HttpOz\Roles\Models\Role::create([
        'name' => 'Forum Moderator',
        'slug' => 'forum.moderator',
    ]);
```

!!! tip
    Because of Sluggable trait, if you make a mistake and for example leave a space in slug parameter, it will be replaced with a dot automatically, because of str_slug function.

### Seeding the created Roles
To be able to call the UserRolesSeeder when we run `php artisan db:seed` we need to add it to the run method in the `database\seeds\DatabaseSeeder.php` file.

```php
    $this->call(UserRolesSeeder::class);
```

When we run db:seed in php artisan the roles will be created in the database.

```sh
    php artisan db:seed
```