<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Card;

class CardApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_card()
    {
         $this->withoutExceptionHandling();
        $card = Card::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/cards', $card
        );

        $this->assertApiResponse($card);
    }

    /**
     * @test
     */
    public function test_read_card()
    {
        $this->withoutExceptionHandling();
        $card = Card::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/cards/'.$card->id
        );

        $this->assertApiResponse($card->toArray());
    }

    /**
     * @test
     */
    public function test_update_card()
    {
        $this->withoutExceptionHandling();
        $card = Card::factory()->create();
        $editedCard = Card::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/cards/'.$card->id,
            $editedCard
        );

        $this->assertApiResponse($editedCard);
    }

    /**
     * @test
     */
    public function test_delete_card()
    {
        $this->withoutExceptionHandling();
        $card = Card::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/cards/'.$card->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/cards/'.$card->id
        );

        $this->response->assertStatus(404);
    }
}
