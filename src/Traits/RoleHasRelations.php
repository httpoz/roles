<?php

namespace HttpOz\Roles\Traits;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait RoleHasRelations
{
    /**
     * Role belongs to many users.
     */

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'role_user', 'role_id', 'user_id')->withTimestamps();
    }


    /**
     * Role belongs to many users with trashed.
     */
    public function usersWithTrashed(): BelongsToMany
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'role_user', 'role_id', 'user_id')->withTrashed()->withTimestamps();
    }
}
