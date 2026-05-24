<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Pin;

class PinApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_pin()
    {
         $this->withoutExceptionHandling();
        $pin = Pin::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/pins', $pin
        );

        $this->assertApiResponse($pin);
    }

    /**
     * @test
     */
    public function test_read_pin()
    {
        $this->withoutExceptionHandling();
        $pin = Pin::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/pins/'.$pin->id
        );

        $this->assertApiResponse($pin->toArray());
    }

    /**
     * @test
     */
    public function test_update_pin()
    {
        $this->withoutExceptionHandling();
        $pin = Pin::factory()->create();
        $editedPin = Pin::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/pins/'.$pin->id,
            $editedPin
        );

        $this->assertApiResponse($editedPin);
    }

    /**
     * @test
     */
    public function test_delete_pin()
    {
        $this->withoutExceptionHandling();
        $pin = Pin::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/pins/'.$pin->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/pins/'.$pin->id
        );

        $this->response->assertStatus(404);
    }
}
