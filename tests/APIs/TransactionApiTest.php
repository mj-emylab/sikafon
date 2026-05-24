<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Transaction;

class TransactionApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_transaction()
    {
         $this->withoutExceptionHandling();
        $transaction = Transaction::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/transactions', $transaction
        );

        $this->assertApiResponse($transaction);
    }

    /**
     * @test
     */
    public function test_read_transaction()
    {
        $this->withoutExceptionHandling();
        $transaction = Transaction::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/transactions/'.$transaction->id
        );

        $this->assertApiResponse($transaction->toArray());
    }

    /**
     * @test
     */
    public function test_update_transaction()
    {
        $this->withoutExceptionHandling();
        $transaction = Transaction::factory()->create();
        $editedTransaction = Transaction::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/transactions/'.$transaction->id,
            $editedTransaction
        );

        $this->assertApiResponse($editedTransaction);
    }

    /**
     * @test
     */
    public function test_delete_transaction()
    {
        $this->withoutExceptionHandling();
        $transaction = Transaction::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/transactions/'.$transaction->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/transactions/'.$transaction->id
        );

        $this->response->assertStatus(404);
    }
}
