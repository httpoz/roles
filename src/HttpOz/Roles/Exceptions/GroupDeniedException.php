<?php
namespace HttpOz\Roles\Exceptions;

class LevelDeniedException extends AccessDeniedException
{
    /**
     * Create a new group denied exception instance.
     *
     * @param string $level
     */
    public function __construct($level)
    {
        $this->message = sprintf("You are not in the required [%s] group.", $level);
    }
}