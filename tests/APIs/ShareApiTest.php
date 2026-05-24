<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Share;

class ShareApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_share()
    {
         $this->withoutExceptionHandling();
        $share = Share::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/shares', $share
        );

        $this->assertApiResponse($share);
    }

    /**
     * @test
     */
    public function test_read_share()
    {
        $this->withoutExceptionHandling();
        $share = Share::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/shares/'.$share->id
        );

        $this->assertApiResponse($share->toArray());
    }

    /**
     * @test
     */
    public function test_update_share()
    {
        $this->withoutExceptionHandling();
        $share = Share::factory()->create();
        $editedShare = Share::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/shares/'.$share->id,
            $editedShare
        );

        $this->assertApiResponse($editedShare);
    }

    /**
     * @test
     */
    public function test_delete_share()
    {
        $this->withoutExceptionHandling();
        $share = Share::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/shares/'.$share->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/shares/'.$share->id
        );

        $this->response->assertStatus(404);
    }
}
