<?php

namespace HttpOz\Roles\Observers;

use HttpOz\Roles\Models\Role;
use Illuminate\Support\Str;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        $role->slug = Str::slug($role->name, config('roles.separator'));
    }
}
