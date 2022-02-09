<?php

namespace HttpOz\Roles\Tests\Unit;

use HttpOz\Roles\Models\Role;
use HttpOz\Roles\Tests\TestCase;

class RoleTest extends TestCase
{
    public function testRoleCanBeFoundBySlug()
    {
        $createdRole = Role::factory()->create(['name' => 'Admin', 'slug' => 'admin']);
        $foundRole = Role::findBySlug('admin');

        $this->assertEquals($createdRole->id, $foundRole->id);
        $this->assertEquals($createdRole->name, $foundRole->name);
        $this->assertEquals($createdRole->slug, $foundRole->slug);
    }

    /**
     * @dataProvider roleProvider
     */
    public function testMinimalInputRoleCreation(string $name, ?string $slug, string $expected): void
    {
        $role = Role::create(['name' => $name, 'slug' => $slug]);

        $this->assertEquals($expected, $role->slug);
    }

    public function roleProvider(): array
    {
        return [
            ['Big Fish', 'Big Fish', 'big.fish'],
            ['Small Fish', 'small.fish', 'small.fish'],
            ['Medium Fish', 'medium_fish', 'mediumfish'],
            ['Dashing Fish', 'dashing-fish', 'dashing.fish']
        ];
    }
}
