<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\District;

class DistrictApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_district()
    {
         $this->withoutExceptionHandling();
        $district = District::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/districts', $district
        );

        $this->assertApiResponse($district);
    }

    /**
     * @test
     */
    public function test_read_district()
    {
        $this->withoutExceptionHandling();
        $district = District::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/districts/'.$district->id
        );

        $this->assertApiResponse($district->toArray());
    }

    /**
     * @test
     */
    public function test_update_district()
    {
        $this->withoutExceptionHandling();
        $district = District::factory()->create();
        $editedDistrict = District::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/districts/'.$district->id,
            $editedDistrict
        );

        $this->assertApiResponse($editedDistrict);
    }

    /**
     * @test
     */
    public function test_delete_district()
    {
        $this->withoutExceptionHandling();
        $district = District::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/districts/'.$district->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/districts/'.$district->id
        );

        $this->response->assertStatus(404);
    }
}
