<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Verification;

class VerificationApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_verification()
    {
         $this->withoutExceptionHandling();
        $verification = Verification::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/verifications', $verification
        );

        $this->assertApiResponse($verification);
    }

    /**
     * @test
     */
    public function test_read_verification()
    {
        $this->withoutExceptionHandling();
        $verification = Verification::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/verifications/'.$verification->id
        );

        $this->assertApiResponse($verification->toArray());
    }

    /**
     * @test
     */
    public function test_update_verification()
    {
        $this->withoutExceptionHandling();
        $verification = Verification::factory()->create();
        $editedVerification = Verification::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/verifications/'.$verification->id,
            $editedVerification
        );

        $this->assertApiResponse($editedVerification);
    }

    /**
     * @test
     */
    public function test_delete_verification()
    {
        $this->withoutExceptionHandling();
        $verification = Verification::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/verifications/'.$verification->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/verifications/'.$verification->id
        );

        $this->response->assertStatus(404);
    }
}
