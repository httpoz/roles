<?php

namespace HttpOz\Roles\Traits;


trait RoleHasRelations
{
    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function users()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'role_user', 'role_id', 'user_id')->withTimestamps();
    }
    
    
    /**
     * Role belongs to many users with trashed.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function usersWithTrashed()
    {
        return $this->belongsToMany(config('auth.providers.users.model'), 'role_user', 'role_id', 'user_id')->withTrashed()->withTimestamps();
    }
}
