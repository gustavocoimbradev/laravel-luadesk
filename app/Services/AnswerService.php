<?php 

namespace App\Services;

use App\Models\Ticket;

class AnswerService {

    public function createAnswer(array $payload, Ticket $ticket) {
        if (($ticket->status === 2 && !auth()->user()->is_admin) || ($payload['closes_ticket'] && !auth()->user()->is_admin)) abort(403);
        $payload['ticket_id'] = $ticket->id;
        $payload['user_id'] = auth()->id();
        return $ticket->answers()->create($payload);
    }

}