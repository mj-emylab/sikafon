<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Session;

class SessionApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_session()
    {
         $this->withoutExceptionHandling();
        $session = Session::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/sessions', $session
        );

        $this->assertApiResponse($session);
    }

    /**
     * @test
     */
    public function test_read_session()
    {
        $this->withoutExceptionHandling();
        $session = Session::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/sessions/'.$session->id
        );

        $this->assertApiResponse($session->toArray());
    }

    /**
     * @test
     */
    public function test_update_session()
    {
        $this->withoutExceptionHandling();
        $session = Session::factory()->create();
        $editedSession = Session::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/sessions/'.$session->id,
            $editedSession
        );

        $this->assertApiResponse($editedSession);
    }

    /**
     * @test
     */
    public function test_delete_session()
    {
        $this->withoutExceptionHandling();
        $session = Session::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/sessions/'.$session->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/sessions/'.$session->id
        );

        $this->response->assertStatus(404);
    }
}
