<?php
namespace HttpOz\Roles\Database\Factories;

use HttpOz\Roles\Tests\Stubs\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    protected $model = User::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
            'remember_token' => $this->faker->uuid,
        ];
    }
}