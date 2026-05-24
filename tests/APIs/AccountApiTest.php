<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Account;

class AccountApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_account()
    {
         $this->withoutExceptionHandling();
        $account = Account::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/accounts', $account
        );

        $this->assertApiResponse($account);
    }

    /**
     * @test
     */
    public function test_read_account()
    {
        $this->withoutExceptionHandling();
        $account = Account::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/accounts/'.$account->id
        );

        $this->assertApiResponse($account->toArray());
    }

    /**
     * @test
     */
    public function test_update_account()
    {
        $this->withoutExceptionHandling();
        $account = Account::factory()->create();
        $editedAccount = Account::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/accounts/'.$account->id,
            $editedAccount
        );

        $this->assertApiResponse($editedAccount);
    }

    /**
     * @test
     */
    public function test_delete_account()
    {
        $this->withoutExceptionHandling();
        $account = Account::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/accounts/'.$account->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/accounts/'.$account->id
        );

        $this->response->assertStatus(404);
    }
}
