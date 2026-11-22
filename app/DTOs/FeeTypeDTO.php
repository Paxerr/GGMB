<?php

namespace App\DTOs;

use App\Http\Requests\FeeRate\StoreFeeTypeRequest;
use App\Http\Requests\FeeRate\UpdateFeeTypeRequest;

readonly class FeeTypeDTO
{
    public function __construct(
        public string $code,
        public string $name,
        public ?string $description = null,
        public bool $isActive = true,
        public ?float $initialPrice = null,
    ) {}

    public static function fromStoreRequest(StoreFeeTypeRequest $request): self
    {
        return new self(
            code: strtoupper(trim((string) $request->validated('Code'))),
            name: trim((string) $request->validated('Name')),
            description: $request->filled('Description') ? trim((string) $request->validated('Description')) : null,
            isActive: true,
            initialPrice: $request->filled('UnitPrice') ? (float) $request->validated('UnitPrice') : null,
        );
    }

    public static function fromUpdateRequest(UpdateFeeTypeRequest $request, string $existingCode): self
    {
        return new self(
            code: $existingCode,
            name: trim((string) $request->validated('Name')),
            description: $request->filled('Description') ? trim((string) $request->validated('Description')) : null,
            isActive: (bool) ($request->validated('IsActive') ?? true),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'Code' => $this->code,
            'Name' => $this->name,
            'Description' => $this->description,
            'IsActive' => $this->isActive,
        ];
    }
}
