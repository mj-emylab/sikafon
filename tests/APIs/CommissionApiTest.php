<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Commission;

class CommissionApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_commission()
    {
         $this->withoutExceptionHandling();
        $commission = Commission::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/commissions', $commission
        );

        $this->assertApiResponse($commission);
    }

    /**
     * @test
     */
    public function test_read_commission()
    {
        $this->withoutExceptionHandling();
        $commission = Commission::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/commissions/'.$commission->id
        );

        $this->assertApiResponse($commission->toArray());
    }

    /**
     * @test
     */
    public function test_update_commission()
    {
        $this->withoutExceptionHandling();
        $commission = Commission::factory()->create();
        $editedCommission = Commission::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/commissions/'.$commission->id,
            $editedCommission
        );

        $this->assertApiResponse($editedCommission);
    }

    /**
     * @test
     */
    public function test_delete_commission()
    {
        $this->withoutExceptionHandling();
        $commission = Commission::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/commissions/'.$commission->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/commissions/'.$commission->id
        );

        $this->response->assertStatus(404);
    }
}
