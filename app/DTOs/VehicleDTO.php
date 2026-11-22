<?php

namespace App\DTOs;

use App\Http\Requests\Vehicle\StoreVehicleRequest;
use App\Http\Requests\Vehicle\UpdateVehicleRequest;

readonly class VehicleDTO
{
    public function __construct(
        public int $apartmentId,
        public string $licensePlate,
        public string $vehicleType,
    ) {}

    public static function fromStoreRequest(StoreVehicleRequest $request): self
    {
        $rawType = (string) $request->validated('VehicleType');
        $normalizedType = match ($rawType) {
            'Xe ô tô', 'CAR' => 'CAR',
            'Xe máy', 'MOTORBIKE' => 'MOTORBIKE',
            'Xe máy điện', 'ELECTRIC_BIKE' => 'ELECTRIC_BIKE',
            'Xe đạp', 'BICYCLE' => 'BICYCLE',
            default => strtoupper($rawType),
        };

        return new self(
            apartmentId: (int) $request->validated('ApartmentId'),
            licensePlate: strtoupper(trim((string) $request->validated('LicensePlate'))),
            vehicleType: $normalizedType,
        );
    }

    public static function fromUpdateRequest(UpdateVehicleRequest $request): self
    {
        $rawType = (string) $request->validated('VehicleType');
        $normalizedType = match ($rawType) {
            'Xe ô tô', 'CAR' => 'CAR',
            'Xe máy', 'MOTORBIKE' => 'MOTORBIKE',
            'Xe máy điện', 'ELECTRIC_BIKE' => 'ELECTRIC_BIKE',
            'Xe đạp', 'BICYCLE' => 'BICYCLE',
            default => strtoupper($rawType),
        };

        return new self(
            apartmentId: (int) $request->validated('ApartmentId'),
            licensePlate: strtoupper(trim((string) $request->validated('LicensePlate'))),
            vehicleType: $normalizedType,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'ApartmentId' => $this->apartmentId,
            'LicensePlate' => $this->licensePlate,
            'VehicleType' => $this->vehicleType,
        ];
    }
}
