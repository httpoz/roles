<?php

namespace HttpOz\Roles\Contracts;

use HttpOz\Roles\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

interface HasRole
{
    /**
     * User belongs to many roles.
     */
    public function roles(): BelongsToMany;

    /**
     * Get all roles as collection.
     */
    public function getRoles(): Collection;

    /**
     * Check if the user has a role or roles.
     */
    public function isRole(array|int|string $role, bool $all = false): bool;

    /**
     * Check if the user has all roles.
     */
    public function isAll(array|int|string $role): bool;

    /**
     * Check if the user has at least one role.
     */
    public function isOne(array|int|string $role): bool;

    /**
     * Check if the user has role.
     */
    public function hasRole(int|string $role): bool;

    /**
     * Attach role to a user.
     */
    public function attachRole(int|Role $role): bool;

    /**
     * Detach role from a user.
     */
    public function detachRole(int|Role $role): int;
    
    /**
     * Sync roles for a user.
     */
    public function syncRoles(Collection|array $roles): array;

    /**
     * Detach all roles from a user.
     */
    public function detachAllRoles(): int;

    /**
     * Get role group of a user.
     */
    public function group(): string;
}
