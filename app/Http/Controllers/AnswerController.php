<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    
    public function store(Request $request, Ticket $ticket) {

        $validated = $request->validate([
            'content' => 'required|string|max:50000|not_regex:/<script/i'
        ]);

        $ticket->answers()->create([
            'content'   => $validated['content'],
            'ticket_id' => $ticket->id,
            'user_id'   => auth()->id()
        ]);

        return to_route('tickets.show', $ticket);

    }

}
