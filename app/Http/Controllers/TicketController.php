<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreTicketRequest, DestroyTicketRequest, UpdateTicketRequest, ShowTicketRequest, EditTicketRequest};
use Inertia\Inertia;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{

    public function __construct(protected TicketService $service) {}
    
    public function index() {
        return Inertia::render('Tickets/Index');
    }

    public function store(StoreTicketRequest $request) {
        if ($ticket = $this->service->createTicket($request->validated())) {
            return to_route('tickets.show', $ticket);
        }
        return redirect()->back()->withError('Failed to create ticket.');
    }

    public function show(ShowTicketRequest $request, Ticket $ticket) {
        return Inertia::render('Tickets/Show', ['ticket' => $ticket]);
    }

    public function destroy(DestroyTicketRequest $request, Ticket $ticket) {
        $this->service->deleteTicket($ticket);
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket) {
        $this->service->updateTicket($ticket, $request->validated());
    }

    public function edit(EditTicketRequest $request, Ticket $ticket) {
        return Inertia::render('Tickets/Edit', ['ticket' => $ticket]);
    }

}
