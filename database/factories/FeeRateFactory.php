<?php

namespace Database\Factories;

use App\Models\FeeRate;
use App\Models\FeeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeeRate>
 */
class FeeRateFactory extends Factory
{
    protected $model = FeeRate::class;

    public function definition(): array
    {
        return [
            'FeeTypeId' => FeeType::factory(),
            'UnitPrice' => fake()->randomElement([3500, 18000, 12000, 100000, 200000]),
            'EffectiveFrom' => '2025-01-01',
            'EffectiveTo' => null,
            'CreatedAt' => now(),
        ];
    }
}
