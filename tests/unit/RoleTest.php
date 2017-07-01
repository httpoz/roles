<?php

namespace HttpOz\Roles\Tests;

use HttpOz\Roles\Models\Role;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RoleTest extends TestCase {

  use DatabaseMigrations;

  public function testRoleCanBeFoundBySlug() {

    $createdRole = factory(Role::class)->create(['name' => 'Admin', 'slug' => 'admin']);

    $foundRole = Role::findBySlug('admin');

    $this->assertEquals($createdRole->id, $foundRole->id);
    $this->assertEquals($createdRole->name, $foundRole->name);
    $this->assertEquals($createdRole->slug, $foundRole->slug);
  }
}