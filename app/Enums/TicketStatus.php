<?php

namespace App\Enums;

enum TicketStatus: string
{
    case Open = 'open';
    case InProgress = 'in_progress';
    case Resolved = 'resolved';
    case Closed = 'closed';

    public function label(): string
    {
        return match ($this) {
            self::Open => 'Open',
            self::InProgress => 'In Progress',
            self::Resolved => 'Resolved',
            self::Closed => 'Closed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::Open => 'blue',
            self::InProgress => 'yellow',
            self::Resolved => 'green',
            self::Closed => 'gray',
        };
    }

    /**
     * Status mana saja yang boleh dituju dari status ini.
     */
    public function allowedTransitions(): array
    {
        return match ($this) {
            self::Open => [self::InProgress],
            self::InProgress => [self::Resolved],
            self::Resolved => [self::Closed, self::InProgress],
            self::Closed => [],
        };
    }
}