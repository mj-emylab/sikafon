<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AccountUser;

class AccountUserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_account_user()
    {
         $this->withoutExceptionHandling();
        $accountUser = AccountUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/account_users', $accountUser
        );

        $this->assertApiResponse($accountUser);
    }

    /**
     * @test
     */
    public function test_read_account_user()
    {
        $this->withoutExceptionHandling();
        $accountUser = AccountUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/account_users/'.$accountUser->id
        );

        $this->assertApiResponse($accountUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_account_user()
    {
        $this->withoutExceptionHandling();
        $accountUser = AccountUser::factory()->create();
        $editedAccountUser = AccountUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/account_users/'.$accountUser->id,
            $editedAccountUser
        );

        $this->assertApiResponse($editedAccountUser);
    }

    /**
     * @test
     */
    public function test_delete_account_user()
    {
        $this->withoutExceptionHandling();
        $accountUser = AccountUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/account_users/'.$accountUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/account_users/'.$accountUser->id
        );

        $this->response->assertStatus(404);
    }
}
