<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Permission;

class PermissionApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_permission()
    {
         $this->withoutExceptionHandling();
        $permission = Permission::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/permissions', $permission
        );

        $this->assertApiResponse($permission);
    }

    /**
     * @test
     */
    public function test_read_permission()
    {
        $this->withoutExceptionHandling();
        $permission = Permission::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/permissions/'.$permission->id
        );

        $this->assertApiResponse($permission->toArray());
    }

    /**
     * @test
     */
    public function test_update_permission()
    {
        $this->withoutExceptionHandling();
        $permission = Permission::factory()->create();
        $editedPermission = Permission::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/permissions/'.$permission->id,
            $editedPermission
        );

        $this->assertApiResponse($editedPermission);
    }

    /**
     * @test
     */
    public function test_delete_permission()
    {
        $this->withoutExceptionHandling();
        $permission = Permission::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/permissions/'.$permission->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/permissions/'.$permission->id
        );

        $this->response->assertStatus(404);
    }
}
