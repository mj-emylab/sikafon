<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\App;

class AppApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_app()
    {
         $this->withoutExceptionHandling();
        $app = App::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/apps', $app
        );

        $this->assertApiResponse($app);
    }

    /**
     * @test
     */
    public function test_read_app()
    {
        $this->withoutExceptionHandling();
        $app = App::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/apps/'.$app->id
        );

        $this->assertApiResponse($app->toArray());
    }

    /**
     * @test
     */
    public function test_update_app()
    {
        $this->withoutExceptionHandling();
        $app = App::factory()->create();
        $editedApp = App::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/apps/'.$app->id,
            $editedApp
        );

        $this->assertApiResponse($editedApp);
    }

    /**
     * @test
     */
    public function test_delete_app()
    {
        $this->withoutExceptionHandling();
        $app = App::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/apps/'.$app->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/apps/'.$app->id
        );

        $this->response->assertStatus(404);
    }
}
