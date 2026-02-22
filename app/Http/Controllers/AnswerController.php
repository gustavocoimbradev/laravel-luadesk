<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Models\Ticket;
use App\Services\AnswerService;

class AnswerController extends Controller
{
    
    public function store(StoreAnswerRequest $request, Ticket $ticket, AnswerService $service) {
        $service->createAnswer($request->validated(), $ticket);
        return to_route('tickets.show', $ticket);
    }

}
