<?php

namespace Database\Factories\User;

use App\Models\User\UserEmail;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User\UserEmail>
 */
class UserEmailFactory extends Factory
{
    protected $model = UserEmail::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'ue_email' => $this->faker->unique()->safeEmail,
        ];
    }
}
