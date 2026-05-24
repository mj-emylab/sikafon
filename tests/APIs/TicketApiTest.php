<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\Ticket;

class TicketApiTest extends TestCase
{
    use ApiTestTrait,RefreshDatabase;

    /**
     * @test
     */
    public function test_create_ticket()
    {
         $this->withoutExceptionHandling();
        $ticket = Ticket::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/v1/tickets', $ticket
        );

        $this->assertApiResponse($ticket);
    }

    /**
     * @test
     */
    public function test_read_ticket()
    {
        $this->withoutExceptionHandling();
        $ticket = Ticket::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/v1/tickets/'.$ticket->id
        );

        $this->assertApiResponse($ticket->toArray());
    }

    /**
     * @test
     */
    public function test_update_ticket()
    {
        $this->withoutExceptionHandling();
        $ticket = Ticket::factory()->create();
        $editedTicket = Ticket::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/v1/tickets/'.$ticket->id,
            $editedTicket
        );

        $this->assertApiResponse($editedTicket);
    }

    /**
     * @test
     */
    public function test_delete_ticket()
    {
        $this->withoutExceptionHandling();
        $ticket = Ticket::factory()->create();

        $this->response = $this->json(
            'DELETE',
             '/api/v1/tickets/'.$ticket->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/v1/tickets/'.$ticket->id
        );

        $this->response->assertStatus(404);
    }
}
