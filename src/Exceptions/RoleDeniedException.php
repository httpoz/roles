<?php

namespace HttpOz\Roles\Exceptions;

use Exception;

class RoleDeniedException extends Exception
{
    /**
     * Create a new role denied exception instance.
     *
     * @param string $role
     */
    public function __construct($role)
    {
        $this->message = sprintf("You don't have a required ['%s'] role.", $role);
    }
}
