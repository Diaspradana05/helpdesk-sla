<?php

namespace App\Http\Controllers;

use App\Models\TicketAttachment;
use App\Enums\TicketStatus;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Ticket;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class TicketController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $tickets = Ticket::with(['customer', 'agent', 'category', 'priority'])
            ->when($user->hasRole('customer'), function ($query) use ($user) {
                $query->where('customer_id', $user->id);
            })
            ->when($user->hasRole('agent'), function ($query) use ($user) {
                $query->where('assigned_to', $user->id);
            })
            ->latest()
            ->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        $this->authorize('create', Ticket::class);

        $categories = Category::all();
        $priorities = Priority::all();
        $customers = auth()->user()->hasAnyRole(['admin', 'agent'])
            ? User::role('customer')->orderBy('name')->get()
            : collect();

        return view('tickets.create', compact('categories', 'priorities', 'customers'));
    }

    public function store(StoreTicketRequest $request)
    {
        $this->authorize('create', Ticket::class);

        $validated = $request->validated();
        $priority = Priority::findOrFail($validated['priority_id']);
        $now = now();

        $ticket = Ticket::create([
            'ticket_number' => $this->generateTicketNumber(),
            'subject' => $validated['subject'],
            'description' => $validated['description'],
            'customer_id' => $validated['customer_id'] ?? auth()->id(),
            'category_id' => $validated['category_id'],
            'priority_id' => $validated['priority_id'],
            'status' => TicketStatus::Open,
            'first_response_due_at' => $now->copy()->addMinutes($priority->first_response_minutes),
            'resolution_due_at' => $now->copy()->addMinutes($priority->resolution_minutes),
        ]);

        $this->storeAttachments($request, $ticket);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Tiket berhasil dibuat.');
    }

    public function show(Ticket $ticket)
    {
        $this->authorize('view', $ticket);

        $ticket->load(['customer', 'agent', 'category', 'priority', 'comments.user', 'attachments']);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $categories = Category::all();
        $priorities = Priority::all();

        return view('tickets.edit', compact('ticket', 'categories', 'priorities'));
    }

    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        $ticket->update($request->safe()->except('attachments'));

        $this->storeAttachments($request, $ticket);

        return redirect()->route('tickets.show', $ticket)->with('success', 'Tiket berhasil diperbarui.');
    }

    public function destroy(Ticket $ticket)
    {
        $this->authorize('delete', $ticket);

        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dihapus.');
    }

    private function generateTicketNumber(): string
    {
        do {
            $number = 'TKT-' . now()->format('Ymd') . '-' . str_pad((string) random_int(0, 9999), 4, '0', STR_PAD_LEFT);
        } while (Ticket::where('ticket_number', $number)->exists());

        return $number;
    }

    private function storeAttachments(StoreTicketRequest|UpdateTicketRequest $request, Ticket $ticket): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $file) {
            $path = $file->store('attachments', 'public');

            TicketAttachment::create([
                'ticket_id' => $ticket->id,
                'uploaded_by' => auth()->id(),
                'original_name' => $file->getClientOriginalName(),
                'path' => $path,
                'mime_type' => $file->getClientMimeType(),
                'size' => $file->getSize(),
            ]);
        }
    }

    public function updateStatus(Request $request, Ticket $ticket)
    {
        $this->authorize('updateStatus', $ticket);

        $request->validate([
            'status' => ['required', 'string'],
        ]);

        $newStatus = TicketStatus::from($request->status);

        if (! $ticket->canTransitionTo($newStatus)) {
            return back()->with(
                'error',
                "Status tidak bisa diubah dari {$ticket->status->label()} ke {$newStatus->label()}."
            );
        }

        $oldStatus = $ticket->status;
        $now = Carbon::now();

        $ticket->status = $newStatus;

        if (
            $newStatus === TicketStatus::InProgress &&
            is_null($ticket->first_responded_at)
        ) {
            $ticket->first_responded_at = $now;
        }

        if ($newStatus === TicketStatus::Resolved) {
            $ticket->resolved_at = $now;
        }

        if ($newStatus === TicketStatus::Closed) {
            $ticket->closed_at = $now;
        }

        $ticket->save();

        ActivityLog::create([
            'ticket_id' => $ticket->id,
            'user_id' => auth()->id(),
            'action' => 'status_changed',
            'description' => "Status diubah dari {$oldStatus->label()} ke {$newStatus->label()}",
            'properties' => [
                'old' => $oldStatus->value,
                'new' => $newStatus->value,
            ],
        ]);

        return redirect()
            ->route('tickets.show', $ticket)
            ->with('success', 'Status tiket berhasil diperbarui.');
    }
}