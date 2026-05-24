<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Followship;

class FollowshipApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_followship()
    {
         $this->withoutExceptionHandling();
        $followship = Followship::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/followships', $followship
        );

        $this->assertApiResponse($followship);
    }

    /**
     * @test
     */
    public function test_read_followship()
    {
        $this->withoutExceptionHandling();
        $followship = Followship::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/followships/'.$followship->id
        );

        $this->assertApiResponse($followship->toArray());
    }

    /**
     * @test
     */
    public function test_update_followship()
    {
        $this->withoutExceptionHandling();
        $followship = Followship::factory()->create();
        $editedFollowship = Followship::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/followships/'.$followship->id,
            $editedFollowship
        );

        $this->assertApiResponse($editedFollowship);
    }

    /**
     * @test
     */
    public function test_delete_followship()
    {
        $this->withoutExceptionHandling();
        $followship = Followship::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/followships/'.$followship->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/followships/'.$followship->id
        );

        $this->response->assertStatus(404);
    }
}
