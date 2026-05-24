<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Code;

class CodeApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_code()
    {
         $this->withoutExceptionHandling();
        $code = Code::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/codes', $code
        );

        $this->assertApiResponse($code);
    }

    /**
     * @test
     */
    public function test_read_code()
    {
        $this->withoutExceptionHandling();
        $code = Code::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/codes/'.$code->id
        );

        $this->assertApiResponse($code->toArray());
    }

    /**
     * @test
     */
    public function test_update_code()
    {
        $this->withoutExceptionHandling();
        $code = Code::factory()->create();
        $editedCode = Code::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/codes/'.$code->id,
            $editedCode
        );

        $this->assertApiResponse($editedCode);
    }

    /**
     * @test
     */
    public function test_delete_code()
    {
        $this->withoutExceptionHandling();
        $code = Code::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/codes/'.$code->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/codes/'.$code->id
        );

        $this->response->assertStatus(404);
    }
}
