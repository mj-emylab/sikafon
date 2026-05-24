<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Program;

class ProgramApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_program()
    {
         $this->withoutExceptionHandling();
        $program = Program::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/programs', $program
        );

        $this->assertApiResponse($program);
    }

    /**
     * @test
     */
    public function test_read_program()
    {
        $this->withoutExceptionHandling();
        $program = Program::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/programs/'.$program->id
        );

        $this->assertApiResponse($program->toArray());
    }

    /**
     * @test
     */
    public function test_update_program()
    {
        $this->withoutExceptionHandling();
        $program = Program::factory()->create();
        $editedProgram = Program::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/programs/'.$program->id,
            $editedProgram
        );

        $this->assertApiResponse($editedProgram);
    }

    /**
     * @test
     */
    public function test_delete_program()
    {
        $this->withoutExceptionHandling();
        $program = Program::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/programs/'.$program->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/programs/'.$program->id
        );

        $this->response->assertStatus(404);
    }
}
