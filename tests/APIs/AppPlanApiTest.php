<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AppPlan;

class AppPlanApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_app_plan()
    {
         $this->withoutExceptionHandling();
        $appPlan = AppPlan::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/app_plans', $appPlan
        );

        $this->assertApiResponse($appPlan);
    }

    /**
     * @test
     */
    public function test_read_app_plan()
    {
        $this->withoutExceptionHandling();
        $appPlan = AppPlan::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/app_plans/'.$appPlan->id
        );

        $this->assertApiResponse($appPlan->toArray());
    }

    /**
     * @test
     */
    public function test_update_app_plan()
    {
        $this->withoutExceptionHandling();
        $appPlan = AppPlan::factory()->create();
        $editedAppPlan = AppPlan::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/app_plans/'.$appPlan->id,
            $editedAppPlan
        );

        $this->assertApiResponse($editedAppPlan);
    }

    /**
     * @test
     */
    public function test_delete_app_plan()
    {
        $this->withoutExceptionHandling();
        $appPlan = AppPlan::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/app_plans/'.$appPlan->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/app_plans/'.$appPlan->id
        );

        $this->response->assertStatus(404);
    }
}
