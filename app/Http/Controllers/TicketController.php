<?php

namespace App\Http\Controllers;

use App\Http\Requests\{StoreTicketRequest, DestroyTicketRequest, UpdateTicketRequest, ShowTicketRequest, EditTicketRequest};
use Inertia\Inertia;
use App\Models\Ticket;
use App\Services\TicketService;
 
class TicketController extends Controller
{

    public function __construct(protected TicketService $service) {}
    
    public function index() { 
        return Inertia::render('Tickets/Index', [
            'tickets' => Ticket::viewedBy(auth()->user())
                ->with(['user','answers'])
                ->latest()
                ->get()
        ]);
    }

    public function store(StoreTicketRequest $request) {
        if ($ticket = $this->service->createTicket($request->validated())) {
            return to_route('tickets.index')->with('success', 'Ticket created successfully!');
        }
        return redirect()->back()->withError('Failed to create ticket.');
    }

    public function show(ShowTicketRequest $request, Ticket $ticket) {
        $ticket->load(['user','answers.user']);
        return Inertia::render('Tickets/Show', ['ticket' => $ticket]);
    }
    
    public function create() {
        return Inertia::render('Tickets/Create');
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
