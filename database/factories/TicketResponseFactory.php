<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketResponse>
 */
class TicketResponseFactory extends Factory
{
    protected $model = TicketResponse::class;

    public function definition(): array
    {
        return [
            'TicketId' => Ticket::factory(),
            'RespondedByUserId' => User::factory(),
            'Content' => fake()->sentence(),
            'CreatedAt' => now(),
        ];
    }
}
