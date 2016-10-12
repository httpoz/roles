<?php
namespace HttpOz\Roles\Exceptions;

class GroupDeniedException extends AccessDeniedException
{
    /**
     * Create a new group denied exception instance.
     *
     * @param string $group
     */
    public function __construct($group)
    {
        $this->message = sprintf("You are not in the required [%s] group.", $group);
    }
}