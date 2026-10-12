<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with(['customer', 'agent', 'category', 'priority'])
            ->latest()
            ->paginate(15);

        return view('tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('tickets.create');
    }

    public function store(Request $request)
    {
        // Logika lengkap (validasi, nomor otomatis, SLA) ditambahkan di Blok 2
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['customer', 'agent', 'category', 'priority', 'comments.user', 'attachments']);

        return view('tickets.show', compact('ticket'));
    }

    public function edit(Ticket $ticket)
    {
        return view('tickets.edit', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        // Logika lengkap ditambahkan di Blok 2
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Tiket berhasil dihapus.');
    }
}