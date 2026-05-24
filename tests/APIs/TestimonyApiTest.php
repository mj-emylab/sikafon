<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Testimony;

class TestimonyApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_testimony()
    {
         $this->withoutExceptionHandling();
        $testimony = Testimony::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/testimonies', $testimony
        );

        $this->assertApiResponse($testimony);
    }

    /**
     * @test
     */
    public function test_read_testimony()
    {
        $this->withoutExceptionHandling();
        $testimony = Testimony::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/testimonies/'.$testimony->id
        );

        $this->assertApiResponse($testimony->toArray());
    }

    /**
     * @test
     */
    public function test_update_testimony()
    {
        $this->withoutExceptionHandling();
        $testimony = Testimony::factory()->create();
        $editedTestimony = Testimony::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/testimonies/'.$testimony->id,
            $editedTestimony
        );

        $this->assertApiResponse($editedTestimony);
    }

    /**
     * @test
     */
    public function test_delete_testimony()
    {
        $this->withoutExceptionHandling();
        $testimony = Testimony::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/testimonies/'.$testimony->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/testimonies/'.$testimony->id
        );

        $this->response->assertStatus(404);
    }
}
