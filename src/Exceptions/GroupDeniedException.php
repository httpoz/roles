<?php
namespace HttpOz\Roles\Exceptions;

use Exception;

class GroupDeniedException extends Exception
{
    /**
     * Create a new group denied exception instance.
     */
    public function __construct(string $group)
    {
        parent::__construct();
        $this->message = sprintf("You are not in the required [%s] group.", $group);
    }
}
