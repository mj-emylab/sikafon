<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\User;

class UserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_user()
    {
         $this->withoutExceptionHandling();
        $user = User::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/users', $user
        );

        $this->assertApiResponse($user);
    }

    /**
     * @test
     */
    public function test_read_user()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/users/'.$user->id
        );

        $this->assertApiResponse($user->toArray());
    }

    /**
     * @test
     */
    public function test_update_user()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $editedUser = User::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/users/'.$user->id,
            $editedUser
        );

        $this->assertApiResponse($editedUser);
    }

    /**
     * @test
     */
    public function test_delete_user()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/users/'.$user->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/users/'.$user->id
        );

        $this->response->assertStatus(404);
    }
}
