<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Staff;

class StaffApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_staff()
    {
         $this->withoutExceptionHandling();
        $staff = Staff::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/staff', $staff
        );

        $this->assertApiResponse($staff);
    }

    /**
     * @test
     */
    public function test_read_staff()
    {
        $this->withoutExceptionHandling();
        $staff = Staff::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/staff/'.$staff->id
        );

        $this->assertApiResponse($staff->toArray());
    }

    /**
     * @test
     */
    public function test_update_staff()
    {
        $this->withoutExceptionHandling();
        $staff = Staff::factory()->create();
        $editedStaff = Staff::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/staff/'.$staff->id,
            $editedStaff
        );

        $this->assertApiResponse($editedStaff);
    }

    /**
     * @test
     */
    public function test_delete_staff()
    {
        $this->withoutExceptionHandling();
        $staff = Staff::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/staff/'.$staff->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/staff/'.$staff->id
        );

        $this->response->assertStatus(404);
    }
}
