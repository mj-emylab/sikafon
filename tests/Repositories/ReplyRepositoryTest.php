<?php namespace Tests\Repositories;

use App\Models\Reply;
use App\Repositories\ReplyRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ReplyRepositoryTest extends TestCase
{
    use ApiTestTrait, RefreshDatabase;

    /**
     * @var ReplyRepository
     */
    protected $replyRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->replyRepo = \App::make(ReplyRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_reply()
    {
        $this->withoutExceptionHandling();
        $reply = Reply::factory()->make()->toArray();

        $createdReply = $this->replyRepo->create($reply);

        $createdReply = $createdReply->toArray();
        $this->assertArrayHasKey('id', $createdReply);
        $this->assertNotNull($createdReply['id'], 'Created Reply must have id specified');
        $this->assertNotNull(Reply::find($createdReply['id']), 'Reply with given id must be in DB');
        $this->assertModelData($reply, $createdReply);
    }

    /**
     * @test read
     */
    public function test_read_reply()
    {
        $this->withoutExceptionHandling();
        $reply = Reply::factory()->create();

        $dbReply = $this->replyRepo->find($reply->id);

        $dbReply = $dbReply->toArray();
        $this->assertModelData($reply->toArray(), $dbReply);
    }

    /**
     * @test update
     */
    public function test_update_reply()
    {
        $this->withoutExceptionHandling();
        $reply = Reply::factory()->create();
        $fakeReply = Reply::factory()->make()->toArray();

        $updatedReply = $this->replyRepo->update($fakeReply, $reply->id);

        $this->assertModelData($fakeReply, $updatedReply->toArray());
        $dbReply = $this->replyRepo->find($reply->id);
        $this->assertModelData($fakeReply, $dbReply->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_reply()
    {
        $this->withoutExceptionHandling();
        $reply = Reply::factory()->create();

        $resp = $this->replyRepo->delete($reply->id);

        $this->assertTrue($resp);
        $this->assertNull(Reply::find($reply->id), 'Reply should not exist in DB');
    }
}
