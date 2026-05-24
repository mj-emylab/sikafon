<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Assembly;

class AssemblyApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_assembly()
    {
         $this->withoutExceptionHandling();
        $assembly = Assembly::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/assemblies', $assembly
        );

        $this->assertApiResponse($assembly);
    }

    /**
     * @test
     */
    public function test_read_assembly()
    {
        $this->withoutExceptionHandling();
        $assembly = Assembly::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/assemblies/'.$assembly->id
        );

        $this->assertApiResponse($assembly->toArray());
    }

    /**
     * @test
     */
    public function test_update_assembly()
    {
        $this->withoutExceptionHandling();
        $assembly = Assembly::factory()->create();
        $editedAssembly = Assembly::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/assemblies/'.$assembly->id,
            $editedAssembly
        );

        $this->assertApiResponse($editedAssembly);
    }

    /**
     * @test
     */
    public function test_delete_assembly()
    {
        $this->withoutExceptionHandling();
        $assembly = Assembly::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/assemblies/'.$assembly->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/assemblies/'.$assembly->id
        );

        $this->response->assertStatus(404);
    }
}
