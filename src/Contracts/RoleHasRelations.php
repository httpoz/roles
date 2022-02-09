<?php

namespace HttpOz\Roles\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface RoleHasRelations
{
    /**
     * Role belongs to many users.
     *
     * @return BelongsToMany
     */

    public function users(): BelongsToMany;

}
