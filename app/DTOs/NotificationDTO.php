<?php

namespace App\DTOs;

use App\Http\Requests\Notification\StoreNotificationRequest;

readonly class NotificationDTO
{
    /**
     * @param  array<int, int>  $apartmentIds
     */
    public function __construct(
        public int $createdByUserId,
        public string $title,
        public string $content,
        public string $targetType,
        public ?int $buildingId = null,
        public ?int $floorId = null,
        public array $apartmentIds = [],
    ) {}

    public static function fromStoreRequest(StoreNotificationRequest $request, int $userId): self
    {
        $rawAptIds = (array) $request->validated('apartment_ids', []);
        if ($request->filled('ApartmentId')) {
            $rawAptIds[] = (int) $request->validated('ApartmentId');
        }

        return new self(
            createdByUserId: $userId,
            title: trim((string) $request->validated('Title')),
            content: trim((string) $request->validated('Content')),
            targetType: strtoupper(trim((string) $request->validated('TargetType'))),
            buildingId: $request->filled('BuildingId') ? (int) $request->validated('BuildingId') : null,
            floorId: $request->filled('FloorId') ? (int) $request->validated('FloorId') : null,
            apartmentIds: array_unique(array_filter($rawAptIds)),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'CreatedByUserId' => $this->createdByUserId,
            'Title' => $this->title,
            'Content' => $this->content,
            'TargetType' => $this->targetType,
            'CreatedAt' => now(),
            'IsDeleted' => false,
        ];
    }
}
