<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\MeetingUserLog;

class MeetingUserLogApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_meeting_user_log()
    {
         $this->withoutExceptionHandling();
        $meetingUserLog = MeetingUserLog::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/meeting_user_logs', $meetingUserLog
        );

        $this->assertApiResponse($meetingUserLog);
    }

    /**
     * @test
     */
    public function test_read_meeting_user_log()
    {
        $this->withoutExceptionHandling();
        $meetingUserLog = MeetingUserLog::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/meeting_user_logs/'.$meetingUserLog->id
        );

        $this->assertApiResponse($meetingUserLog->toArray());
    }

    /**
     * @test
     */
    public function test_update_meeting_user_log()
    {
        $this->withoutExceptionHandling();
        $meetingUserLog = MeetingUserLog::factory()->create();
        $editedMeetingUserLog = MeetingUserLog::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/meeting_user_logs/'.$meetingUserLog->id,
            $editedMeetingUserLog
        );

        $this->assertApiResponse($editedMeetingUserLog);
    }

    /**
     * @test
     */
    public function test_delete_meeting_user_log()
    {
        $this->withoutExceptionHandling();
        $meetingUserLog = MeetingUserLog::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/meeting_user_logs/'.$meetingUserLog->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/meeting_user_logs/'.$meetingUserLog->id
        );

        $this->response->assertStatus(404);
    }
}
