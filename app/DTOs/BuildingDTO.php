<?php

namespace App\DTOs;

use App\Http\Requests\Building\StoreBuildingRequest;
use App\Http\Requests\Building\UpdateBuildingRequest;

readonly class BuildingDTO
{
    public function __construct(
        public string $buildingName,
    ) {}

    public static function fromRequest(StoreBuildingRequest|UpdateBuildingRequest $request): self
    {
        return new self(
            buildingName: trim((string) $request->validated('BuildingName')),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'BuildingName' => $this->buildingName,
        ];
    }
}
