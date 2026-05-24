<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Blog;

class BlogApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_blog()
    {
         $this->withoutExceptionHandling();
        $blog = Blog::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/blogs', $blog
        );

        $this->assertApiResponse($blog);
    }

    /**
     * @test
     */
    public function test_read_blog()
    {
        $this->withoutExceptionHandling();
        $blog = Blog::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/blogs/'.$blog->id
        );

        $this->assertApiResponse($blog->toArray());
    }

    /**
     * @test
     */
    public function test_update_blog()
    {
        $this->withoutExceptionHandling();
        $blog = Blog::factory()->create();
        $editedBlog = Blog::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/blogs/'.$blog->id,
            $editedBlog
        );

        $this->assertApiResponse($editedBlog);
    }

    /**
     * @test
     */
    public function test_delete_blog()
    {
        $this->withoutExceptionHandling();
        $blog = Blog::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/blogs/'.$blog->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/blogs/'.$blog->id
        );

        $this->response->assertStatus(404);
    }
}
