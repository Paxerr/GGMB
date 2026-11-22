<?php

namespace App\Http\Requests\FeeRate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFeeRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'UnitPrice' => $this->input('UnitPrice') ?? $this->input('price') ?? $this->input('unit_price'),
            'EffectiveFrom' => $this->input('EffectiveFrom') ?? $this->input('effective_from'),
            'EffectiveTo' => $this->input('EffectiveTo') ?? $this->input('effective_to'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'UnitPrice' => ['required', 'numeric', 'min:0'],
            'EffectiveFrom' => ['required', 'date'],
            'EffectiveTo' => ['nullable', 'date', 'after_or_equal:EffectiveFrom'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'UnitPrice.required' => 'Vui lòng nhập đơn giá áp dụng.',
            'EffectiveFrom.required' => 'Vui lòng chọn ngày bắt đầu áp dụng.',
            'EffectiveTo.after_or_equal' => 'Ngày kết thúc áp dụng phải lớn hơn hoặc bằng ngày bắt đầu.',
        ];
    }
}
