<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PaymentChannel;

class PaymentChannelApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_payment_channel()
    {
         $this->withoutExceptionHandling();
        $paymentChannel = PaymentChannel::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/payment_channels', $paymentChannel
        );

        $this->assertApiResponse($paymentChannel);
    }

    /**
     * @test
     */
    public function test_read_payment_channel()
    {
        $this->withoutExceptionHandling();
        $paymentChannel = PaymentChannel::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/payment_channels/'.$paymentChannel->id
        );

        $this->assertApiResponse($paymentChannel->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment_channel()
    {
        $this->withoutExceptionHandling();
        $paymentChannel = PaymentChannel::factory()->create();
        $editedPaymentChannel = PaymentChannel::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/payment_channels/'.$paymentChannel->id,
            $editedPaymentChannel
        );

        $this->assertApiResponse($editedPaymentChannel);
    }

    /**
     * @test
     */
    public function test_delete_payment_channel()
    {
        $this->withoutExceptionHandling();
        $paymentChannel = PaymentChannel::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/payment_channels/'.$paymentChannel->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/payment_channels/'.$paymentChannel->id
        );

        $this->response->assertStatus(404);
    }
}
