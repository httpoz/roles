<?php

namespace HttpOz\Roles\Tests\Feature;

use HttpOz\Roles\Tests\Stubs\User;
use \HttpOz\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use HttpOz\Roles\Tests\TestCase;

class UserRoleTest extends TestCase
{

    use DatabaseMigrations;

    public function testUserHasRoleOnAttach()
    {
        $admin = factory(User::class)->create();
        $role  = factory(Role::class)->create();

        $adminRole = Role::findBySlug('admin');
        $user = User::find(1);
        $admin->detachAllRoles();
        $admin->attachRole($adminRole);

        $this->assertEquals($role->slug, $adminRole->slug);
    }

    public function testUserHasRoleOnAttachDupilcate()
    {
        $admin = factory(User::class)->create();
        $role  = factory(Role::class)->create();

        $adminRole = Role::findBySlug('admin');
        $user = User::find(1);
        $admin->detachAllRoles();
        $admin->attachRole($adminRole);
        $admin->attachRole($adminRole);

        $this->assertCount(1, $user->roles);
    }
}
