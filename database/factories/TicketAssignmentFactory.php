<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketAssignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketAssignment>
 */
class TicketAssignmentFactory extends Factory
{
    protected $model = TicketAssignment::class;

    public function definition(): array
    {
        return [
            'TicketId' => Ticket::factory(),
            'AssignedToUserId' => User::factory(),
            'AssignedAt' => now(),
        ];
    }
}
