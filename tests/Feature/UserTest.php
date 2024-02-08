<?php

namespace Tests\Feature;

use App\Models\User\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected $user;
    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()
            ->hasUserEmails(1, ['ue_primary' => true]) // Assurez-vous que ue_primary est défini sur true
            ->create();
    }


    /**
     * A basic feature test example.
     */
    public function test_update_user_successfully(): void
    {
        $this->actingAs($this->user);

        // dd($this->user->toArray());

        $requestData = [
            "u_firstname" => "John",
            "u_lastname" => "Doe",
            "u_birthdate" => "2004-10-10",
        ];

        $response = $this->patchJson('api/v1/users', $requestData);

        $response->assertStatus(200);
    }

    public function test_update_user_invalidates_data_types(): void
    {
        $this->actingAs($this->user);

        $requestData = [
            "u_firstname" => 23456789,
        ];

        $response = $this->patchJson('api/v1/users', $requestData);

        $response->assertStatus(422);
    }
    public function test_update_user_unauthenticated(): void
    {
        $requestData = [
            "u_firstname" => "jejrjer",
        ];

        $response = $this->patchJson('api/v1/users', $requestData);

        $response->assertStatus(401);
    }


    public function test_update_user_password_successfully(): void
    {
        $this->actingAs($this->user);

        $requestData = [
            "u_old_password" => "password",
            "u_password" => "password11Z",
            "u_password_confirmation" => "password11Z"
        ];

        $response = $this->patchJson('api/v1/users/password', $requestData);

        $response->assertStatus(200);
    }
    public function test_update_user_password_unauthenticated(): void
    {

        $requestData = [
            "u_old_password" => "password",
            "u_password" => "password11Z",
            "u_password_confirmation" => "password11Z"
        ];

        $response = $this->patchJson('api/v1/users/password', $requestData);

        $response->assertStatus(401);
    }
    public function test_update_user_password_wrong_old_password(): void
    {
        $this->actingAs($this->user);

        $requestData = [
            "u_old_password" => "pasdfdfgsword",
            "u_password" => "password11Z",
            "u_password_confirmation" => "password11Z"
        ];

        $response = $this->patchJson('api/v1/users/password', $requestData);

        $response->assertStatus(422);
    }
    public function test_update_user_password_new_password_not_confirmed(): void
    {
        $this->actingAs($this->user);

        $requestData = [
            "u_old_password" => "password",
            "u_password" => "password11Z",
            "u_password_confirmation" => "fdfdfdsfds"
        ];

        $response = $this->patchJson('api/v1/users/password', $requestData);

        $response->assertStatus(422);
    }
    public function test_update_user_password_new_password_bad_format(): void
    {
        $this->actingAs($this->user);

        $requestData = [
            "u_old_password" => "password",
            "u_password" => "passwo",
            "u_password_confirmation" => "passwo"
        ];

        $response = $this->patchJson('api/v1/users/password', $requestData);

        $response->assertStatus(422);
    }
}
