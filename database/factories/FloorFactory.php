<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Floor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Floor>
 */
class FloorFactory extends Factory
{
    protected $model = Floor::class;

    public function definition(): array
    {
        return [
            'BuildingId' => Building::factory(),
            'FloorNumber' => fake()->numberBetween(1, 40),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
