<?php
namespace HttpOz\Roles\Tests\Unit;

use HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\Stubs\User;
use HttpOz\Roles\Tests\TestCase;

class HasRoleTraitTest extends TestCase
{
    public function testCanAttachRole()
    {
        $user =  factory(User::class)->create([
            'name' => 'The Oz'
        ]);
        $adminRole = factory(Role::class)->create();
        $managerRole = factory(Role::class)->create(['name' => 'Manager', 'slug' => 'manager']);

        $user->attachRole($adminRole);

        $this->assertEquals(1, count($user->roles()->count()));
    }
}