<?php

namespace HttpOz\Roles\Tests\Unit;

use HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\Stubs\User;
use HttpOz\Roles\Tests\TestCase;

class RoleHasRelationsTraitTest extends TestCase
{
    public function testRoleCanFetchUsers()
    {
        $role = factory(Role::class)->create();
        factory(User::class, 10)->create()->each(function ($u) use ($role) {
            $u->attachRole($role);
        });

        $this->assertEquals(10, $role->users()->count());
    }
}