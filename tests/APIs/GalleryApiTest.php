<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Gallery;

class GalleryApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_gallery()
    {
         $this->withoutExceptionHandling();
        $gallery = Gallery::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/galleries', $gallery
        );

        $this->assertApiResponse($gallery);
    }

    /**
     * @test
     */
    public function test_read_gallery()
    {
        $this->withoutExceptionHandling();
        $gallery = Gallery::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/galleries/'.$gallery->id
        );

        $this->assertApiResponse($gallery->toArray());
    }

    /**
     * @test
     */
    public function test_update_gallery()
    {
        $this->withoutExceptionHandling();
        $gallery = Gallery::factory()->create();
        $editedGallery = Gallery::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/galleries/'.$gallery->id,
            $editedGallery
        );

        $this->assertApiResponse($editedGallery);
    }

    /**
     * @test
     */
    public function test_delete_gallery()
    {
        $this->withoutExceptionHandling();
        $gallery = Gallery::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/galleries/'.$gallery->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/galleries/'.$gallery->id
        );

        $this->response->assertStatus(404);
    }
}
