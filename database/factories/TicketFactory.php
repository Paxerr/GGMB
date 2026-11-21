<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ticket>
 */
class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        return [
            'CreatedByUserId' => User::factory(),
            'ApartmentId' => Apartment::factory(),
            'Subject' => fake()->sentence(5),
            'Description' => fake()->paragraph(),
            'Status' => fake()->randomElement(['OPEN', 'ASSIGNED', 'IN_PROGRESS', 'RESOLVED', 'CLOSED', 'REJECTED']),
            'Category' => fake()->randomElement(['ACCOUNT', 'VEHICLE', 'TECHNICAL', 'BILLING', 'COMPLAINT', 'OTHER']),
            'ResolvedAt' => null,
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
