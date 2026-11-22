<?php

namespace App\DTOs;

use App\Http\Requests\Apartment\StoreApartmentRequest;
use App\Http\Requests\Apartment\UpdateApartmentRequest;

readonly class ApartmentDTO
{
    public function __construct(
        public int $floorId,
        public string $apartmentNumber,
        public string $status,
        public ?string $description = null,
    ) {}

    public static function fromStoreRequest(StoreApartmentRequest $request): self
    {
        return new self(
            floorId: (int) $request->validated('FloorId'),
            apartmentNumber: trim((string) $request->validated('ApartmentNumber')),
            status: (string) $request->validated('Status'),
            description: $request->filled('Description') ? trim((string) $request->validated('Description')) : null,
        );
    }

    public static function fromUpdateRequest(UpdateApartmentRequest $request, int $existingFloorId): self
    {
        return new self(
            floorId: $existingFloorId,
            apartmentNumber: trim((string) $request->validated('ApartmentNumber')),
            status: (string) $request->validated('Status'),
            description: $request->filled('Description') ? trim((string) $request->validated('Description')) : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'FloorId' => $this->floorId,
            'ApartmentNumber' => $this->apartmentNumber,
            'Status' => $this->status,
            'Description' => $this->description,
        ];
    }
}
