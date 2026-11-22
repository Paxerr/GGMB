<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'ApartmentId' => $this->input('ApartmentId') ?? $this->input('apartment_id'),
            'BillingPeriod' => $this->input('BillingPeriod') ?? $this->input('period'),
            'DueDate' => $this->input('DueDate') ?? $this->input('due_date'),
            'total_amount' => $this->input('total_amount') ?? $this->input('TotalAmount'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ApartmentId' => ['required', 'integer', 'exists:Apartment,ApartmentId'],
            'BillingPeriod' => ['required', 'string', 'max:7'],
            'DueDate' => ['required', 'date'],
            'total_amount' => ['nullable', 'numeric', 'min:0'],
            'items' => ['nullable', 'array'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'ApartmentId.required' => 'Vui lòng chọn căn hộ lập hóa đơn.',
            'BillingPeriod.required' => 'Vui lòng chọn kỳ hóa đơn (MM/YYYY).',
            'DueDate.required' => 'Vui lòng chọn hạn thanh toán.',
        ];
    }
}
