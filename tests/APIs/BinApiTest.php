<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Bin;

class BinApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_bin()
    {
         $this->withoutExceptionHandling();
        $bin = Bin::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/bins', $bin
        );

        $this->assertApiResponse($bin);
    }

    /**
     * @test
     */
    public function test_read_bin()
    {
        $this->withoutExceptionHandling();
        $bin = Bin::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/bins/'.$bin->id
        );

        $this->assertApiResponse($bin->toArray());
    }

    /**
     * @test
     */
    public function test_update_bin()
    {
        $this->withoutExceptionHandling();
        $bin = Bin::factory()->create();
        $editedBin = Bin::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/bins/'.$bin->id,
            $editedBin
        );

        $this->assertApiResponse($editedBin);
    }

    /**
     * @test
     */
    public function test_delete_bin()
    {
        $this->withoutExceptionHandling();
        $bin = Bin::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/bins/'.$bin->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/bins/'.$bin->id
        );

        $this->response->assertStatus(404);
    }
}
