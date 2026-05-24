<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\AutoPost;

class AutoPostApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_auto_post()
    {
         $this->withoutExceptionHandling();
        $autoPost = AutoPost::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/auto_posts', $autoPost
        );

        $this->assertApiResponse($autoPost);
    }

    /**
     * @test
     */
    public function test_read_auto_post()
    {
        $this->withoutExceptionHandling();
        $autoPost = AutoPost::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/auto_posts/'.$autoPost->id
        );

        $this->assertApiResponse($autoPost->toArray());
    }

    /**
     * @test
     */
    public function test_update_auto_post()
    {
        $this->withoutExceptionHandling();
        $autoPost = AutoPost::factory()->create();
        $editedAutoPost = AutoPost::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/auto_posts/'.$autoPost->id,
            $editedAutoPost
        );

        $this->assertApiResponse($editedAutoPost);
    }

    /**
     * @test
     */
    public function test_delete_auto_post()
    {
        $this->withoutExceptionHandling();
        $autoPost = AutoPost::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/auto_posts/'.$autoPost->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/auto_posts/'.$autoPost->id
        );

        $this->response->assertStatus(404);
    }
}
