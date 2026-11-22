<?php

namespace App\Http\Requests\Invoice;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CollectInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'PaymentType' => $this->input('PaymentType') ?? $this->input('payment_type') ?? 'TRANSFER',
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'PaymentType' => ['required', 'string', 'in:CASH,TRANSFER,Tiền mặt,Chuyển khoản'],
        ];
    }
}
