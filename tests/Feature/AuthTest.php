<?php

namespace Tests\Feature;

use App\Http\Controllers\API\Auth\RegisterController;
use App\Mail\RegisterMail;
use App\Models\User\User;
use Database\Factories\UserFactory;
use Database\Seeders\ClearUserTableSeeder;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class AuthTest extends TestCase
{
    const URL = '/api/auth';

    private string $email = "test@test.test";
    private string $password = "azeAZE123";

    public function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    public function test_register()
    {
        $this->seed(ClearUserTableSeeder::class);

        $response = $this->post(self::URL . '/register/email', [
            'ue_email' => $this->email,
        ]);

        // Token exist in cache
        $token = Cache::get(RegisterController::CACHE_KEY . $this->email)[0] ?? null;
        $this->assertNotNull($token);

        // Mail is sent
        // Mail::assertSent(RegisterMail::class, function ($mail) {
        //     return true;
        // });

        $response->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();

        // Token is valid
        $response = $this->get(self::URL . '/register/email?token=' . $token);

        $response->assertStatus(Response::HTTP_NO_CONTENT)
            ->assertNoContent();

        // User created
        $response = $this->post(self::URL . '/register/password', [
            'token' => $token,
            'u_password' => $this->password,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @depends test_register
     */
    public function test_login($token)
    {
        $response = $this->post(self::URL . '/login', [
            'ue_email' => $this->email,
            'u_password' => $this->password,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    //TODO : create logout unit test
}
