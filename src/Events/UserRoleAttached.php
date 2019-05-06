<?php

namespace HttpOz\Roles\Events;

use HttpOz\Roles\Models\Role;

class UserRoleAttached
{
    /**
     * @var Role $role
     */
    public $role;

    /**
     * UserRoleAttached constructor.
     * @param Role $role
     * @return void
     */
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
}