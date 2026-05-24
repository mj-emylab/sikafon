<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Role;

class RoleApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_role()
    {
         $this->withoutExceptionHandling();
        $role = Role::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/roles', $role
        );

        $this->assertApiResponse($role);
    }

    /**
     * @test
     */
    public function test_read_role()
    {
        $this->withoutExceptionHandling();
        $role = Role::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/roles/'.$role->id
        );

        $this->assertApiResponse($role->toArray());
    }

    /**
     * @test
     */
    public function test_update_role()
    {
        $this->withoutExceptionHandling();
        $role = Role::factory()->create();
        $editedRole = Role::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/roles/'.$role->id,
            $editedRole
        );

        $this->assertApiResponse($editedRole);
    }

    /**
     * @test
     */
    public function test_delete_role()
    {
        $this->withoutExceptionHandling();
        $role = Role::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/roles/'.$role->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/roles/'.$role->id
        );

        $this->response->assertStatus(404);
    }
}
