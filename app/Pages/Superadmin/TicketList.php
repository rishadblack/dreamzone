<?php

namespace App\Pages\Superadmin;

use App\Models\Ticket;
use App\Models\TicketComment;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Http\Common\Component;

class TicketList extends Component
{
    use LivewireAlert;

    protected $listeners = [
        'openTicketModal',
        'openTicketDetailsModal',
        'updateTicketComment' => '$refresh',
    ];

    public $ticket_id;
    public $user_id;
    public $title;
    public $details;
    public $type;
    public $priority = 1; // Normal
    public $status = 2; // Open
    public $created_at; // Open
    public $message;

    public function openTicketModal($data)
    {
        $this->reset();
        $this->dispatch('modalOpen', 'TicketModal');
        $this->editTicket($data);
    }

    public function openTicketDetailsModal($data)
    {
        $this->dispatch('modalOpen', 'TicketDetailsModal');
        $this->editTicket($data);
    }

    public function editTicket($data)
    {
        if (isset($data['id'])) {
            $Ticket = Ticket::find($data['id']);
            if ($Ticket) {
                $this->ticket_id = $Ticket->id;
                $this->title = $Ticket->title;
                $this->details = $Ticket->details;
                $this->type = $Ticket->type;
                $this->priority = $Ticket->priority;
                $this->status = $Ticket->status;
                $this->created_at = $Ticket->created_at;
            }
        }
    }

    public function storeTicket()
    {
        $this->validate([
            'title' => 'required|string|max:100',
            'details' => 'required|string',
            'type' => 'required',
            'priority' => 'required',
        ]);

        $Ticket = Ticket::findOrNew($this->ticket_id);
        $Ticket->assign_by = Auth::id();
        $Ticket->title = $this->title;
        $Ticket->details = $this->details;
        $Ticket->type = $this->type;
        $Ticket->priority = $this->priority;
        $Ticket->status = $this->status;
        $Ticket->save();

        $this->dispatch('modalClose', 'TicketModal');

        $this->dispatch('refreshdatatable');

        $this->alert('success', 'Ticket Created Successfully');

        $this->reset();
    }

    public function storeTicketComment()
    {
        $this->validate([
            'message' => 'required|string',
        ]);

        $TicketComment = new TicketComment();
        $TicketComment->ticket_id = $this->ticket_id;
        $TicketComment->user_id = Auth::id();
        $TicketComment->msg = $this->message;
        $TicketComment->status = 2;
        $TicketComment->save();

        $TicketComment->Ticket->status = 3;
        $TicketComment->Ticket->save();

        $this->emit('updateTicketComment');

        $this->dispatch('refreshdatatable');
        $this->reset('message');
    }

    public function storeTicketCommentStatus($status)
    {
        $Ticket = Ticket::find($this->ticket_id);
        $Ticket->status = $status;
        $Ticket->save();

        $this->dispatch('refreshdatatable');
        $this->dispatch('modalClose', 'TicketDetailsModal');
        $this->reset();
    }

    public function render()
    {
        $TicketComment = TicketComment::with('User:id,name,username')->where('ticket_id', $this->ticket_id)->get();

        return view('pages.ticket-list', [
            'TicketComment' => $TicketComment ? $TicketComment : [],
        ])->layout('layouts.backend-layout');
    }
}
