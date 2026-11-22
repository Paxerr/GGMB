<?php

namespace App\Http\Requests\Tech;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreTechUtilityRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('meters') && is_array($this->input('meters')) && ! $this->has('readings')) {
            $readings = [];
            $feeTypeId = (int) ($this->input('fee_type_id') ?? 1);
            $period = (string) ($this->input('billing_period') ?? now()->format('m/Y'));
            $prevMeters = (array) $this->input('prev_meters', []);

            foreach ($this->input('meters') as $aptId => $curr) {
                if ($curr !== null && $curr !== '') {
                    $prev = (float) ($prevMeters[$aptId] ?? 0);
                    $readings[] = [
                        'apartment_id' => (int) $aptId,
                        'fee_type_id' => $feeTypeId,
                        'previous_reading' => $prev,
                        'current_reading' => (float) $curr,
                        'billing_period' => $period,
                    ];
                }
            }
            $this->merge(['readings' => $readings]);
        }
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'readings' => ['required', 'array'],
            'readings.*.apartment_id' => ['required', 'integer', 'exists:Apartment,ApartmentId'],
            'readings.*.fee_type_id' => ['required', 'integer', 'exists:FeeType,FeeTypeId'],
            'readings.*.previous_reading' => ['required', 'numeric', 'min:0'],
            'readings.*.current_reading' => ['required', 'numeric', 'min:0'],
            'readings.*.billing_period' => ['nullable', 'string', 'max:7'],
        ];
    }
}
