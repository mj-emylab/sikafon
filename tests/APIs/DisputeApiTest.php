<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Dispute;

class DisputeApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_dispute()
    {
         $this->withoutExceptionHandling();
        $dispute = Dispute::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/disputes', $dispute
        );

        $this->assertApiResponse($dispute);
    }

    /**
     * @test
     */
    public function test_read_dispute()
    {
        $this->withoutExceptionHandling();
        $dispute = Dispute::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/disputes/'.$dispute->id
        );

        $this->assertApiResponse($dispute->toArray());
    }

    /**
     * @test
     */
    public function test_update_dispute()
    {
        $this->withoutExceptionHandling();
        $dispute = Dispute::factory()->create();
        $editedDispute = Dispute::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/disputes/'.$dispute->id,
            $editedDispute
        );

        $this->assertApiResponse($editedDispute);
    }

    /**
     * @test
     */
    public function test_delete_dispute()
    {
        $this->withoutExceptionHandling();
        $dispute = Dispute::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/disputes/'.$dispute->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/disputes/'.$dispute->id
        );

        $this->response->assertStatus(404);
    }
}
