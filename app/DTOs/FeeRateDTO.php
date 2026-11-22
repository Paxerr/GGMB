<?php

namespace App\DTOs;

use App\Http\Requests\FeeRate\StoreFeeRateRequest;

readonly class FeeRateDTO
{
    public function __construct(
        public int $feeTypeId,
        public float $unitPrice,
        public string $effectiveFrom,
        public ?string $effectiveTo = null,
    ) {}

    public static function fromStoreRequest(StoreFeeRateRequest $request, int $feeTypeId): self
    {
        return new self(
            feeTypeId: $feeTypeId,
            unitPrice: (float) $request->validated('UnitPrice'),
            effectiveFrom: (string) $request->validated('EffectiveFrom'),
            effectiveTo: $request->filled('EffectiveTo') ? (string) $request->validated('EffectiveTo') : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'FeeTypeId' => $this->feeTypeId,
            'UnitPrice' => $this->unitPrice,
            'EffectiveFrom' => $this->effectiveFrom,
            'EffectiveTo' => $this->effectiveTo,
            'CreatedAt' => now(),
        ];
    }
}
