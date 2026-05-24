<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\CommunityUser;

class CommunityUserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_community_user()
    {
         $this->withoutExceptionHandling();
        $communityUser = CommunityUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/community_users', $communityUser
        );

        $this->assertApiResponse($communityUser);
    }

    /**
     * @test
     */
    public function test_read_community_user()
    {
        $this->withoutExceptionHandling();
        $communityUser = CommunityUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/community_users/'.$communityUser->id
        );

        $this->assertApiResponse($communityUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_community_user()
    {
        $this->withoutExceptionHandling();
        $communityUser = CommunityUser::factory()->create();
        $editedCommunityUser = CommunityUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/community_users/'.$communityUser->id,
            $editedCommunityUser
        );

        $this->assertApiResponse($editedCommunityUser);
    }

    /**
     * @test
     */
    public function test_delete_community_user()
    {
        $this->withoutExceptionHandling();
        $communityUser = CommunityUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/community_users/'.$communityUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/community_users/'.$communityUser->id
        );

        $this->response->assertStatus(404);
    }
}
