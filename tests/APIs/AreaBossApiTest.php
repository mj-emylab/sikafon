<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AreaBoss;

class AreaBossApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_area_boss()
    {
         $this->withoutExceptionHandling();
        $areaBoss = AreaBoss::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/area_bosses', $areaBoss
        );

        $this->assertApiResponse($areaBoss);
    }

    /**
     * @test
     */
    public function test_read_area_boss()
    {
        $this->withoutExceptionHandling();
        $areaBoss = AreaBoss::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/area_bosses/'.$areaBoss->id
        );

        $this->assertApiResponse($areaBoss->toArray());
    }

    /**
     * @test
     */
    public function test_update_area_boss()
    {
        $this->withoutExceptionHandling();
        $areaBoss = AreaBoss::factory()->create();
        $editedAreaBoss = AreaBoss::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/area_bosses/'.$areaBoss->id,
            $editedAreaBoss
        );

        $this->assertApiResponse($editedAreaBoss);
    }

    /**
     * @test
     */
    public function test_delete_area_boss()
    {
        $this->withoutExceptionHandling();
        $areaBoss = AreaBoss::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/area_bosses/'.$areaBoss->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/area_bosses/'.$areaBoss->id
        );

        $this->response->assertStatus(404);
    }
}
