<?php

namespace Tests\Feature;

use App\Enums\Status;
use App\Models\Card\Card;
use App\Models\User\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Tests\TestCase;

class UnsyncCardTest extends TestCase
{
    use WithFaker;
    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()
            ->hasUserEmails(1, ['ue_primary' => true])
            ->hasCards(1)
            ->create();
    }


    /**
     * A basic feature test example.
     */
    public function test_create_unsync_card_successfully()
    {

        $this->actingAs($this->user);

        // Création des données de la requête
        $requestData = [
            "c_id" => $this->user->cards[0]->c_id,
            "c_firstname" => $this->faker->firstName(),
            "c_lastname" => $this->faker->lastName(),
            "c_position" => $this->faker->jobTitle(),
            "c_email" => $this->faker->unique()->safeEmail(),
            "c_entity" => $this->faker->company(),
            "c_tag" => $this->faker->sentence(10, true),
            "c_profile_picture" => $this->faker->imageUrl(),
            "c_background" => $this->faker->imageUrl(),
            "card_phones" => [
                [
                    "cp_phone" => "+33010203054",
                ]
            ]
        ];
        $response = $this->postJson('api/v1/cards/unsync', $requestData);

        $response->assertStatus(Response::HTTP_CREATED); // HTTP 201 Created
    }
    public function test_create_unsync_card_no_mandatory_fields()
    {
        $this->actingAs($this->user);

        $requestData = [
            "c_id" => $this->user->cards[0]->c_id,
        ];

        $response = $this->postJson('api/v1/cards/unsync', $requestData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY); // Statut de création réussie
    }
    public function test_create_unsync_card_invalidates_data_types()
    {
        $this->actingAs($this->user);

        $requestData = [
            "c_id" => $this->user->cards[0]->c_id,
            "c_firstname" => $this->faker->numberBetween(0, 100),
        ];
        $response = $this->postJson('api/v1/cards/unsync', $requestData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_create_unsync_card_unauthenticated()
    {
        $requestData = [
            "c_id" => $this->user->cards[0]->c_id,
            "c_firstname" => $this->faker->numberBetween(0, 100),
        ];
        $response = $this->postJson('api/v1/cards/unsync', $requestData);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_update_unsync_card_successfully()
    {
        $this->actingAs($this->user);
        $requestData = [
            "c_firstname" => $this->faker->firstName(),
            "card_phones" => [
                [
                    "cp_id" => 1,
                    "cp_phone" => "+33000000"
                ]
            ]
        ];
        $response = $this->patchJson('api/v1/cards/unsync/' . $this->user->cards[0]->c_id, $requestData);

        $response->assertStatus(Response::HTTP_OK);
    }
    public function test_update_unsync_card_card_is_deleted()
    {
        $this->actingAs($this->user);

        $deletedCard = Card::factory()->create([
            'c_status' => Status::DELETED,
        ]);

        $response = $this->deleteJson('api/v1/cards/unsync/' . $deletedCard->c_id);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    public function test_update_unsync_card_successfully_invalidates_data_types()
    {
        $this->actingAs($this->user);
        $requestData = [
            "c_firstname" => $this->faker->numberBetween(0, 100),
        ];
        $response = $this->patchJson('api/v1/cards/unsync/' . $this->user->cards[0]->c_id, $requestData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }
    public function test_update_unsync_card_successfully_unauthenticated()
    {

        $requestData = [
            "c_firstname" => $this->faker->firstName(),
        ];
        $response = $this->patchJson('api/v1/cards/unsync/' . $this->user->cards[0]->c_id, $requestData);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_delete_unsync_card_successfully()
    {
        $this->actingAs($this->user);

        $response = $this->deleteJson('api/v1/cards/unsync/' . $this->user->cards[0]->c_id);

        $response->assertStatus(Response::HTTP_OK);
    }
    public function test_delete_unsync_card_unauthenticated()
    {
        $response = $this->deleteJson('api/v1/cards/unsync/' . $this->user->cards[0]->c_id);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function test_delete_unsync_card_card_is_deleted()
    {
        $this->actingAs($this->user);

        $deletedCard = Card::factory()->create([
            'c_status' => Status::DELETED,
        ]);
        $response = $this->deleteJson('api/v1/cards/unsync/' . $deletedCard->c_id);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
