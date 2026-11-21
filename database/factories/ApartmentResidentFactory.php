<?php

namespace Database\Factories;

use App\Models\Apartment;
use App\Models\ApartmentResident;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ApartmentResident>
 */
class ApartmentResidentFactory extends Factory
{
    protected $model = ApartmentResident::class;

    public function definition(): array
    {
        return [
            'ApartmentId' => Apartment::factory(),
            'UserId' => User::factory(),
            'StartDate' => '2024-01-01',
            'EndDate' => null,
            'Status' => 'ACTIVE',
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
