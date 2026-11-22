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
