<?php
return [

    /*
    |--------------------------------------------------------------------------
    | Package Connection
    |--------------------------------------------------------------------------
    |
    | You can set a different database connection for this package. It will set
    | new connection for models Role and Permission. When this option is null,
    | it will connect to the main database, which is set up in database.php
    |
    */

    'connection' => null,

    /*
    |--------------------------------------------------------------------------
    | Slug Separator
    |--------------------------------------------------------------------------
    |
    | Here you can change the slug separator. This is very important in matter
    | of magic method __call() and also a `Slugable` trait. The default value
    | is a dot.
    |
    */

    'separator' => '.',

     /*
    |--------------------------------------------------------------------------
    | Cache Expiry
    |--------------------------------------------------------------------------
    |
    | Here you can enable cache and change the period for which cache should
    | remember the roles. Time should be in seconds, refer to official docs
    | https://laravel.com/docs/8.x/cache.
    */

    'cache' => [
        'enabled' => false,
        'expiry' => 1209600,
    ],

    /*
    |--------------------------------------------------------------------------
    | Models
    |--------------------------------------------------------------------------
    |
    | If you want, you can replace default models from this package by models
    | you created. Have a look at `HttpOz\Roles\Models\Role` model and
    | `HttpOz\Roles\Models\Permission` model.
    |
    */

    'models' => [
        'role' => HttpOz\Roles\Models\Role::class
    ],

    /*
    |--------------------------------------------------------------------------
    | Roles, Permissions and Allowed "Pretend"
    |--------------------------------------------------------------------------
    |
    | You can pretend or simulate package behavior no matter what is in your
    | database. It is really useful when you are testing you application.
    | Set up what will methods is(), can() and allowed() return.
    |
    */
    'pretend' => [
        'enabled' => false,
        'options' => [
            'isRole' => true
        ],
    ],

];
