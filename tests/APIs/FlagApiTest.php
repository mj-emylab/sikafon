<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Flag;

class FlagApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_flag()
    {
         $this->withoutExceptionHandling();
        $flag = Flag::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/flags', $flag
        );

        $this->assertApiResponse($flag);
    }

    /**
     * @test
     */
    public function test_read_flag()
    {
        $this->withoutExceptionHandling();
        $flag = Flag::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/flags/'.$flag->id
        );

        $this->assertApiResponse($flag->toArray());
    }

    /**
     * @test
     */
    public function test_update_flag()
    {
        $this->withoutExceptionHandling();
        $flag = Flag::factory()->create();
        $editedFlag = Flag::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/flags/'.$flag->id,
            $editedFlag
        );

        $this->assertApiResponse($editedFlag);
    }

    /**
     * @test
     */
    public function test_delete_flag()
    {
        $this->withoutExceptionHandling();
        $flag = Flag::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/flags/'.$flag->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/flags/'.$flag->id
        );

        $this->response->assertStatus(404);
    }
}
