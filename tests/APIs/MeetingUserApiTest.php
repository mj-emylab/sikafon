<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\MeetingUser;

class MeetingUserApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_meeting_user()
    {
         $this->withoutExceptionHandling();
        $meetingUser = MeetingUser::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/meeting_users', $meetingUser
        );

        $this->assertApiResponse($meetingUser);
    }

    /**
     * @test
     */
    public function test_read_meeting_user()
    {
        $this->withoutExceptionHandling();
        $meetingUser = MeetingUser::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/meeting_users/'.$meetingUser->id
        );

        $this->assertApiResponse($meetingUser->toArray());
    }

    /**
     * @test
     */
    public function test_update_meeting_user()
    {
        $this->withoutExceptionHandling();
        $meetingUser = MeetingUser::factory()->create();
        $editedMeetingUser = MeetingUser::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/meeting_users/'.$meetingUser->id,
            $editedMeetingUser
        );

        $this->assertApiResponse($editedMeetingUser);
    }

    /**
     * @test
     */
    public function test_delete_meeting_user()
    {
        $this->withoutExceptionHandling();
        $meetingUser = MeetingUser::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/meeting_users/'.$meetingUser->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/meeting_users/'.$meetingUser->id
        );

        $this->response->assertStatus(404);
    }
}
