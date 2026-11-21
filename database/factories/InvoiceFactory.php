<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Invoice>
 */
class InvoiceFactory extends Factory
{
    protected $model = Invoice::class;

    public function definition(): array
    {
        return [
            'ApartmentId' => Apartment::factory(),
            'BillingPeriod' => '02/2026',
            'TotalAmount' => fake()->numberBetween(800000, 1000000),
            'DueDate' => '2026-03-10',
            'Status' => fake()->randomElement(['UNPAID', 'PAID', 'OVERDUE', 'CANCELLED']),
            'PaymentType' => null,
            'PaidAt' => null,
            'CreatedByUserId' => User::factory(),
        ];
    }
}
