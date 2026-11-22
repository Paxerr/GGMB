<?php

namespace App\Http\Requests\FeeRate;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreFeeTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'Code' => $this->input('Code') ?? $this->input('code'),
            'Name' => $this->input('Name') ?? $this->input('name'),
            'Description' => $this->input('Description') ?? $this->input('description'),
            'UnitPrice' => $this->input('UnitPrice') ?? $this->input('price') ?? $this->input('unit_price'),
        ]);
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Code' => ['required', 'string', 'max:30', 'unique:FeeType,Code'],
            'Name' => ['required', 'string', 'max:100'],
            'Description' => ['nullable', 'string', 'max:500'],
            'UnitPrice' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'Code.required' => 'Vui lòng nhập mã loại phí.',
            'Code.unique' => 'Mã loại phí này đã tồn tại.',
            'Name.required' => 'Vui lòng nhập tên loại phí.',
        ];
    }
}
