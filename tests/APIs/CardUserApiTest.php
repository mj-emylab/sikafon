<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CardUser;

class CardUserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_card_user()
    {
         $this->withoutExceptionHandling();
        $cardUser = CardUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/card_users', $cardUser
        );

        $this->assertApiResponse($cardUser);
    }

    /**
     * @test
     */
    public function test_read_card_user()
    {
        $this->withoutExceptionHandling();
        $cardUser = CardUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/card_users/'.$cardUser->id
        );

        $this->assertApiResponse($cardUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_card_user()
    {
        $this->withoutExceptionHandling();
        $cardUser = CardUser::factory()->create();
        $editedCardUser = CardUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/card_users/'.$cardUser->id,
            $editedCardUser
        );

        $this->assertApiResponse($editedCardUser);
    }

    /**
     * @test
     */
    public function test_delete_card_user()
    {
        $this->withoutExceptionHandling();
        $cardUser = CardUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/card_users/'.$cardUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/card_users/'.$cardUser->id
        );

        $this->response->assertStatus(404);
    }
}
