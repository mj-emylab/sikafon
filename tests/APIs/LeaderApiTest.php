<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Leader;

class LeaderApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_leader()
    {
         $this->withoutExceptionHandling();
        $leader = Leader::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/leaders', $leader
        );

        $this->assertApiResponse($leader);
    }

    /**
     * @test
     */
    public function test_read_leader()
    {
        $this->withoutExceptionHandling();
        $leader = Leader::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/leaders/'.$leader->id
        );

        $this->assertApiResponse($leader->toArray());
    }

    /**
     * @test
     */
    public function test_update_leader()
    {
        $this->withoutExceptionHandling();
        $leader = Leader::factory()->create();
        $editedLeader = Leader::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/leaders/'.$leader->id,
            $editedLeader
        );

        $this->assertApiResponse($editedLeader);
    }

    /**
     * @test
     */
    public function test_delete_leader()
    {
        $this->withoutExceptionHandling();
        $leader = Leader::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/leaders/'.$leader->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/leaders/'.$leader->id
        );

        $this->response->assertStatus(404);
    }
}
