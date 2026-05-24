<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\UserProfile;

class UserProfileApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_user_profile()
    {
         $this->withoutExceptionHandling();
        $userProfile = UserProfile::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/user_profiles', $userProfile
        );

        $this->assertApiResponse($userProfile);
    }

    /**
     * @test
     */
    public function test_read_user_profile()
    {
        $this->withoutExceptionHandling();
        $userProfile = UserProfile::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/user_profiles/'.$userProfile->id
        );

        $this->assertApiResponse($userProfile->toArray());
    }

    /**
     * @test
     */
    public function test_update_user_profile()
    {
        $this->withoutExceptionHandling();
        $userProfile = UserProfile::factory()->create();
        $editedUserProfile = UserProfile::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/user_profiles/'.$userProfile->id,
            $editedUserProfile
        );

        $this->assertApiResponse($editedUserProfile);
    }

    /**
     * @test
     */
    public function test_delete_user_profile()
    {
        $this->withoutExceptionHandling();
        $userProfile = UserProfile::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/user_profiles/'.$userProfile->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/user_profiles/'.$userProfile->id
        );

        $this->response->assertStatus(404);
    }
}
