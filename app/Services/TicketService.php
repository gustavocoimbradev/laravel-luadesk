<?php 

namespace App\Services;

use App\Models\Ticket;

class TicketService {

    public function createTicket(array $payload) {
        return auth()->user()->tickets()->create($payload);
    }

    public function deleteTicket(Ticket $ticket) {
        $ticket->delete();
    }

    public function updateTicket(Ticket $ticket, array $payload) {
        $ticket->update($payload);
    }

}