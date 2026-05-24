<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Reply;

class ReplyApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_reply()
    {
         $this->withoutExceptionHandling();
        $reply = Reply::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/replies', $reply
        );

        $this->assertApiResponse($reply);
    }

    /**
     * @test
     */
    public function test_read_reply()
    {
        $this->withoutExceptionHandling();
        $reply = Reply::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/replies/'.$reply->id
        );

        $this->assertApiResponse($reply->toArray());
    }

    /**
     * @test
     */
    public function test_update_reply()
    {
        $this->withoutExceptionHandling();
        $reply = Reply::factory()->create();
        $editedReply = Reply::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/replies/'.$reply->id,
            $editedReply
        );

        $this->assertApiResponse($editedReply);
    }

    /**
     * @test
     */
    public function test_delete_reply()
    {
        $this->withoutExceptionHandling();
        $reply = Reply::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/replies/'.$reply->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/replies/'.$reply->id
        );

        $this->response->assertStatus(404);
    }
}
