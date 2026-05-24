<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Business;

class BusinessApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_business()
    {
         $this->withoutExceptionHandling();
        $business = Business::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/businesses', $business
        );

        $this->assertApiResponse($business);
    }

    /**
     * @test
     */
    public function test_read_business()
    {
        $this->withoutExceptionHandling();
        $business = Business::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/businesses/'.$business->id
        );

        $this->assertApiResponse($business->toArray());
    }

    /**
     * @test
     */
    public function test_update_business()
    {
        $this->withoutExceptionHandling();
        $business = Business::factory()->create();
        $editedBusiness = Business::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/businesses/'.$business->id,
            $editedBusiness
        );

        $this->assertApiResponse($editedBusiness);
    }

    /**
     * @test
     */
    public function test_delete_business()
    {
        $this->withoutExceptionHandling();
        $business = Business::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/businesses/'.$business->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/businesses/'.$business->id
        );

        $this->response->assertStatus(404);
    }
}
