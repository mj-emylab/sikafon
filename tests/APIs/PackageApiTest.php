<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Package;

class PackageApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_package()
    {
         $this->withoutExceptionHandling();
        $package = Package::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/packages', $package
        );

        $this->assertApiResponse($package);
    }

    /**
     * @test
     */
    public function test_read_package()
    {
        $this->withoutExceptionHandling();
        $package = Package::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/packages/'.$package->id
        );

        $this->assertApiResponse($package->toArray());
    }

    /**
     * @test
     */
    public function test_update_package()
    {
        $this->withoutExceptionHandling();
        $package = Package::factory()->create();
        $editedPackage = Package::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/packages/'.$package->id,
            $editedPackage
        );

        $this->assertApiResponse($editedPackage);
    }

    /**
     * @test
     */
    public function test_delete_package()
    {
        $this->withoutExceptionHandling();
        $package = Package::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/packages/'.$package->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/packages/'.$package->id
        );

        $this->response->assertStatus(404);
    }
}
