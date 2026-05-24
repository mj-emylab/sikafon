<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\DistrictManager;

class DistrictManagerApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_district_manager()
    {
         $this->withoutExceptionHandling();
        $districtManager = DistrictManager::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/district_managers', $districtManager
        );

        $this->assertApiResponse($districtManager);
    }

    /**
     * @test
     */
    public function test_read_district_manager()
    {
        $this->withoutExceptionHandling();
        $districtManager = DistrictManager::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/district_managers/'.$districtManager->id
        );

        $this->assertApiResponse($districtManager->toArray());
    }

    /**
     * @test
     */
    public function test_update_district_manager()
    {
        $this->withoutExceptionHandling();
        $districtManager = DistrictManager::factory()->create();
        $editedDistrictManager = DistrictManager::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/district_managers/'.$districtManager->id,
            $editedDistrictManager
        );

        $this->assertApiResponse($editedDistrictManager);
    }

    /**
     * @test
     */
    public function test_delete_district_manager()
    {
        $this->withoutExceptionHandling();
        $districtManager = DistrictManager::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/district_managers/'.$districtManager->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/district_managers/'.$districtManager->id
        );

        $this->response->assertStatus(404);
    }
}
