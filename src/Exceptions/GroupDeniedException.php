<?php
namespace HttpOz\Roles\Exceptions;

use Exception;

class GroupDeniedException extends Exception
{
    /**
     * Create a new group denied exception instance.
     *
     * @param string $group
     */
    public function __construct($group)
    {
        parent::__construct();
        $this->message = sprintf("You are not in the required [%s] group.", $group);
    }
}
