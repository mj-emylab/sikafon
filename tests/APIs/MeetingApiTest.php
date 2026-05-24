<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Meeting;

class MeetingApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_meeting()
    {
         $this->withoutExceptionHandling();
        $meeting = Meeting::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/meetings', $meeting
        );

        $this->assertApiResponse($meeting);
    }

    /**
     * @test
     */
    public function test_read_meeting()
    {
        $this->withoutExceptionHandling();
        $meeting = Meeting::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/meetings/'.$meeting->id
        );

        $this->assertApiResponse($meeting->toArray());
    }

    /**
     * @test
     */
    public function test_update_meeting()
    {
        $this->withoutExceptionHandling();
        $meeting = Meeting::factory()->create();
        $editedMeeting = Meeting::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/meetings/'.$meeting->id,
            $editedMeeting
        );

        $this->assertApiResponse($editedMeeting);
    }

    /**
     * @test
     */
    public function test_delete_meeting()
    {
        $this->withoutExceptionHandling();
        $meeting = Meeting::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/meetings/'.$meeting->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/meetings/'.$meeting->id
        );

        $this->response->assertStatus(404);
    }
}
