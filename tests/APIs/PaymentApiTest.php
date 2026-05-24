<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Payment;

class PaymentApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_payment()
    {
         $this->withoutExceptionHandling();
        $payment = Payment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/payments', $payment
        );

        $this->assertApiResponse($payment);
    }

    /**
     * @test
     */
    public function test_read_payment()
    {
        $this->withoutExceptionHandling();
        $payment = Payment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/payments/'.$payment->id
        );

        $this->assertApiResponse($payment->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment()
    {
        $this->withoutExceptionHandling();
        $payment = Payment::factory()->create();
        $editedPayment = Payment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/payments/'.$payment->id,
            $editedPayment
        );

        $this->assertApiResponse($editedPayment);
    }

    /**
     * @test
     */
    public function test_delete_payment()
    {
        $this->withoutExceptionHandling();
        $payment = Payment::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/payments/'.$payment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/payments/'.$payment->id
        );

        $this->response->assertStatus(404);
    }
}
