<?php namespace Tests\Repositories;

use App\Models\Share;
use App\Repositories\ShareRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;

class ShareRepositoryTest extends TestCase
{
    use ApiTestTrait, RefreshDatabase;

    /**
     * @var ShareRepository
     */
    protected $shareRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->shareRepo = \App::make(ShareRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_share()
    {
        $this->withoutExceptionHandling();
        $share = Share::factory()->make()->toArray();

        $createdShare = $this->shareRepo->create($share);

        $createdShare = $createdShare->toArray();
        $this->assertArrayHasKey('id', $createdShare);
        $this->assertNotNull($createdShare['id'], 'Created Share must have id specified');
        $this->assertNotNull(Share::find($createdShare['id']), 'Share with given id must be in DB');
        $this->assertModelData($share, $createdShare);
    }

    /**
     * @test read
     */
    public function test_read_share()
    {
        $this->withoutExceptionHandling();
        $share = Share::factory()->create();

        $dbShare = $this->shareRepo->find($share->id);

        $dbShare = $dbShare->toArray();
        $this->assertModelData($share->toArray(), $dbShare);
    }

    /**
     * @test update
     */
    public function test_update_share()
    {
        $this->withoutExceptionHandling();
        $share = Share::factory()->create();
        $fakeShare = Share::factory()->make()->toArray();

        $updatedShare = $this->shareRepo->update($fakeShare, $share->id);

        $this->assertModelData($fakeShare, $updatedShare->toArray());
        $dbShare = $this->shareRepo->find($share->id);
        $this->assertModelData($fakeShare, $dbShare->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_share()
    {
        $this->withoutExceptionHandling();
        $share = Share::factory()->create();

        $resp = $this->shareRepo->delete($share->id);

        $this->assertTrue($resp);
        $this->assertNull(Share::find($share->id), 'Share should not exist in DB');
    }
}
