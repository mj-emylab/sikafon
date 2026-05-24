<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\DeletedMessage;

class DeletedMessageApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_deleted_message()
    {
         $this->withoutExceptionHandling();
        $deletedMessage = DeletedMessage::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/deleted_messages', $deletedMessage
        );

        $this->assertApiResponse($deletedMessage);
    }

    /**
     * @test
     */
    public function test_read_deleted_message()
    {
        $this->withoutExceptionHandling();
        $deletedMessage = DeletedMessage::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/deleted_messages/'.$deletedMessage->id
        );

        $this->assertApiResponse($deletedMessage->toArray());
    }

    /**
     * @test
     */
    public function test_update_deleted_message()
    {
        $this->withoutExceptionHandling();
        $deletedMessage = DeletedMessage::factory()->create();
        $editedDeletedMessage = DeletedMessage::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/deleted_messages/'.$deletedMessage->id,
            $editedDeletedMessage
        );

        $this->assertApiResponse($editedDeletedMessage);
    }

    /**
     * @test
     */
    public function test_delete_deleted_message()
    {
        $this->withoutExceptionHandling();
        $deletedMessage = DeletedMessage::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/deleted_messages/'.$deletedMessage->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/deleted_messages/'.$deletedMessage->id
        );

        $this->response->assertStatus(404);
    }
}
