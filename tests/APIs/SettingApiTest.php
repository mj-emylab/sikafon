<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Setting;

class SettingApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_setting()
    {
         $this->withoutExceptionHandling();
        $setting = Setting::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/settings', $setting
        );

        $this->assertApiResponse($setting);
    }

    /**
     * @test
     */
    public function test_read_setting()
    {
        $this->withoutExceptionHandling();
        $setting = Setting::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/settings/'.$setting->id
        );

        $this->assertApiResponse($setting->toArray());
    }

    /**
     * @test
     */
    public function test_update_setting()
    {
        $this->withoutExceptionHandling();
        $setting = Setting::factory()->create();
        $editedSetting = Setting::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/settings/'.$setting->id,
            $editedSetting
        );

        $this->assertApiResponse($editedSetting);
    }

    /**
     * @test
     */
    public function test_delete_setting()
    {
        $this->withoutExceptionHandling();
        $setting = Setting::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/settings/'.$setting->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/settings/'.$setting->id
        );

        $this->response->assertStatus(404);
    }
}
