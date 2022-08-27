<?php

namespace HttpOz\Roles\Exceptions;

use Exception;

class RoleDeniedException extends Exception
{
    /**
     * Create a new role denied exception instance.
     */
    public function __construct(string $role)
    {
        parent::__construct();
        $this->message = sprintf("You don't have a required ['%s'] role.", $role);
    }
}
