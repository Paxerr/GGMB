<?php

namespace App\Http\Requests\Utility;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CorrectMeterReadingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'MeterReadingId' => $this->input('MeterReadingId') ?? $this->input('id'),
            'PreviousReading' => $this->input('PreviousReading') ?? $this->input('old_num'),
            'CurrentReading' => $this->input('CurrentReading') ?? $this->input('new_num'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'MeterReadingId' => ['required', 'integer', 'exists:MeterReading,MeterReadingId'],
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
            'MeterReadingId.required' => 'Vui lòng chọn bản ghi chỉ số cần đính chính.',
            'PreviousReading.required' => 'Vui lòng nhập số cũ.',
            'CurrentReading.required' => 'Vui lòng nhập số mới.',
            'CurrentReading.gte' => 'Số mới phải lớn hơn hoặc bằng số cũ.',
        ];
    }
}
