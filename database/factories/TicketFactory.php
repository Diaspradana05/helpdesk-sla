<?php

namespace Database\Factories;

use App\Enums\TicketStatus;
use App\Models\Category;
use App\Models\Priority;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    public function definition(): array
    {
        $priority = Priority::inRandomOrder()->first();
        $created = fake()->dateTimeBetween('-30 days', 'now');
        $status = fake()->randomElement(TicketStatus::cases());
        $agent = $status === TicketStatus::Open
            ? null
            : User::role('agent')->inRandomOrder()->first();

        return [
            'ticket_number' => 'TKT-' . $created->format('Ymd') . '-' . fake()->unique()->numerify('####'),
            'subject' => fake()->sentence(6),
            'description' => fake()->paragraphs(2, true),
            'customer_id' => User::role('customer')->inRandomOrder()->first()->id,
            'assigned_to' => $agent?->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'priority_id' => $priority->id,
            'status' => $status,
            'first_response_due_at' => (clone $created)->modify("+{$priority->first_response_minutes} minutes"),
            'resolution_due_at' => (clone $created)->modify("+{$priority->resolution_minutes} minutes"),
            'created_at' => $created,
            'updated_at' => $created,
        ];
    }
}