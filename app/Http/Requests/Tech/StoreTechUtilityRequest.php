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
            foreach ($this->input('meters') as $aptId => $curr) {
                if ($curr !== null && $curr !== '') {
                    $readings[] = [
                        'apartment_id' => (int) $aptId,
                        'fee_type_id' => 1,
                        'previous_reading' => 0,
                        'current_reading' => (float) $curr,
                        'billing_period' => now()->format('m/Y'),
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
