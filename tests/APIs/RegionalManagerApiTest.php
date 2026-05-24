<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\RegionalManager;

class RegionalManagerApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_regional_manager()
    {
         $this->withoutExceptionHandling();
        $regionalManager = RegionalManager::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/regional_managers', $regionalManager
        );

        $this->assertApiResponse($regionalManager);
    }

    /**
     * @test
     */
    public function test_read_regional_manager()
    {
        $this->withoutExceptionHandling();
        $regionalManager = RegionalManager::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/regional_managers/'.$regionalManager->id
        );

        $this->assertApiResponse($regionalManager->toArray());
    }

    /**
     * @test
     */
    public function test_update_regional_manager()
    {
        $this->withoutExceptionHandling();
        $regionalManager = RegionalManager::factory()->create();
        $editedRegionalManager = RegionalManager::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/regional_managers/'.$regionalManager->id,
            $editedRegionalManager
        );

        $this->assertApiResponse($editedRegionalManager);
    }

    /**
     * @test
     */
    public function test_delete_regional_manager()
    {
        $this->withoutExceptionHandling();
        $regionalManager = RegionalManager::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/regional_managers/'.$regionalManager->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/regional_managers/'.$regionalManager->id
        );

        $this->response->assertStatus(404);
    }
}
