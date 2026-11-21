<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\Floor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Apartment>
 */
class ApartmentFactory extends Factory
{
    protected $model = Apartment::class;

    public function definition(): array
    {
        return [
            'FloorId' => Floor::factory(),
            'ApartmentNumber' => fake()->bothify('0#0#'),
            'Status' => fake()->randomElement(['AVAILABLE', 'OCCUPIED', 'INACTIVE']),
            'Description' => fake()->sentence(),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
