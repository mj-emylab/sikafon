<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Area;

class AreaApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_area()
    {
         $this->withoutExceptionHandling();
        $area = Area::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/areas', $area
        );

        $this->assertApiResponse($area);
    }

    /**
     * @test
     */
    public function test_read_area()
    {
        $this->withoutExceptionHandling();
        $area = Area::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/areas/'.$area->id
        );

        $this->assertApiResponse($area->toArray());
    }

    /**
     * @test
     */
    public function test_update_area()
    {
        $this->withoutExceptionHandling();
        $area = Area::factory()->create();
        $editedArea = Area::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/areas/'.$area->id,
            $editedArea
        );

        $this->assertApiResponse($editedArea);
    }

    /**
     * @test
     */
    public function test_delete_area()
    {
        $this->withoutExceptionHandling();
        $area = Area::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/areas/'.$area->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/areas/'.$area->id
        );

        $this->response->assertStatus(404);
    }
}
