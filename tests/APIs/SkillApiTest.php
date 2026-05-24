<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Skill;

class SkillApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_skill()
    {
         $this->withoutExceptionHandling();
        $skill = Skill::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/skills', $skill
        );

        $this->assertApiResponse($skill);
    }

    /**
     * @test
     */
    public function test_read_skill()
    {
        $this->withoutExceptionHandling();
        $skill = Skill::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/skills/'.$skill->id
        );

        $this->assertApiResponse($skill->toArray());
    }

    /**
     * @test
     */
    public function test_update_skill()
    {
        $this->withoutExceptionHandling();
        $skill = Skill::factory()->create();
        $editedSkill = Skill::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/skills/'.$skill->id,
            $editedSkill
        );

        $this->assertApiResponse($editedSkill);
    }

    /**
     * @test
     */
    public function test_delete_skill()
    {
        $this->withoutExceptionHandling();
        $skill = Skill::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/skills/'.$skill->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/skills/'.$skill->id
        );

        $this->response->assertStatus(404);
    }
}
