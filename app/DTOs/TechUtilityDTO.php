<?php

namespace App\DTOs;

use App\Http\Requests\Tech\StoreTechUtilityRequest;

readonly class TechUtilityDTO
{
    /**
     * @param  array<int, array{apartment_id: int, fee_type_id: int, billing_period: string, previous_reading: float, current_reading: float, consumption: float}>  $readings
     */
    public function __construct(
        public int $recordedByUserId,
        public array $readings,
    ) {}

    public static function fromRequest(StoreTechUtilityRequest $request, int $techId): self
    {
        $rawReadings = (array) $request->validated('readings', []);
        $readings = [];

        foreach ($rawReadings as $r) {
            $prev = (float) ($r['previous_reading'] ?? 0);
            $curr = (float) ($r['current_reading'] ?? 0);

            $readings[] = [
                'apartment_id' => (int) $r['apartment_id'],
                'fee_type_id' => (int) $r['fee_type_id'],
                'billing_period' => (string) ($r['billing_period'] ?? now()->format('m/Y')),
                'previous_reading' => $prev,
                'current_reading' => $curr,
                'consumption' => max(0, $curr - $prev),
            ];
        }

        return new self(
            recordedByUserId: $techId,
            readings: $readings,
        );
    }
}
