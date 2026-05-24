<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Group;

class GroupApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_group()
    {
         $this->withoutExceptionHandling();
        $group = Group::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/groups', $group
        );

        $this->assertApiResponse($group);
    }

    /**
     * @test
     */
    public function test_read_group()
    {
        $this->withoutExceptionHandling();
        $group = Group::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/groups/'.$group->id
        );

        $this->assertApiResponse($group->toArray());
    }

    /**
     * @test
     */
    public function test_update_group()
    {
        $this->withoutExceptionHandling();
        $group = Group::factory()->create();
        $editedGroup = Group::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/groups/'.$group->id,
            $editedGroup
        );

        $this->assertApiResponse($editedGroup);
    }

    /**
     * @test
     */
    public function test_delete_group()
    {
        $this->withoutExceptionHandling();
        $group = Group::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/groups/'.$group->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/groups/'.$group->id
        );

        $this->response->assertStatus(404);
    }
}
