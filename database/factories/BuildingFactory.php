<?php

namespace Database\Factories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Building>
 */
class BuildingFactory extends Factory
{
    protected $model = Building::class;

    public function definition(): array
    {
        return [
            'BuildingName' => 'Tòa '.fake()->unique()->word(),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
