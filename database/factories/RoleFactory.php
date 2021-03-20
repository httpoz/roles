<?php
namespace HttpOz\Roles\Database\Factories;

use HttpOz\Roles\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

Class RoleFactory extends Factory {
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name'  => 'Admin',
            'slug'  => 'admin',
            'group' => 'system.admin'
        ];
    }
}
