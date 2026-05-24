<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AppPlanUser;

class AppPlanUserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_app_plan_user()
    {
         $this->withoutExceptionHandling();
        $appPlanUser = AppPlanUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/app_plan_users', $appPlanUser
        );

        $this->assertApiResponse($appPlanUser);
    }

    /**
     * @test
     */
    public function test_read_app_plan_user()
    {
        $this->withoutExceptionHandling();
        $appPlanUser = AppPlanUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/app_plan_users/'.$appPlanUser->id
        );

        $this->assertApiResponse($appPlanUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_app_plan_user()
    {
        $this->withoutExceptionHandling();
        $appPlanUser = AppPlanUser::factory()->create();
        $editedAppPlanUser = AppPlanUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/app_plan_users/'.$appPlanUser->id,
            $editedAppPlanUser
        );

        $this->assertApiResponse($editedAppPlanUser);
    }

    /**
     * @test
     */
    public function test_delete_app_plan_user()
    {
        $this->withoutExceptionHandling();
        $appPlanUser = AppPlanUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/app_plan_users/'.$appPlanUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/app_plan_users/'.$appPlanUser->id
        );

        $this->response->assertStatus(404);
    }
}
