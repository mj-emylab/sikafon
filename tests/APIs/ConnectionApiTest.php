<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Connection;

class ConnectionApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_connection()
    {
         $this->withoutExceptionHandling();
        $connection = Connection::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/connections', $connection
        );

        $this->assertApiResponse($connection);
    }

    /**
     * @test
     */
    public function test_read_connection()
    {
        $this->withoutExceptionHandling();
        $connection = Connection::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/connections/'.$connection->id
        );

        $this->assertApiResponse($connection->toArray());
    }

    /**
     * @test
     */
    public function test_update_connection()
    {
        $this->withoutExceptionHandling();
        $connection = Connection::factory()->create();
        $editedConnection = Connection::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/connections/'.$connection->id,
            $editedConnection
        );

        $this->assertApiResponse($editedConnection);
    }

    /**
     * @test
     */
    public function test_delete_connection()
    {
        $this->withoutExceptionHandling();
        $connection = Connection::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/connections/'.$connection->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/connections/'.$connection->id
        );

        $this->response->assertStatus(404);
    }
}
