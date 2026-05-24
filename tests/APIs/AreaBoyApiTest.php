<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AreaBoy;

class AreaBoyApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_area_boy()
    {
         $this->withoutExceptionHandling();
        $areaBoy = AreaBoy::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/area_boys', $areaBoy
        );

        $this->assertApiResponse($areaBoy);
    }

    /**
     * @test
     */
    public function test_read_area_boy()
    {
        $this->withoutExceptionHandling();
        $areaBoy = AreaBoy::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/area_boys/'.$areaBoy->id
        );

        $this->assertApiResponse($areaBoy->toArray());
    }

    /**
     * @test
     */
    public function test_update_area_boy()
    {
        $this->withoutExceptionHandling();
        $areaBoy = AreaBoy::factory()->create();
        $editedAreaBoy = AreaBoy::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/area_boys/'.$areaBoy->id,
            $editedAreaBoy
        );

        $this->assertApiResponse($editedAreaBoy);
    }

    /**
     * @test
     */
    public function test_delete_area_boy()
    {
        $this->withoutExceptionHandling();
        $areaBoy = AreaBoy::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/area_boys/'.$areaBoy->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/area_boys/'.$areaBoy->id
        );

        $this->response->assertStatus(404);
    }
}
