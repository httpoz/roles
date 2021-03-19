<?php

namespace HttpOz\Roles\Tests\Stubs;

use HttpOz\Roles\Database\Factories\UserFactory;
use \HttpOz\Roles\Traits\HasRole;
use \HttpOz\Roles\Contracts\HasRole as HasRoleContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Eloquent;

class User extends Eloquent implements HasRoleContract
{

    use HasRole, HasFactory;

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return array
     */
    public function getAuthIdentifiersName(): array
    {
        return ['email', 'username'];
    }



    protected static function newFactory()
    {
        return new UserFactory();
    }
}
