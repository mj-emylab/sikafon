<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Service;

class ServiceApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_service()
    {
         $this->withoutExceptionHandling();
        $service = Service::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/services', $service
        );

        $this->assertApiResponse($service);
    }

    /**
     * @test
     */
    public function test_read_service()
    {
        $this->withoutExceptionHandling();
        $service = Service::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/services/'.$service->id
        );

        $this->assertApiResponse($service->toArray());
    }

    /**
     * @test
     */
    public function test_update_service()
    {
        $this->withoutExceptionHandling();
        $service = Service::factory()->create();
        $editedService = Service::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/services/'.$service->id,
            $editedService
        );

        $this->assertApiResponse($editedService);
    }

    /**
     * @test
     */
    public function test_delete_service()
    {
        $this->withoutExceptionHandling();
        $service = Service::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/services/'.$service->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/services/'.$service->id
        );

        $this->response->assertStatus(404);
    }
}
