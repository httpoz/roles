<?php

namespace HttpOz\Roles\Contracts;

interface HasRole
{
    /**
     * User belongs to many roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles();

    /**
     * Get all roles as collection.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getRoles();

    /**
     * Check if the user has a role or roles.
     *
     * @param int|string|array $role
     * @param bool $all
     * @return bool
     */
    public function isRole($role, $all = false);

    /**
     * Check if the user has all roles.
     *
     * @param int|string|array $role
     * @return bool
     */
    public function isAll($role);

    /**
     * Check if the user has at least one role.
     *
     * @param int|string|array $role
     * @return bool
     */
    public function isOne($role);

    /**
     * Check if the user has role.
     *
     * @param int|string $role
     * @return bool
     */
    public function hasRole($role);

    /**
     * Attach role to a user.
     *
     * @param int|\HttpOz\Roles\Models\Role $role
     * @return null|bool
     */
    public function attachRole($role);

    /**
     * Detach role from a user.
     *
     * @param int|\HttpOz\Roles\Models\Role $role
     * @return int
     */
    public function detachRole($role);
    
    /**
     * Sync roles for a user.
     *
     * @param array|\HttpOz\Roles\Models\Role[]|\Illuminate\Database\Eloquent\Collection $roles
     * @return array
     */
    public function syncRoles($roles);

    /**
     * Detach all roles from a user.
     *
     * @return int
     */
    public function detachAllRoles();

    /**
     * Get role group of a user.
     *
     * @return string
     */
    public function group();
}
