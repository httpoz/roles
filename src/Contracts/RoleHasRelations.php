<?php

namespace HttpOz\Roles\Contracts;


interface RoleHasRelations
{
    /**
     * Role belongs to many users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */

    public function users();

}
