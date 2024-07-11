<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     */
    public function test_register_user(): void
    {
        $user = User::factory()->create();


        $response = $this->postJson('api/v1/auth/login', [
            'id_or_email' => $user->email,
            'password' => "azeAZE123*",
        ]);

        $response->assertStatus(200);
    }

    public function test_login_user_with_invalid_data(): void
    {
        $response = $this->postJson('api/v1/auth/login', [
            'id_or_email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
        ]);

        $response->assertStatus(400);
    }

    public function test_register_user_with_invalid_data(): void
    {
        $response = $this->postJson('api/v1/auth/register', [
            'identifier' => 22,
            'email' => $this->faker->unique()->safeEmail,
            'password' => $this->faker->password,
        ]);

        $response->assertStatus(422);
    }

}
