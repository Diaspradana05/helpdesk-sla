<?php

namespace App\Policies;

use App\Enums\TicketStatus;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function view(User $user, Ticket $ticket): bool
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        if ($user->hasRole('agent')) {
            return $ticket->assigned_to === $user->id;
        }

        return $ticket->customer_id === $user->id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Ticket $ticket): bool
{
    if ($user->hasRole('admin')) {
        return true;
    }

    if ($user->hasRole('agent')) {
        return $ticket->assigned_to === $user->id
            && $ticket->status !== TicketStatus::Closed;
    }

    return $ticket->customer_id === $user->id
        && $ticket->status === TicketStatus::Open;
}

    public function delete(User $user, Ticket $ticket): bool
    {
        return $user->hasRole('admin');
    }

    public function updateStatus(User $user, Ticket $ticket): bool
{
    if ($user->hasRole('admin')) {
        return true;
    }

    if ($ticket->status === TicketStatus::Closed) {
        return false;
    }

    return $user->hasRole('agent') && $ticket->assigned_to === $user->id;
}

}