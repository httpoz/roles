<?php

namespace HttpOz\Roles\Tests\Feature;

use App\User;
use HttpOz\Roles\Models\Role;
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
        $this->assertTrue($user->isAdmin());
    }
}
