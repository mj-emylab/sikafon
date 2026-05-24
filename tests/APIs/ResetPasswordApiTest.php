<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\ResetPassword;

class ResetPasswordApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_reset_password()
    {
         $this->withoutExceptionHandling();
        $resetPassword = ResetPassword::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/reset_passwords', $resetPassword
        );

        $this->assertApiResponse($resetPassword);
    }

    /**
     * @test
     */
    public function test_read_reset_password()
    {
        $this->withoutExceptionHandling();
        $resetPassword = ResetPassword::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/reset_passwords/'.$resetPassword->id
        );

        $this->assertApiResponse($resetPassword->toArray());
    }

    /**
     * @test
     */
    public function test_update_reset_password()
    {
        $this->withoutExceptionHandling();
        $resetPassword = ResetPassword::factory()->create();
        $editedResetPassword = ResetPassword::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/reset_passwords/'.$resetPassword->id,
            $editedResetPassword
        );

        $this->assertApiResponse($editedResetPassword);
    }

    /**
     * @test
     */
    public function test_delete_reset_password()
    {
        $this->withoutExceptionHandling();
        $resetPassword = ResetPassword::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/reset_passwords/'.$resetPassword->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/reset_passwords/'.$resetPassword->id
        );

        $this->response->assertStatus(404);
    }
}
