<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Log;

class LogApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_log()
    {
         $this->withoutExceptionHandling();
        $log = Log::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/logs', $log
        );

        $this->assertApiResponse($log);
    }

    /**
     * @test
     */
    public function test_read_log()
    {
        $this->withoutExceptionHandling();
        $log = Log::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/logs/'.$log->id
        );

        $this->assertApiResponse($log->toArray());
    }

    /**
     * @test
     */
    public function test_update_log()
    {
        $this->withoutExceptionHandling();
        $log = Log::factory()->create();
        $editedLog = Log::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/logs/'.$log->id,
            $editedLog
        );

        $this->assertApiResponse($editedLog);
    }

    /**
     * @test
     */
    public function test_delete_log()
    {
        $this->withoutExceptionHandling();
        $log = Log::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/logs/'.$log->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/logs/'.$log->id
        );

        $this->response->assertStatus(404);
    }
}
