<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    protected $model = Vehicle::class;

    public function definition(): array
    {
        return [
            'ApartmentId' => Apartment::factory(),
            'LicensePlate' => fake()->bothify('29A-#####'),
            'VehicleType' => fake()->randomElement(['MOTORBIKE', 'CAR']),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
