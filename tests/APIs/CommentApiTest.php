<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Comment;

class CommentApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_comment()
    {
         $this->withoutExceptionHandling();
        $comment = Comment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/comments', $comment
        );

        $this->assertApiResponse($comment);
    }

    /**
     * @test
     */
    public function test_read_comment()
    {
        $this->withoutExceptionHandling();
        $comment = Comment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/comments/'.$comment->id
        );

        $this->assertApiResponse($comment->toArray());
    }

    /**
     * @test
     */
    public function test_update_comment()
    {
        $this->withoutExceptionHandling();
        $comment = Comment::factory()->create();
        $editedComment = Comment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/comments/'.$comment->id,
            $editedComment
        );

        $this->assertApiResponse($editedComment);
    }

    /**
     * @test
     */
    public function test_delete_comment()
    {
        $this->withoutExceptionHandling();
        $comment = Comment::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/comments/'.$comment->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/comments/'.$comment->id
        );

        $this->response->assertStatus(404);
    }
}
