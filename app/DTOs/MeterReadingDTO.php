<?php

namespace App\DTOs;

use App\Http\Requests\Utility\CorrectMeterReadingRequest;
use App\Http\Requests\Utility\StoreFirstTimeReadingRequest;

readonly class MeterReadingDTO
{
    public function __construct(
        public int $apartmentId,
        public int $feeTypeId,
        public ?int $recordedByUserId,
        public string $billingPeriod,
        public float $previousReading,
        public float $currentReading,
        public float $consumption,
    ) {}

    public static function fromFirstTimeRequest(StoreFirstTimeReadingRequest $request, int $userId): self
    {
        $prev = (float) $request->validated('PreviousReading');
        $curr = (float) $request->validated('CurrentReading');
        $consumption = max(0, $curr - $prev);

        return new self(
            apartmentId: (int) $request->validated('ApartmentId'),
            feeTypeId: (int) $request->validated('FeeTypeId'),
            recordedByUserId: $userId,
            billingPeriod: (string) $request->validated('BillingPeriod'),
            previousReading: $prev,
            currentReading: $curr,
            consumption: $consumption,
        );
    }

    public static function fromCorrectRequest(CorrectMeterReadingRequest $request, int $userId, int $aptId, int $feeTypeId, string $period): self
    {
        $prev = (float) $request->validated('PreviousReading');
        $curr = (float) $request->validated('CurrentReading');
        $consumption = max(0, $curr - $prev);

        return new self(
            apartmentId: $aptId,
            feeTypeId: $feeTypeId,
            recordedByUserId: $userId,
            billingPeriod: $period,
            previousReading: $prev,
            currentReading: $curr,
            consumption: $consumption,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toModelArray(): array
    {
        return [
            'ApartmentId' => $this->apartmentId,
            'FeeTypeId' => $this->feeTypeId,
            'RecordedByUserId' => $this->recordedByUserId,
            'BillingPeriod' => $this->billingPeriod,
            'PreviousReading' => $this->previousReading,
            'CurrentReading' => $this->currentReading,
            'Consumption' => $this->consumption,
            'RecordedAt' => now(),
        ];
    }
}
