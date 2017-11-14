<?php

namespace HttpOz\Roles\Tests\Stubs;

use \HttpOz\Roles\Traits\HasRole;
use \HttpOz\Roles\Contracts\HasRole as HasRoleContract;
use Illuminate\Foundation\Auth\User as Eloquent;

class User extends Eloquent implements HasRoleContract
{

    use HasRole;

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return array
     */
    public function getAuthIdentifiersName()
    {
        return ['email', 'username'];
    }
}
