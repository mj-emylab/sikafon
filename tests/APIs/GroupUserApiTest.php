<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\GroupUser;

class GroupUserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_group_user()
    {
         $this->withoutExceptionHandling();
        $groupUser = GroupUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/group_users', $groupUser
        );

        $this->assertApiResponse($groupUser);
    }

    /**
     * @test
     */
    public function test_read_group_user()
    {
        $this->withoutExceptionHandling();
        $groupUser = GroupUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/group_users/'.$groupUser->id
        );

        $this->assertApiResponse($groupUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_group_user()
    {
        $this->withoutExceptionHandling();
        $groupUser = GroupUser::factory()->create();
        $editedGroupUser = GroupUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/group_users/'.$groupUser->id,
            $editedGroupUser
        );

        $this->assertApiResponse($editedGroupUser);
    }

    /**
     * @test
     */
    public function test_delete_group_user()
    {
        $this->withoutExceptionHandling();
        $groupUser = GroupUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/group_users/'.$groupUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/group_users/'.$groupUser->id
        );

        $this->response->assertStatus(404);
    }
}
