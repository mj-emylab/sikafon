<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\SessionUser;

class SessionUserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_session_user()
    {
         $this->withoutExceptionHandling();
        $sessionUser = SessionUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/session_users', $sessionUser
        );

        $this->assertApiResponse($sessionUser);
    }

    /**
     * @test
     */
    public function test_read_session_user()
    {
        $this->withoutExceptionHandling();
        $sessionUser = SessionUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/session_users/'.$sessionUser->id
        );

        $this->assertApiResponse($sessionUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_session_user()
    {
        $this->withoutExceptionHandling();
        $sessionUser = SessionUser::factory()->create();
        $editedSessionUser = SessionUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/session_users/'.$sessionUser->id,
            $editedSessionUser
        );

        $this->assertApiResponse($editedSessionUser);
    }

    /**
     * @test
     */
    public function test_delete_session_user()
    {
        $this->withoutExceptionHandling();
        $sessionUser = SessionUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/session_users/'.$sessionUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/session_users/'.$sessionUser->id
        );

        $this->response->assertStatus(404);
    }
}
