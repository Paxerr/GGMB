<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\FeeType;
use App\Models\MeterReading;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MeterReading>
 */
class MeterReadingFactory extends Factory
{
    protected $model = MeterReading::class;

    public function definition(): array
    {
        $prev = fake()->numberBetween(100, 200);
        $curr = $prev + fake()->numberBetween(10, 50);

        return [
            'ApartmentId' => Apartment::factory(),
            'FeeTypeId' => FeeType::factory(),
            'RecordedByUserId' => User::factory(),
            'BillingPeriod' => '02/2026',
            'PreviousReading' => $prev,
            'CurrentReading' => $curr,
            'Consumption' => $curr - $prev,
            'RecordedAt' => now(),
        ];
    }
}
