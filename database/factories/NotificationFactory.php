<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Notification>
 */
class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        return [
            'CreatedByUserId' => User::factory(),
            'Title' => fake()->sentence(),
            'Content' => fake()->paragraph(),
            'TargetType' => fake()->randomElement(['ALL', 'BUILDING', 'FLOOR', 'APARTMENT']),
            'CreatedAt' => now(),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
