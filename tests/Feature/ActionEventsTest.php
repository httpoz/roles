<?php

namespace HttpOz\Roles\Tests\Feature;

use HttpOz\Roles\Events\UserRoleAttached;
use HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\Stubs\User;
use HttpOz\Roles\Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;

class ActionEventsTest extends TestCase
{
    use DatabaseMigrations;

    public function testAssigningRoleDispatchesEvent()
    {
        Event::fake();

        $user = factory(User::class)->create();
        $user1 = factory(User::class)->create();
        $role = factory(Role::class)->create();

        $user->attachRole($role);
        Event::assertDispatched(UserRoleAttached::class, function ($event) use ($role) {
            return $event->role->id === $role instanceof Role ? $role->id : $role;
        });

        $user1->attachRole($role->id);
        Event::assertDispatched(UserRoleAttached::class, function ($event) use ($role) {
            return $event->role->id === $role instanceof Role ? $role->id : $role;
        });

        $this->assertTrue($user->hasRole('admin'));
        $this->assertTrue($user1->hasRole('admin'));
    }
}