<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Region;

class RegionApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_region()
    {
         $this->withoutExceptionHandling();
        $region = Region::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/regions', $region
        );

        $this->assertApiResponse($region);
    }

    /**
     * @test
     */
    public function test_read_region()
    {
        $this->withoutExceptionHandling();
        $region = Region::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/regions/'.$region->id
        );

        $this->assertApiResponse($region->toArray());
    }

    /**
     * @test
     */
    public function test_update_region()
    {
        $this->withoutExceptionHandling();
        $region = Region::factory()->create();
        $editedRegion = Region::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/regions/'.$region->id,
            $editedRegion
        );

        $this->assertApiResponse($editedRegion);
    }

    /**
     * @test
     */
    public function test_delete_region()
    {
        $this->withoutExceptionHandling();
        $region = Region::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/regions/'.$region->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/regions/'.$region->id
        );

        $this->response->assertStatus(404);
    }
}
