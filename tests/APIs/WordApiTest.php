<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Word;

class WordApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_word()
    {
         $this->withoutExceptionHandling();
        $word = Word::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/words', $word
        );

        $this->assertApiResponse($word);
    }

    /**
     * @test
     */
    public function test_read_word()
    {
        $this->withoutExceptionHandling();
        $word = Word::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/words/'.$word->id
        );

        $this->assertApiResponse($word->toArray());
    }

    /**
     * @test
     */
    public function test_update_word()
    {
        $this->withoutExceptionHandling();
        $word = Word::factory()->create();
        $editedWord = Word::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/words/'.$word->id,
            $editedWord
        );

        $this->assertApiResponse($editedWord);
    }

    /**
     * @test
     */
    public function test_delete_word()
    {
        $this->withoutExceptionHandling();
        $word = Word::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/words/'.$word->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/words/'.$word->id
        );

        $this->response->assertStatus(404);
    }
}
