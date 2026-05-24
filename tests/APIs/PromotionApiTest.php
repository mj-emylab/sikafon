<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Promotion;

class PromotionApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_promotion()
    {
         $this->withoutExceptionHandling();
        $promotion = Promotion::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/promotions', $promotion
        );

        $this->assertApiResponse($promotion);
    }

    /**
     * @test
     */
    public function test_read_promotion()
    {
        $this->withoutExceptionHandling();
        $promotion = Promotion::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/promotions/'.$promotion->id
        );

        $this->assertApiResponse($promotion->toArray());
    }

    /**
     * @test
     */
    public function test_update_promotion()
    {
        $this->withoutExceptionHandling();
        $promotion = Promotion::factory()->create();
        $editedPromotion = Promotion::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/promotions/'.$promotion->id,
            $editedPromotion
        );

        $this->assertApiResponse($editedPromotion);
    }

    /**
     * @test
     */
    public function test_delete_promotion()
    {
        $this->withoutExceptionHandling();
        $promotion = Promotion::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/promotions/'.$promotion->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/promotions/'.$promotion->id
        );

        $this->response->assertStatus(404);
    }
}
