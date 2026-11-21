<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\NotificationRecipient;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NotificationRecipient>
 */
class NotificationRecipientFactory extends Factory
{
    protected $model = NotificationRecipient::class;

    public function definition(): array
    {
        return [
            'NotificationId' => Notification::factory(),
            'UserId' => User::factory(),
            'IsRead' => fake()->boolean(),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
