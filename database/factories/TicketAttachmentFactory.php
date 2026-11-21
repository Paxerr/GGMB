<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketAttachment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TicketAttachment>
 */
class TicketAttachmentFactory extends Factory
{
    protected $model = TicketAttachment::class;

    public function definition(): array
    {
        return [
            'TicketId' => Ticket::factory(),
            'FileName' => 'minh-chung-'.fake()->numberBetween(1, 100).'.jpg',
            'FilePath' => '/demo/tickets/minh-chung.jpg',
            'ContentType' => 'image/jpeg',
            'FileSize' => fake()->numberBetween(50000, 200000),
            'UploadedByUserId' => User::factory(),
            'UploadedAt' => now(),
            'IsDeleted' => false,
            'DeletedAt' => null,
        ];
    }
}
