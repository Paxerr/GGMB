<?php

namespace Database\Factories;

use App\Models\Building;
use App\Models\Notification;
use App\Models\NotificationTarget;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<NotificationTarget>
 */
class NotificationTargetFactory extends Factory
{
    protected $model = NotificationTarget::class;

    public function definition(): array
    {
        return [
            'NotificationId' => Notification::factory(),
            'BuildingId' => Building::factory(),
            'FloorId' => null,
            'ApartmentId' => null,
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
