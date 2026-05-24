<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Community;

class CommunityApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_community()
    {
         $this->withoutExceptionHandling();
        $community = Community::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/communities', $community
        );

        $this->assertApiResponse($community);
    }

    /**
     * @test
     */
    public function test_read_community()
    {
        $this->withoutExceptionHandling();
        $community = Community::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/communities/'.$community->id
        );

        $this->assertApiResponse($community->toArray());
    }

    /**
     * @test
     */
    public function test_update_community()
    {
        $this->withoutExceptionHandling();
        $community = Community::factory()->create();
        $editedCommunity = Community::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/communities/'.$community->id,
            $editedCommunity
        );

        $this->assertApiResponse($editedCommunity);
    }

    /**
     * @test
     */
    public function test_delete_community()
    {
        $this->withoutExceptionHandling();
        $community = Community::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/communities/'.$community->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/communities/'.$community->id
        );

        $this->response->assertStatus(404);
    }
}
