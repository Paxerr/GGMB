<?php

namespace App\Http\Requests\Utility;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFirstTimeReadingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ApartmentId' => $this->input('ApartmentId') ?? $this->input('apartment_id'),
            'FeeTypeId' => $this->input('FeeTypeId') ?? $this->input('fee_type_id'),
            'BillingPeriod' => $this->input('BillingPeriod') ?? $this->input('period'),
            'PreviousReading' => $this->input('PreviousReading') ?? $this->input('old_num') ?? 0,
            'CurrentReading' => $this->input('CurrentReading') ?? $this->input('new_num'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ApartmentId' => ['required', 'integer', 'exists:Apartment,ApartmentId'],
            'FeeTypeId' => ['required', 'integer', 'exists:FeeType,FeeTypeId'],
            'BillingPeriod' => ['required', 'string', 'max:7'],
            'PreviousReading' => ['required', 'numeric', 'min:0'],
            'CurrentReading' => ['required', 'numeric', 'min:0', 'gte:PreviousReading'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ApartmentId.required' => 'Vui lòng chọn căn hộ.',
            'FeeTypeId.required' => 'Vui lòng chọn loại dịch vụ (Điện/Nước).',
            'BillingPeriod.required' => 'Vui lòng nhập kỳ tính phí (MM/YYYY).',
            'CurrentReading.required' => 'Vui lòng nhập chỉ số mới ban đầu.',
            'CurrentReading.gte' => 'Chỉ số mới phải lớn hơn hoặc bằng chỉ số cũ.',
        ];
    }
}
