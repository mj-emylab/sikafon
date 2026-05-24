<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AreaManager;

class AreaManagerApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_area_manager()
    {
         $this->withoutExceptionHandling();
        $areaManager = AreaManager::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/area_managers', $areaManager
        );

        $this->assertApiResponse($areaManager);
    }

    /**
     * @test
     */
    public function test_read_area_manager()
    {
        $this->withoutExceptionHandling();
        $areaManager = AreaManager::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/area_managers/'.$areaManager->id
        );

        $this->assertApiResponse($areaManager->toArray());
    }

    /**
     * @test
     */
    public function test_update_area_manager()
    {
        $this->withoutExceptionHandling();
        $areaManager = AreaManager::factory()->create();
        $editedAreaManager = AreaManager::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/area_managers/'.$areaManager->id,
            $editedAreaManager
        );

        $this->assertApiResponse($editedAreaManager);
    }

    /**
     * @test
     */
    public function test_delete_area_manager()
    {
        $this->withoutExceptionHandling();
        $areaManager = AreaManager::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/area_managers/'.$areaManager->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/area_managers/'.$areaManager->id
        );

        $this->response->assertStatus(404);
    }
}
