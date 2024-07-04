<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    use WithFaker;

    public function definition(): array
    {
        return [
            'identifier' => $this->faker->unique()->userName(),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail,
            'bio' => $this->faker->sentence,
            'phone' => $this->faker->phoneNumber,
            'banner_picture' => $this->faker->imageUrl(),
            'profile_picture' => $this->faker->imageUrl(),
            'password' => "azeAZE123*",
        ];
    }
}
