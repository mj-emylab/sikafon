<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\RequestLog;

class RequestLogApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_request_log()
    {
         $this->withoutExceptionHandling();
        $requestLog = RequestLog::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/request_logs', $requestLog
        );

        $this->assertApiResponse($requestLog);
    }

    /**
     * @test
     */
    public function test_read_request_log()
    {
        $this->withoutExceptionHandling();
        $requestLog = RequestLog::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/request_logs/'.$requestLog->id
        );

        $this->assertApiResponse($requestLog->toArray());
    }

    /**
     * @test
     */
    public function test_update_request_log()
    {
        $this->withoutExceptionHandling();
        $requestLog = RequestLog::factory()->create();
        $editedRequestLog = RequestLog::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/request_logs/'.$requestLog->id,
            $editedRequestLog
        );

        $this->assertApiResponse($editedRequestLog);
    }

    /**
     * @test
     */
    public function test_delete_request_log()
    {
        $this->withoutExceptionHandling();
        $requestLog = RequestLog::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/request_logs/'.$requestLog->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/request_logs/'.$requestLog->id
        );

        $this->response->assertStatus(404);
    }
}
