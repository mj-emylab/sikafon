<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\PackageItem;

class PackageItemApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_package_item()
    {
         $this->withoutExceptionHandling();
        $packageItem = PackageItem::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/package_items', $packageItem
        );

        $this->assertApiResponse($packageItem);
    }

    /**
     * @test
     */
    public function test_read_package_item()
    {
        $this->withoutExceptionHandling();
        $packageItem = PackageItem::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/package_items/'.$packageItem->id
        );

        $this->assertApiResponse($packageItem->toArray());
    }

    /**
     * @test
     */
    public function test_update_package_item()
    {
        $this->withoutExceptionHandling();
        $packageItem = PackageItem::factory()->create();
        $editedPackageItem = PackageItem::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/package_items/'.$packageItem->id,
            $editedPackageItem
        );

        $this->assertApiResponse($editedPackageItem);
    }

    /**
     * @test
     */
    public function test_delete_package_item()
    {
        $this->withoutExceptionHandling();
        $packageItem = PackageItem::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/package_items/'.$packageItem->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/package_items/'.$packageItem->id
        );

        $this->response->assertStatus(404);
    }
}
