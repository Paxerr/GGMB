<?php

namespace Database\Factories;

use App\Models\FeeType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FeeType>
 */
class FeeTypeFactory extends Factory
{
    protected $model = FeeType::class;

    public function definition(): array
    {
        return [
            'Code' => strtoupper(fake()->unique()->lexify('FEE_????')),
            'Name' => fake()->word(),
            'Description' => fake()->sentence(),
            'IsActive' => true,
        ];
    }
}
